<?php
include_once 'header.php';
?>

<main id="series-page">

    <section v-if="list == true" id="list">
        <div>
            <a v-for="series in SeriesInfo" class="series-link">
                <p class="series-title">{{ series.name }}</p>
                <img class="series-image" :src="series.cover">
            </a>
        </div>

    </section>

</main>

<script src="../vue.js"></script>
<script type="text/javascript" src="http://localhost/views/JS/series.js"></script>

<?php
include_once 'footer.php';
?>