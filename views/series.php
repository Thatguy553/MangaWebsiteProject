<?php
include_once 'header.php';
?>

<main id="series-page">

    <section v-if="SeriesList" id="list">
        <div class="series-list">
            <a v-for="series in SeriesInfo" :href="`/pubSeries?Series=${series[0].uid}`"
                class="series-link series-item">
                <p class="series-title">{{ series[1].name }}</p>
                <img class="series-image" :src="`../series/${series[3].folder}/${series[2].cover}`">
            </a>
        </div>
    </section>

    <section id="series-unique" v-if="ChaptersList">
        <div id="series-info">
            <img class="series-page-image" :src="`../series/${Seriesfolder.folder}/${SeriesCover.cover}`" alt="">
            <div class="series-info">
                <h2>{{ SeriesTitle.title }}</h2>
                <p>{{ SeriesDescription.desc }}</p>
            </div>
        </div>
        <div id="series-chapters">
            <div v-if="ChapInfo" v-for="info in ChapInfo" class="chapter-item">
                <a :href="`/pubSeries?Series=${uid.uid}&chnum=${info[0].chnum}`">
                    <div>
                        <p class="Number">Chapter: {{ info[0].chnum }}</p>
                        <p class="Title">{{ info[0].title }}</p>
                    </div>
                </a>
            </div>
            <div v-else class="chapter-item">
                <p class="Number">0</p>
                <p class="Title">No Chapters</p>
            </div>
        </div>
    </section>

    <section v-if="ChapterPage" id="reader">

        <!-- Work on buttons later -->
        <div id="top-buttons">
            <input type="button" v-on:click="last" class="last-btn" value="Last">
            <input type="button" v-on:click="next" class="next-btn" value="Next">
        </div>

        <div id="image-container">
            <img v-for="page in ChapPages" :src="`../series/${Seriesfolder.sfolder}/${ChapFolder.folder}/${page.img}`"
                :alt="page.img">
        </div>

        <!-- Work on buttons later -->
        <div id="bottom-buttons">
            <input type="button" v-on:click="last" class="last-btn" value="Last">
            <input type="button" v-on:click="next" class="next-btn" value="Next">
        </div>

    </section>

</main>

<?php
include_once 'footer.php';
?>