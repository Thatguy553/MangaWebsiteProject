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

<section id="chapters-admin">
    <!-- List Available Chapters (Listed from getChapters()) -->
    <div id="admin-buttons">
        <button v-on:click="DisplayCreate = !DisplayCreate">Create</button>
        <button v-on:click="DisplayUpdate = !DisplayUpdate">Update</button>
    </div>

    <section id="chapters-info-table">
        <table id="chapters">
            <tr>
                <th>Chapter</th>
                <th>Title</th>
                <th>Pages</th>
            </tr>

            <tr v-for="chapter in ChapterInfo">
                <td>{{ chapter.chnum }}</td>
                <td>{{ chapter.title }}</td>
                <td>{{ chapter.pages }}</td>
                <td><button v-on:click="remove(chapter.uid, chapter.folder, chapter.series)">Delete</button>
                </td>
            </tr>
        </table>
        <p class="table-error">{{ error }}</p>
    </section>

    <!-- Create Chapter Form -->
    <section v-if="DisplayCreate" id="create-chapter-form">
        <h1>Create Chapter</h1>
        <div id="create">
            <input type="text" name="number" id="create-chapter-number" placeholder="Chapter Number..." required>
            <select id="create-chapter-series" required>
                <option v-for="info in CreateInfo" :id="`series-${info.uid}`" :name="info.folder" :value="info.uid">
                    {{ info.title }}
                </option>
            </select>
            <input type="text" name="title" id="create-chapter-title" placeholder="Chapter Title..." required>
            <label for="create-chapter-zip">Chapter Zip File</label>
            <input type="file" name="zip" id="create-chapter-zip" required>
            <input type="submit" v-on:click="create" name="submit">
        </div>
    </section>

    <!-- Update Chapter Form -->
    <section v-if="DisplayUpdate" id="update-chapter-form">
        <h1>Update Chapter</h1>
        <div id="update">
            <select name="title" id="existing-chapter-title" required>
                <option v-if="ChapterInfo" v-for="info in ChapterInfo" :id="`chapter-${info.uid}`"
                    :name="`series-${info.seriesuid}`" :value="info.uid">{{ info.title }}</option>
                <option v-else>No Existing Chapters</option>
            </select>
            <input type="text" name="Utitle" id="update-chapter-title" placeholder='New Title...' required>
            <input type="text" name="number" id="update-chapter-number" placeholder="New Chapter Number..." required>
            <input type="submit" v-on:click="update" name="submit">
        </div>
    </section>
</section>

<script src="http://localhost/administration/JS/chapters.js"></script>

</main>

<?php
include_once __DIR__ . '/../views/footer.php';
?>