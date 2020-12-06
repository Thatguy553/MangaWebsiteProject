<?php
include_once __DIR__ . '/header.php';
?>

<main>
    <section id="login-form">
        <form action="" method="post">
            <input type="text" id="username" name="username" placeholder="Username..." required>
            <input type="password" id="password" name="password" placeholder="Password..." required>
            <input type="submit" name="submit" onclick="login()">
        </form>
    </section>
</main>

<script type="text/javascript" src="http://localhost/views/JS/login.js"></script>


<?php
include_once __DIR__ . '/footer.php';
?>