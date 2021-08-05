let recents = new Vue({
    el: "#home",
    data() {
        return {
            RecentList: [],
            SeriesInfo: []
        }
    },

    filters: {
        ellipsis: function (value) {
            if (!value) return '';
            value = value.toString();
            if (value.length <= 10) return value;

            return value.slice(0, 10) + "...";
        }
    },

    mounted() {
        this.set();
    },

    methods: {
        set: function (params) {
            fetch("http://localhost/api/chapters/homeDisplay.php")
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    for (let i = 0; i < data.body.length; i++) {
                        const series = data.body[i];

                        this.RecentList.push({ uid: series.UID, chnum: series.ChNum, title: "", pages: series.Pages, folder: series.Folder, created: series.Created, series: series.Series, seriesFolder: series.SeriesFolder, Image: "" });

                    }
                })
            fetch("http://localhost/api/series/displaySeries.php")
                .then(res => res.json())
                .then(data => {
                    this.RecentList.map(obj => {
                        const pp = data.body.find(el => el.UID == obj.series);
                        if (pp) {
                            console.log("changing")
                            obj.Image = pp.Image;
                            obj.title = pp.Title;
                        }
                        // console.log(obj);
                    })
                })

            console.log(this.RecentList);
        }
    }
});