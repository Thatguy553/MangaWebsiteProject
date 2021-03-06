// Variables to be used in all of the below functions
const insertURL = '/../api/chapters/insert.php'
const deleteURL = '/../api/chapters/delete.php'
const updateURL = '/../api/chapters/update.php'
let key = localStorage['api_key'];
let API = localStorage['api'];
let UID = localStorage['uid'];
let error = document.getElementsByClassName("table-error")[0];

let ChapterPage = new Vue({
    el: "#chapters-admin",

    data() {
        return {
            ChapterInfo: [],
            CreateInfo: [],
            uid: [],
            headers: [],
            UpdateInfo: [],
            DisplayCreate: false,
            DisplayUpdate: false,
            error: ""
        }
    },

    mounted() {
        this.set()
    },

    filters: {
        short: (value) => {
            if (!value) return;
            value = value.toString();
            if (value.length <= 50) return value;
            return value.slice(0, 50) + "...";

        }
    },

    methods: {
        set: function (params) {
            if (this.ChapterInfo) {
                this.ChapterInfo = [];
            }

            fetch("/../api/chapters/display.php")
                .then(res => res.json())
                .then(data => {
                    // data available here
                    if (data.body) {
                        for (let i = 0; i < data.body.length; i++) {
                            this.ChapterInfo.push({
                                uid: data.body[i].UID,
                                chnum: data.body[i].ChNum,
                                title: data.body[i].Title,
                                pages: data.body[i].Pages,
                                folder: data.body[i].Folder,
                                series: data.body[i].Series
                            });
                        }
                    }
                });

            // Assigns the existing series information to CreateInfo so that it can be used to determine which series the chapter will be created for.
            fetch("/../api/series/displaySeries.php")
                .then(res => res.json())
                .then(data => {
                    // data available here
                    if (data.body) {
                        for (let i = 0; i < data.body.length; i++) {
                            this.CreateInfo.push({ folder: data.body[i].Folder, uid: data.body[i].UID, title: data.body[i].Title });
                        }
                    }
                })
        },

        create: function (params) {
            const formData = new FormData();
            const files = document.getElementById('create-chapter-zip').files;
            const title = document.getElementById("create-chapter-title").value;
            const series = document.getElementById("create-chapter-series").value;
            const seriesNon = document.getElementById("create-chapter-series");
            const folderID = seriesNon[seriesNon.selectedIndex].id;
            const folder = document.getElementById(folderID).getAttribute("name");
            const number = document.getElementById("create-chapter-number").value;

            formData.append('files[]', files[0]);
            formData.append('title', title);
            formData.append('series', series);
            formData.append('chnum', number);
            formData.append("folder", folder);

            fetch(insertURL, {
                method: 'POST',
                headers: {
                    'UID': UID,
                    'api-key': key,
                },
                body: formData,
            })
                .then(res => res.json())
                .then((response) => {
                    if (response.chapter == "created") {
                        this.error = "Chapter was created";

                        this.set()
                    } else {
                        this.error = "Chapter could not be created";

                    }
                })
        },

        remove: function (UID, Folder, Series) {
            const formData = new FormData();
            formData.append('uid', UID);
            formData.append('folder', Folder);
            formData.append('series', Series);
            fetch(deleteURL, {
                method: 'POST',
                headers: {
                    'UID': UID,
                    'api-key': key,
                },
                body: formData,
            })
                .then(res => res.json())
                .then((response) => {
                    if (response.chapter == "deleted") {
                        this.error = "Chapter was removed";

                        this.set()
                    } else {
                        this.error = "Chapter could not be removed";

                    }
                })
        },

        update: function (params) {
            // Form Data Variables
            let UID = document.getElementById("existing-chapter-title").value;
            const formData = new FormData();
            const title = document.getElementById("update-chapter-title").value;
            const ChNum = document.getElementById("update-chapter-number").value;

            // Variables added to array to be sent back
            formData.append('uid', UID);
            formData.append('chnum', ChNum);
            formData.append('title', title);

            // Array of variables sent to update series
            fetch("/../api/chapters/update.php", {
                method: 'POST',
                headers: {
                    'UID': UID,
                    'api-key': key,
                },
                body: formData,
            })
                .then(res => res.json())
                .then((response) => {
                    if (response.chapter == "updated") {
                        this.error = "Chapter Was Updated";

                        this.set()
                    } else {
                        this.error = "Chapter could not be Updated";

                    }
                })
        }
    }
});
