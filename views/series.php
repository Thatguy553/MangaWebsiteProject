<?php
include_once 'header.php';
?>
<!-- 
    Incase you are modifying this, the for loop will always create more of the element it is attached on.
    You can use data from the for loop on the element the for loop is on.
    The v-if="" statements refer to variables in the series.js for this page, if they are false the element and its children do not display.
    The brackets {{}} are what signals it is a vue thing, the content inside refers to the variables inside the vue.js data:{}
 -->

<section id="series-page">
    <!-- Series List Section and if to decide on showing this section -->
    <section v-if="SeriesList" id="list">
        <div class="series-list">
            <!-- For loop to list through and display all series -->
            <a v-for="series in SeriesInfo" :href="`/pubSeries?Series=${series[0].uid}`"
                class="series-link series-item">
                <p class="series-title">{{ series[1].name }}</p>
                <img class="series-image" :src="`../series/${series[3].folder}/${series[2].cover}`">
            </a>
        </div>
    </section>

    <!-- Series Page Info Section and if to decide on showing this section -->
    <section id="series-unique" v-if="ChaptersList">
        <div id="series-info">
            <img class="series-page-image" :src="`../series/${Seriesfolder.folder}/${SeriesCover.cover}`" alt="">
            <div class="series-info">
                <h2>{{ SeriesTitle.title }}</h2>
                <p>{{ SeriesDescription.desc }}</p>
            </div>
        </div>
        <div id="series-chapters">
            <!-- Loop to display each chapter for this series and if to check if there are chapters -->
            <div v-if="ChapInfo" v-for="info in ChapInfo" class="chapter-item">
                <a :href="`/pubSeries?Series=${uid.uid}&chnum=${info[0].chnum}`">
                    <div>
                        <span class="Number">Chapter {{ info[0].chnum }}:</span>
                        <span class="Title" v-bind:title="info[1].title">{{ info[1].title | ellipsis }}</span>
                        <span class="Pages">Pages: {{ info[2].pages }}</span>
                    </div>
                </a>
            </div>
            <!-- else incase there are no chapters -->
            <div v-else class="chapter-item">
                <p class="Number">0</p>
                <p class="Title">No Chapters</p>
            </div>
        </div>
    </section>

    <!-- Reader Section -->
    <section v-if="ChapterPage" id="reader">

        <!-- Call methods in the series.js file for this page using v-on:click -->
        <div id="top-buttons">
            <input type="button" v-on:click="last" class="last-btn" value="Last">
            <input type="button" v-on:click="next" class="next-btn" value="Next">
        </div>

        <!-- Container that holds every single page displayed -->
        <div id="image-container">
            <!-- For loop and image element to create each image element and assign it the image -->
            <img class="image" v-for="page in ChapPages"
                :src="`../series/${Seriesfolder.sfolder}/${ChapFolder.folder}/${page.img}`" :alt="page.img">
        </div>

        <!-- Same as top-buttons ^ -->
        <div id="bottom-buttons">
            <input type="button" v-on:click="last" class="last-btn" value="Last">
            <input type="button" v-on:click="next" class="next-btn" value="Next">
        </div>

    </section>
</section>
<script type="text/javascript" src="http://localhost/views/JS/series.js"></script>
<?php
include_once 'footer.php';
?>