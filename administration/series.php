<?php
include_once __DIR__ . '/../views/header.php';
if (!$_SESSION) {
    header("Location: /");
    exit;
}

if ($_SESSION['role'] != "Admin") {
    header("Location: /");
    exit;
}
?>

<section id="series-admin">
    <h1>Series</h1>
    <!-- List Available Series (Listed from getSeries()) -->
    <div id="admin-buttons">
        <button v-on:click="DisplayCreate = !DisplayCreate">Create</button>
        <button v-on:click="DisplayUpdate = !DisplayUpdate">Update</button>
    </div>

    <section id="series-info-table">
        <table id="series">
            <tr>
                <th>UID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Chapters</th>
            </tr>
            <tr v-if="SeriesInfo" v-for="info in SeriesInfo">
                <td>{{ info[0].uid }}</td>
                <td>{{ info[1].title }}</td>
                <td v-bind:title="info[2].desc">{{ info[2].desc | short }}
                </td>
                <td>{{ info[3].chapters }}</td>
                <td><button v-on:click="remove(info[0].uid)">Delete</button></td>
            </tr>
            <tr v-else>
                <td>Null</td>
                <td>No Series</td>
                <td>Null</td>
                <td>Null</td>
            </tr>
        </table>
        <p class="table-error">{{ error }}</p>
    </section>

    <!-- Create Series Form -->
    <section v-if="DisplayCreate" id="create-series-form">
        <h1>Create series</h1>
        <div id="create">
            <input type="text" id="create-title" placeholder="Series Title..." required>
            <textarea name="description" id="create-description" cols="30" rows="10"
                required>Series Description Here...</textarea>
            <label for="create-image">Cover</label>
            <input type="file" name="image" id="create-image" required>
            <input type="submit" v-on:click="create" name="submit">
        </div>
    </section>

    <!-- Update Series Form -->
    <section v-if="DisplayUpdate" id="update-series-form">
        <h1>Update series</h1>
        <div id="update">
            <select name="title" id="update-title" required>
                <option v-for="info in SeriesInfo" :id="`series-${info[0].uid}`" :value="info[0].uid">
                    {{ info[1].title }}
                </option>
            </select>
            <textarea name="description" id="update-description" cols="30" rows="10"
                required>Series Description Here...</textarea>
            <label for="update-image">Cover</label>
            <input type="file" name="Uimage" id="update-image" required>
            <input type="submit" v-on:click="update">
        </div>
    </section>
</section>

<script src="http://localhost/administration/JS/series.js"></script>

<?php
include_once __DIR__ . '/../views/footer.php';
?>