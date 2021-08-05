<?php
include_once __DIR__ . '/header.php';
?>
<h2>Recently Updated</h2>
<section id="home">
    <section id="recents">
        <a class="recent-items" v-for="info in RecentList"
            :href="`/pubSeries?Series=${info.series}&chnum=${info.chnum}`">
            <img class="chapter-image" :src="`../series/${info.seriesFolder}/${info.Image}`" alt="">
            <p class="chapter-info"><span>Ch: {{ info.chnum }}</span> <span
                    v-bind:title="info.title">{{ info.title | ellipsis }}</span></p>
        </a>
    </section>
    <section id="links">
        <div id="announcement">
            <h2>What is Lorem Ipsum?</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap
                into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the
                release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        </div>
        <div id="socials">
            <i class="fab fa-discord"></i>
            <i class="fab fa-twitter-square"></i>
            <i class="fab fa-reddit-square"></i>
        </div>
    </section>
</section>
<script src="http://localhost/views/JS/home.js"></script>
<?php
include_once __DIR__ . '/footer.php';
?>