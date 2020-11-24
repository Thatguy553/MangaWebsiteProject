<?php
    include_once 'header.php';
?>

<div id="json"></div>

<script>
let title;
let description;

function setSeries() {
    fetch("/../api/series/displaySeries.php")
        .then(res => res.json())
        .then(data => {
            // data available here
            title = data.body[2].Title

            for (let i = 0; i < data.body.length; i++) {
                document.getElementById("json").innerHTML += "<b>Title:</b> " + data.body[i].Title +
                    "<br/><b>Description: </b>" +
                    data.body[i].Description + "<br/><br/>";
            }
        });
}

window.onload = setSeries();
</script>

<?php
    include_once 'footer.php';
?>