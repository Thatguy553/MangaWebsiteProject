// Variables to be used in all of the below functions
const insertURL = '/../api/chapters/insert.php'
const deleteURL = '/../api/chapters/delete.php'
const updateURL = '/../api/chapters/update.php'

let ChapterPage = new Vue({
    data() {
        return {
            ChapterInfo: [],
            CreateInfo: [],
            uid: [],
            headers: [],
            UpdateInfo: [],
            DisplayCreate: false,
            DisplayUpdate: false,
        }
    },

    mounted() {

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
        create: function (params) {
            const formData = new FormData();
            const files = document.getElementById('create-zip').files;
            const title = document.getElementById("create-title").value;
            const series = document.getElementById("create-series").value;
            const seriesNon = document.getElementById("create-series");
            const folderID = seriesNon[seriesNon.selectedIndex].id;
            const folder = document.getElementById(folderID).getAttribute("name");
            const number = document.getElementById("create-number").value;

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
                    console.log(response)
                })
        },

        remove: function (params) {

        },

        update: function (params) {

        }
    }
});

// Sends data from the create chapter inputs to an API endpoint to be created.
create.addEventListener('submit', (e) => {
    e.preventDefault();
    unsetChapters();

    const files = document.getElementById('Czip').files;
    const formData = new FormData();
    const title = document.getElementById("Ctitle").value;
    const series = document.getElementById("Cseries").value;
    const seriesNon = document.getElementById("Cseries");
    const folderID = seriesNon[seriesNon.selectedIndex].id;
    const folder = document.getElementById(folderID).getAttribute("name");
    const number = document.getElementById("Cnumber").value;

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
    }).then((response) => {
        console.log(response)
        setChapters();
    })
})

// Called by Button to delete a series
function Delete(UID, Folder, Series) {
    unsetChapters();
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
    }).then((response) => {
        console.log(response);
        setChapters();
    })
}

// Unsets the currently assigned rows
function unsetChapters() {
    let table = document.getElementById("Chapters");
    let rows = table.rows.length;
    for (let i = 1; i < rows; i++) {
        table.deleteRow(1);
    }
}

// Fetches all series from database in an assoc array
function setChapters() {
    fetch("/../api/chapters/display.php")
        .then(res => res.json())
        .then(data => {
            // data available here
            if (data.body) {
                for (let i = 0; i < data.body.length; i++) {
                    // Find a <table> element with id="myTable":
                    let table = document.getElementById("Chapters");
                    // Create an empty <tr> element and add it to the 1st position of the table:
                    let row = table.insertRow(1);
                    // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
                    let cell1 = row.insertCell(0);
                    let cell2 = row.insertCell(1);
                    let cell3 = row.insertCell(2);
                    let cell4 = row.insertCell(3);
                    let cell5 = row.insertCell(4);
                    cell1.classList.add("list-item");
                    cell2.classList.add("list-item");
                    cell3.classList.add("list-item");
                    cell4.classList.add("list-item");
                    cell5.classList.add("list-item");

                    // Add some text to the new cells:
                    cell1.innerHTML = data.body[i].UID;
                    cell2.innerHTML = data.body[i].ChNum;
                    cell3.innerHTML = data.body[i].Title;
                    cell4.innerHTML = data.body[i].Pages;
                    cell5.innerHTML = "<button onclick='Delete(" + data.body[i].UID + ", \"" + data.body[i]
                        .Folder + "\", \"" + data.body[i].Series + "\")'>Delete</button>";

                    // Adds series to Update Dropdown
                    document.getElementById("UStitle").innerHTML += "<option id='chapter-" + data.body[i].UID +
                        "' name='" + data.body[i].Title +
                        "' value='" + data.body[i].UID + "'>" +
                        data
                            .body[i].Title + "</option>"
                }
            } else {
                let table = document.getElementById("Chapters");
                let row = table.insertRow(1);
                let cell1 = row.insertCell(0);
                let cell2 = row.insertCell(1);
                let cell3 = row.insertCell(2);
                let cell4 = row.insertCell(3);
                cell1.innerHTML = "No";
                cell2.innerHTML = "Series";
                cell3.innerHTML = "Data";
                cell4.innerHTML = "Found";

                // Adds series to Update Dropdown
                document.getElementById("UStitle").innerHTML += "<option>No Chapters</option>"
            }
        });
}

// Updates Series information.
update.addEventListener('submit', (async (e) => {
    e.preventDefault();
    unsetChapters();
    // Form Data Variables
    let UID = document.getElementById("UStitle").value;
    const formData = new FormData();
    const title = document.getElementById("Utitle").value;
    const ChNum = document.getElementById("Unumber").value;

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
    }).then((response) => {
        setChapters();
    })
}))

// Searches for specific series so that I can get the data that needs to be replaced with new data
function getSeries() {
    fetch("/../api/series/displaySeries.php")
        .then(res => res.json())
        .then(data => {
            // data available here
            if (data.body) {
                for (let i = 0; i < data.body.length; i++) {
                    document.getElementById("Cseries").innerHTML += "<option id='Sseries-" + i + "' name='" +
                        data.body[i]
                            .Folder +
                        "' value='" + data.body[i].UID + "'>" +
                        data.body[i].Title + "</option>"
                }
            }

        })
}

window.onload = setChapters(), getSeries();