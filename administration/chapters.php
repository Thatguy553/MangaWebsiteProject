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
    <script src="https://localhost/administration/JS/chapters.js"></script>

</main>

<?php
include_once __DIR__ . '/../views/footer.php';
?>