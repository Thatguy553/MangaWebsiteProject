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
            <input type="submit" name="submit">
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
            <input type="submit" name="submit">
        </form>
    </section>
    <script>
    let API = <?php echo $_SESSION['API']; ?>;
    let UID = <?php echo $_SESSION['UID']; ?>;
    let key = "<?php echo $_SESSION['Key']; ?>";
    </script>
    <script src="https://localhost/administration/JS/series.js"></script>

</main>

<?php
include_once __DIR__ . '/../views/footer.php';
?>