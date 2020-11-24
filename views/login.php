<?php
include_once __DIR__ . '/header.php';
if ($_SESSION) {
    header("Location: /");
    exit;
}
?>

<main>
    <section id="login-form">
        <form action="#" method="post">
            <input type="text" id="username" name="username" placeholder="Username..." required>
            <input type="password" id="password" name="password" placeholder="Password..." required>
            <input type="submit" name="submit" onclick="login()">
        </form>
    </section>
</main>

<script>
function login() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    let json = {
        username: username,
        password: password
    }

    fetch(<?php __DIR__ ?> "/../api/accounting/login.php", {
        method: "POST",
        body: JSON.stringify(json)
    })

    location.reload()
}
</script>

<?php
include_once __DIR__ . '/footer.php';
?>