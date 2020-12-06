const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const series = urlParams.get('Series');
const chapters = urlParams.get('chapter');
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
                    "<div class='series-item'><a href='/pubSeries?Series=" + series + "'><p class='series-title'>" +
                    data.body[i].Title +
                    "</p><img class='series-image' src='/../series/" +
                    data
                    .body[i].Folder + "/" +
                    data.body[i].Image + "'></a></div>";
            }
        });
}

function seriesPage(series) {
    fetch("/../api/series/searchSeries.php?UID=" + series)
        .then(res => res.json())
        .then(data => {
            document.getElementById('series-page').innerHTML +=
                "<section id='series-page'><img class='series-image' src='/../series/" + data.Folder +
                "/" + data.Image + "'><div><h2>" + data.Title +
                "</h2><p>" + data.Description + "</p></div></section>";
        })

    fetch("/../api/chapters/search.php?series=" + series)
        .then(res => res.json())
        .then(data => {
            for (let i = 0; i < data.body.length; i++) {
                document.getElementById('series-page').innerHTML +=
                    "<section id='series-chapters'><h2>Chapters</h2><div class='chapter-item'><a href='/pubSeries?Series=" +
                    series +
                    "&chapter=" + data.body[i].ChNum + "'><p class='Number'>" + data.body[i]
                    .ChNum + "</p><p class='Title'>" + data
                    .body[i].Title +
                    "</p><p class='Pages'>" + data.body[i].Pages + "</p></a></div></section>";
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

function pageArr(cFolder, sFolder) {
    const formData = new FormData();
    formData.append('cfolder', cFolder)
    formData.append('sfolder', sFolder)

    fetch("/../api/chapters/pages.php", {
            method: 'POST',
            body: formData,
        }).then(res => res.json())
        .then(data => {
            let arrLength = data.body.length - 1;
            for (let i = 2; i < arrLength - 1; i++) {
                document.getElementById("series-page").innerHTML += "<img src='/../series/" + data.body[arrLength]
                    .Page + "/" + data.body[arrLength - 1].Page + "/" + data.body[i].Page +
                    "' alt=''>"
            }
        })
}