<?php
include_once 'header.php';
?>

<main id="series-page"></main>

<script>
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const series = urlParams.get('Series');
if (!queryString) {
    window.onload = seriesList();
} else {
    console.log(queryString);
    console.log(series);
    window.onload = seriesPage(series);
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
            console.log(data)
            document.getElementById('series-page').innerHTML +=
                "<section><img class='series-image' src='/../series/" + data.Folder +
                "/" + data.Image + "'><div><h2>" + data.Title +
                "</h2><p>" + data.Description + "</p></div></section><div><h2>Chapters</h2></div>";
        })
}
</script>

<?php
include_once 'footer.php';
?>