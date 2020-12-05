<?php
include_once __DIR__ . '/../views/header.php';
?>

<main>
    <!-- List Available Chapters (Listed from getChapters()) -->
    <section>
        <table id="Chapters">
            <tr>
                <th>UID</th>
                <th>Chapter</th>
                <th>Title</th>
                <th>Pages</th>
            </tr>
        </table>
    </section>

    <!-- Create Chapter Form -->
    <section>
        <h1>Create Chapter</h1>
        <form id="create" action="" method="post" enctype="multipart/form-data">
            <input type="text" name="number" id="Cnumber" placeholder="Chapter Number..." required>
            <select id="Cseries" required>

            </select>
            <input type="text" name="title" id="Ctitle" placeholder="Chapter Title..." required>
            <input type="file" name="zip" id="Czip" required>
            <input type="submit" name="submit">
        </form>
    </section>

    <!-- Update Chapter Form -->
    <section>
        <h1>Update Chapter</h1>
        <form id="update" action="" method="post" enctype="multipart/form-data">
            <select name="title" id="UStitle" required>

            </select>
            <input type="text" name="Utitle" id="Utitle" placeholder='New Title...' required>
            <input type="text" name="number" id="Unumber" placeholder="New Chapter Number..." required>
            <input type="submit" name="submit">
        </form>
    </section>

    <!-- JS probably should be moved to its own file, for some reason the file doesnt get loaded though. -->
    <script>
    // Variables to be used in all of the below functions
    const insertURL = '/../api/chapters/insert.php'
    const deleteURL = '/../api/chapters/delete.php'
    const updateURL = '/../api/chapters/update.php'
    const create = document.getElementById('create')
    const update = document.getElementById('update')

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

        console.log(folder);

        formData.append('files[]', files[0]);
        formData.append('title', title);
        formData.append('series', series);
        formData.append('chnum', number);
        formData.append("folder", folder);

        fetch(insertURL, {
            method: 'POST',
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
        console.log(rows);
        for (let i = 1; i < rows; i++) {
            console.log("Unset: " + i);
            table.deleteRow(1);
        }
    }

    // Fetches all series from database in an assoc array
    function setChapters() {
        fetch("/../api/chapters/display.php")
            .then(res => res.json())
            .then(data => {
                // data available here
                console.log(data);
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
            body: formData,
        }).then((response) => {
            console.log(response)
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
    </script>

</main>

<?php
include_once __DIR__ . '/../views/footer.php';
?>