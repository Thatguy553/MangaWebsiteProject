const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
let series = urlParams.get('Series');
let chapters = urlParams.get('chnum');
window.onload = seriesList();


function seriesList() {
    let seriesList = new Vue({
        el: '#series-page',
        data: {
            // Series List Vars
            SeriesList: !series && !chapters,
            SeriesInfo: [],

            // Series Page Vars
            ChaptersList: !chapters && series,
            uid: "",
            SeriesTitle: "",
            SeriesDescription: "",
            SeriesCover: "",
            Seriesfolder: "",
            ChapInfo: [],

            // Chapter Page
            CurChap: chapters,
            ChapterPage: chapters && series,
            ChapFolder: "",
            ChapPages: [],
            Chapters: 0
        },

        methods: {
            // Chapter Buttons
            next: function (event) {
                if (parseInt(this.CurChap) <= this.Chapters.chaps) {
                    console.log("Next Chap");
                    urlParams.set("chnum", parseInt(chapters) + 1);
                    history.pushState(null, null, "?" + urlParams.toString())
                    location.reload()
                }
            },
            last: function (event) {
                if (parseInt(this.CurChap) >= this.Chapters.chaps) {
                    console.log("Last Chap");
                    urlParams.set("chnum", parseInt(chapters) - 1);
                    history.pushState(null, null, "?" + urlParams.toString())
                    location.reload()
                }
            }
        },

        mounted() {
            // Series List
            fetch("/../api/series/displaySeries.php")
                .then(res => res.json())
                .then(data => {
                    for (let i = 0; i < data.body.length; i++) {
                        this.SeriesInfo.push([{ uid: data.body[i].UID }, { name: data.body[i].Title }, { cover: data.body[i].Image }, { folder: data.body[i].Folder }]);
                    }
                })

            // Series Page
            if (series && !chapters) {
                fetch("http://localhost/api/series/searchSeries.php?UID=" + series)
                    .then(res => res.json())
                    .then(data => {
                        this.uid = { uid: data.UID };
                        this.SeriesTitle = { title: data.Title };
                        this.SeriesDescription = { desc: data.Description };
                        this.SeriesCover = { cover: data.Image };
                        this.Seriesfolder = { folder: data.Folder };
                    })

                fetch("http://localhost/api/chapters/search.php?series=" + series)
                    .then(res => res.json())
                    .then(data => {
                        for (let i = 0; i < data.body.length; i++) {
                            this.ChapInfo.push([{ chnum: data.body[i].ChNum }, { title: data.body[i].Title }, { pages: data.body[i].Pages }]);
                        }
                        // console.log(this.ChapInfo);
                    })
            };

            // Chapter page
            if (series && chapters) {
                fetch("/../api/chapters/searchSingle.php?series=" + series + "&chnum=" + chapters)
                    .then(res => res.json())
                    .then(data => {
                        this.ChapFolder = { folder: data.Folder };
                        this.Seriesfolder = { sfolder: data.SeriesFolder };

                        const formData = new FormData();
                        formData.append('cfolder', data.Folder);
                        formData.append('sfolder', data.SeriesFolder);
                        fetch("/../api/chapters/pages.php", {
                            method: 'POST',
                            body: formData,
                        })
                            .then(res => res.json())
                            .then(data => {
                                let arrLength = data.body.length;
                                for (let i = 2; i < arrLength - 1; i++) {
                                    this.ChapPages.push({ img: data.body[i].Page });
                                }
                            })
                    })

                fetch("/../api/series/searchSeries.php?UID=" + series)
                    .then(res => res.json())
                    .then(data => {
                        this.Chapters = { chaps: data.Chapters };
                    })
            }
        }
    })
}