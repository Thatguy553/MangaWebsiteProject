// Variables to be used in all of the below functions
const insertURL = 'http://localhost/api/series/insertSeries.php';
const deleteURL = 'http://localhost/api/series/deleteSeries.php';
const updateURL = 'http://localhost/api/series/updateSeries.php';
let key = localStorage['api_key'];
let API = localStorage['api'];
let UID = localStorage['uid'];

let SeriesPage = new Vue({
    el: "#series-admin",
    data() {
        return {
            SeriesInfo: [],
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

    methods: {
        set: function (params) {
            if (this.SeriesInfo) {
                this.SeriesInfo = [];
            }
            fetch("http://localhost/api/series/displaySeries.php")
                .then(res => res.json())
                .then(data => {
                    for (let i = 0; i < data.body.length; i++) {
                        const element = data.body[i];

                        this.SeriesInfo.push([{ uid: element.UID }, { title: element.Title }, { desc: element.Description }, { chapters: element.Chapters }, { folder: element.Folder }, { image: element.Image }]);
                    };
                });
        },

        create: function (event) {
            let title = document.getElementById("create-title").value;
            let description = document.getElementById("create-description").value;
            let files = document.getElementById('create-image').files;
            let formData = new FormData();

            formData.append('files[]', files[0]);
            formData.append('title', title);
            formData.append('description', description);

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
                    if (response.series == "created") {
                        this.error = "Series Created.";

                        this.set();
                    } else {

                        this.error = "Series Could Not Be Created.";
                    }
                });
        },

        remove: function (uid) {

            const formData = new FormData();
            formData.append('uid', uid)
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
                    if (response.series == "deleted") {
                        this.error = "Series Was Deleted";
                        this.set();
                    } else {

                        this.error = "Series Could Not Be Deleted";
                    }
                })
        },

        update: function (event) {
            // Form Data Variables
            let UID = document.getElementById("update-title").value;
            const title = document.getElementById("series-" + UID).getAttribute('name');
            const description = document.getElementById("update-description").value;
            const Images = document.getElementById('update-image').files;
            const formData = new FormData();
            let index;
            for (let i = 0; i < this.SeriesInfo.length; i++) {
                const element = this.SeriesInfo[i][0];
                if (element.uid == UID.toString()) {
                    index = i;
                }
            }
            let ExistingInfo = this.SeriesInfo[index];
            // Variables added to array to be sent back
            formData.append('files[]', Images[0]);
            formData.append('uid', UID);
            formData.append('description', description);
            formData.append('folder', ExistingInfo[4].folder);
            formData.append('EImage', ExistingInfo[5].image);

            // Array of variables sent to update series
            fetch("http://localhost/api/series/updateSeries.php", {
                method: 'POST',
                headers: {
                    'UID': UID,
                    'api-key': key,
                },
                body: formData,
            })
                .then(res => res.json())
                .then((response) => {
                    if (response.series == "updated") {

                        this.error = "Series Was Updated.";
                        this.set();
                    } else {

                        this.error = "Series Could Not Be Updated";
                    }
                })
        },
    },

    filters: {
        short: (value) => {
            if (!value) return;
            value = value.toString();
            if (value.length <= 50) return value;
            return value.slice(0, 50) + "...";

        }
    },

    mounted() {
        // Puts the info for the series table into an array.
        this.set();
    }
});

