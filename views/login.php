<?php
include_once __DIR__ . '/header.php';
?>

<main>
    <section>
        <form id="login-form" method="post">
            <input type="text" id="username" name="username" placeholder="Username..." required>
            <input type="password" id="password" name="password" placeholder="Password..." required>
            <input type="submit" name="submit" onclick="login()">
        </form>
        <p>I cant get the header to refresh itself to make the correct buttons appear after logging in, so just refresh
            yourself please.</p>
    </section>
</main>

<script type="text/javascript" src="http://localhost/views/JS/login.js"></script>


<?php
include_once __DIR__ . '/footer.php';
?>