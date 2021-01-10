<?php
include_once __DIR__ . '/header.php';
?>
<main>
    <section id="login-form">
        <form action="#" method="post">
            <input type="text" id="username" name="username" placeholder="Username..." required>
            <input type="password" id="password" name="password" placeholder="Password..." oninput="checkPass(this)"
                required>
            <input type="password" id="password" name="password" placeholder="Re-Input Password..."
                oninput="checkPass(this)" required>
            <input type="submit" name="submit" onclick="signup()">
        </form>
    </section>
</main>
<script type="text/javascript" src="http://localhost/views/JS/signup.js"></script>

<?php
include_once __DIR__ . '/footer.php';
?>