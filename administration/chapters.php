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
    <section id="create-chapter-form">
        <h1>Create Chapter</h1>
        <form id="create" action="" method="post" enctype="multipart/form-data">
            <input type="text" name="number" id="create-chapter-number" placeholder="Chapter Number..." required>
            <select id="create-chapter-series" required>
                <option v-for="info in CreateInfo" :id="`series-${info[0].uid}`" :name="info[2].folder"
                    :value="info[0].uid">{{ info[1].title }}
                </option>
            </select>
            <label for="create-chapter-zip">Chapter Zip File</label>
            <input type="file" name="zip" id="create-chapter-zip" required>
            <input type="submit" name="submit">
        </form>
    </section>

    <!-- Update Chapter Form -->
    <section id="update-chapter-form">
        <h1>Update Chapter</h1>
        <form id="update" action="" method="post" enctype="multipart/form-data">
            <select name="title" id="update-chapter-title" required>
                <option v-for="info in UpdateInfo" :id="`chapter-${info[0].uid}`" :name="`series-${info[1].seriesuid}`"
                    :value=""></option>
            </select>
            <input type="text" name="Utitle" id="update-chapter-title" placeholder='New Title...' required>
            <input type="text" name="number" id="update-chapter-number" placeholder="New Chapter Number..." required>
            <input type="submit" name="submit">
        </form>
    </section>
</section>

<script>
let API = <?php echo $_SESSION['API']; ?>;
let UID = <?php echo $_SESSION['UID']; ?>;
let key = "<?php echo $_SESSION['Key']; ?>";
console.log(key);
</script>
<script src="http://localhost/administration/JS/chapters.js"></script>

</main>

<?php
include_once __DIR__ . '/../views/footer.php';
?>