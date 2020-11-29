<?php
include_once __DIR__ . '/../views/header.php';
?>

<main>
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

    <section>
        <h1>Create series</h1>
        <form id="create" action="" method="post" enctype="multipart/form-data">
            <input type="text" name="title" id="title" placeholder="Series Title..." required>
            <textarea name="description" id="description" cols="30" rows="10"
                required>Series Description Here...</textarea>
            <input type="file" name="image" id="image" required>
            <input type="submit" name="submit" onclick="
        document.getElementsByClassName('series-item').innerHTML = ''" onmouseout="setSeries()">
        </form>
    </section>

    <section>
        <h1>Update series</h1>
        <form id="update" action="" method="post" enctype="multipart/form-data">
            <input type="text" name="title" id="title" placeholder="Series Title..." required>
            <textarea name="description" id="description" cols="30" rows="10"
                required>Series Description Here...</textarea>
            <input type="file" name="image" id="image">
            <input type="submit" name="submit" onclick="
        document.getElementsByClassName('series-item').innerHTML = ''" onmouseout="setSeries()">
        </form>
    </section>

    <script>
    const insertURL = '/../api/series/insertSeries.php'
    const deleteURL = '/../api/series/deleteSeries.php'
    const updateURL = '/../api/series/updateSeries.php'
    const create = document.getElementById('create')
    const update = document.getElementById('update')

    create.addEventListener('submit', (e) => {
        e.preventDefault()

        const files = document.querySelector('[type=file]').files
        const formData = new FormData()
        const title = document.getElementById("title").value
        const description = document.getElementById("description").value

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



    function setSeries() {
        fetch("/../api/series/displaySeries.php")
            .then(res => res.json())
            .then(data => {
                // data available here

                for (let i = 0; i < data.body.length; i++) {
                    document.getElementById("series").innerHTML += "<tr class='series-item'><td>" + data.body[i]
                        .UID + "</td><td>" +
                        data.body[i].Title +
                        "</td><td>" +
                        data.body[i].Description + "</td><td>" + data.body[i].Chapters +
                        "</td><td><button onclick='Delete(" + data.body[i].UID + ")'>Delete</button></tr>";
                }
            });
    }

    window.onload = setSeries();
    </script>

</main>

<?php
include_once __DIR__ . '/../views/footer.php';
?>