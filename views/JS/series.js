const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
let series = urlParams.get('Series');
let chapters = urlParams.get('chapter');
if (!queryString) {
    window.onload = seriesList();
} else if (series && !chapters) {
    console.log(queryString);
    console.log(series);
    window.onload = seriesPage(series);
} else if (series && chapters) {
    window.onload = chapterPage(series, chapters);
}

function seriesList() {
    fetch("/../api/series/displaySeries.php")
        .then(res => res.json())
        .then(data => {
            // data available here
            for (let i = 0; i < data.body.length; i++) {
                let series = data.body[i].UID
                // series = series.slice(7, series.length)
                document.getElementById("series-page").innerHTML +=
                    "<div class='series-item'><a class='series-link' href='/pubSeries?Series=" + series + "'><p class='series-title'>" +
                    data.body[i].Title +
                    "</p><img class='series-image' src='/../series/" +
                    data
                    .body[i].Folder + "/" +
                    data.body[i].Image + "'></a></div>";
            }
        });
}

function seriesPage(series) {

    document.getElementById('series-page').innerHTML += "<section id='series-unique'></section>"
    fetch("http://localhost/api/series/searchSeries.php?UID=" + series)
        .then(res => res.json())
        .then(data => {
            document.getElementById('series-unique').innerHTML +=
                "<section id='series-info'><img class='series-page-image' src='/../series/" + data.Folder +
                "/" + data.Image + "'><div class='series-info'><h2>" + data.Title +
                "</h2><p>" + data.Description + "</p></div></section>";
        })

    fetch("http://localhost/api/chapters/search.php?series=" + series)
        .then(res => res.json())
        .then(data => {
            document.getElementById("series-unique").innerHTML += "<h2>Chapters</h2><section id='series-chapters'></section>";
            for (let i = 0; i < data.body.length; i++) {
                document.getElementById('series-chapters').innerHTML +=
                    "<div class='chapter-item'><a href='/pubSeries?Series=" +
                    series +
                    "&chapter=" + data.body[i].ChNum + "'><div><p class='Number'>Chapter " + data.body[i]
                    .ChNum + ":</p><p class='Title'>" + data
                    .body[i].Title +
                    "</p></div><p class='Pages'>Length: " + data.body[i].Pages + " pages</p></a></div>";
            }
        })
}

function chapterPage(series, chapter) {
    fetch("/../api/chapters/searchSingle.php?series=" + series + "&chnum=" + chapter)
        .then(res => res.json())
        .then(data => {
            pageArr(data.Folder, data.SeriesFolder);
        })

}

async function pageArr(cFolder, sFolder) {
    const formData = new FormData();
    formData.append('cfolder', cFolder)
    formData.append('sfolder', sFolder)
    fetch("/../api/series/searchSeries.php?UID=" + series)
        .then(res => res.json())
        .then(data => {
            let chnum = data.Chapters;
            fetch("/../api/chapters/pages.php", {
                method: 'POST',
                body: formData,
            })
                .then(res => res.json())
                .then(data => {
                    let arrLength = data.body.length - 1;
                    chapters = parseInt(chapters);
                    document.getElementById("series-page").innerHTML += "<section id='reader'><div id='top-buttons'></div></section>";
                    for (let i = 2; i < arrLength - 1; i++) {
                        document.getElementById("reader").innerHTML += "<img class='image' src='/../series/" + data.body[arrLength]
                            .Page + "/" + data.body[arrLength - 1].Page + "/" + data.body[i].Page +
                            "' alt=''>"
                    }
                    document.getElementById("reader").innerHTML += "<div id='bottom-buttons'></div>";
                    if (arrLength > 1 && chapters > 1) {
                        document.getElementById("top-buttons").innerHTML += "<a href='/pubSeries?Series="+series+"&chapter="+(chapters - 1)+"'>Back</a>";
                        document.getElementById("bottom-buttons").innerHTML += "<a href='/pubSeries?Series="+series+"&chapter="+(chapters - 1)+"'>Back</a>";
                    } else {
                        document.getElementById("top-buttons").innerHTML += "<a href='/pubSeries?Series="+series+"'>Back</a>";
                        document.getElementById("bottom-buttons").innerHTML += "<a href='/pubSeries?Series="+series+"'>Back</a>";
                    }
                    if (arrLength > 1 && chapters < chnum) {
                        document.getElementById("top-buttons").innerHTML += "<a href='/pubSeries?Series="+series+"&chapter="+ (chapters + 1) +"'>Next</a>";
                        document.getElementById("bottom-buttons").innerHTML += "<a href='/pubSeries?Series="+series+"&chapter="+ (chapters + 1) +"'>Next</a>";
                    } else {
                        document.getElementById("top-buttons").innerHTML += "<a href='/pubSeries?Series="+series+"'>Next</a>";
                        document.getElementById("bottom-buttons").innerHTML += "<a href='/pubSeries?Series="+series+"'>Next</a>";
                    }
            })
        })
}