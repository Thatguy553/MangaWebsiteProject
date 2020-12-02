<?php
include_once __DIR__ . '/../views/header.php';
?>

<main>
    <!-- List Available Series (Listed from getSeries()) -->
    <section>
        <table id="series">
            <tr>
                <th>UID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Chapters</th>
            </tr>
        </table>
    </section>

    <!-- Create Series Form -->
    <section>
        <h1>Create series</h1>
        <form id="create" action="" method="post" enctype="multipart/form-data">
            <input type="text" name="title" id="Ctitle" placeholder="Series Title..." required>
            <textarea name="description" id="Cdescription" cols="30" rows="10"
                required>Series Description Here...</textarea>
            <input type="file" name="image" id="Cimage" required>
            <input type="submit" name="submit" onclick="
        document.getElementsByClassName('series-item').innerHTML = ''" onmouseout="setSeries()">
        </form>
    </section>

    <!-- Update Series Form -->
    <section>
        <h1>Update series</h1>
        <form id="update" action="" method="post" enctype="multipart/form-data">
            <select name="title" id="Utitle" required>

            </select>
            <textarea name="description" id="Udescription" cols="30" rows="10"
                required>Series Description Here...</textarea>
            <input type="file" name="Uimage" id="Uimage" required>
            <input type="submit" name="submit" onclick="
        document.getElementsByClassName('series-item').innerHTML = ''" onmouseout="setSeries()">
        </form>
    </section>

    <!-- JS probably should be moved to its own file, for some reason the file doesnt get loaded though. -->
    <script>
    // Variables to be used in all of the below functions
    const insertURL = '/../api/series/insertSeries.php'
    const deleteURL = '/../api/series/deleteSeries.php'
    const updateURL = '/../api/series/updateSeries.php'
    const create = document.getElementById('create')
    const update = document.getElementById('update')

    // Sends data from the create series inputs to an API endpoint to be created.
    create.addEventListener('submit', (e) => {
        e.preventDefault()

        const files = document.getElementById('Cimage').files
        const formData = new FormData()
        const title = document.getElementById("Ctitle").value
        const description = document.getElementById("Cdescription").value

        formData.append('files[]', files[0])

        formData.append('title', title)
        formData.append('description', description)

        fetch(insertURL, {
            method: 'POST',
            body: formData,
        }).then((response) => {
            console.log(response)
        })
    })

    // Called by Button to delete a series
    function Delete(UID) {
        const formData = new FormData()

        formData.append('uid', UID)

        fetch(deleteURL, {
            method: 'POST',
            body: formData,
        }).then((response) => {
            console.log(response)
        })
    }

    // Fetches all series from database in an assoc array
    function setSeries() {
        fetch("/../api/series/displaySeries.php")
            .then(res => res.json())
            .then(data => {
                // data available here
                if (data.body) {
                    for (let i = 0; i < data.body.length; i++) {
                        // Adds series to list of series information
                        document.getElementById("series").innerHTML += "<tr class='series-item'><td>" + data.body[i]
                            .UID + "</td><td>" +
                            data.body[i].Title +
                            "</td><td>" +
                            data.body[i].Description + "</td><td>" + data.body[i].Chapters +
                            "</td><td><button onclick='Delete(" + data.body[i].UID + ")'>Delete</button></tr>";

                        // Adds series to Update Dropdown
                        document.getElementById("Utitle").innerHTML += "<option id='series-" + data.body[i].UID +
                            "' name='" + data.body[i].Title +
                            "' value='" + data.body[i].UID + "'>" +
                            data
                            .body[i].Title + "</option>"
                    }
                } else {
                    document.getElementById("series").innerHTML +=
                        "<tr class='series-item'><td>No Series</td></tr>";

                    // Adds series to Update Dropdown
                    document.getElementById("Utitle").innerHTML += "<option>No Series</option>"
                }
            });
    }

    // Updates Series information.
    update.addEventListener('submit', (async (e) => {
        e.preventDefault()

        // Form Data Variables
        let UID = document.getElementById("Utitle").value
        const Images = document.getElementById('Uimage').files
        const formData = new FormData()
        const title = document.getElementById("series-" + UID).getAttribute('name')
        const description = document.getElementById("Udescription").value

        // Variables added to array to be sent back
        formData.append('files[]', Images[0])
        formData.append('uid', UID)
        formData.append('title', title)
        formData.append('description', description)
        let curInfo = await returnSeries(UID)
        formData.append('folder', curInfo['folder'])
        formData.append('EImage', curInfo['EImage'])

        // Array of variables sent to update series
        fetch("/../api/series/updateSeries.php", {
            method: 'POST',
            body: formData,
        }).then((response) => {
            console.log(response)
        })
    }))

    // Searches for specific series so that I can get the data that needs to be replaced with new data
    async function getSeries(UID) {
        let series = await fetch("/../api/series/searchSeries.php?UID=" + UID);
        let data = await series.json()
        return data;
    }

    // This function can be cleaned up and merged with getSeries(), it simply takes the info gotten from getSeries() and assigns it to an array.
    async function returnSeries(UID) {
        const dataset = await getSeries(UID);
        let seriesInfo = [];
        seriesInfo['folder'] = dataset.Folder
        seriesInfo['EImage'] = dataset.Image

        return seriesInfo;
    }

    window.onload = setSeries();
    </script>

</main>

<?php
include_once __DIR__ . '/../views/footer.php';
?>