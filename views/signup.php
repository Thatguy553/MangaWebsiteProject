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
            <input type="password" id="password" name="password" placeholder="Password..." oninput="checkPass(this)"
                required>
            <input type="password" id="password" name="password" placeholder="Re-Input Password..."
                oninput="checkPass(this)" required>
            <input type="submit" name="submit" onclick="signup()">
        </form>
    </section>
</main>

<script>
function checkPass(input) {
    if (input.value != document.getElementById('password').value) {
        input.setCustomValidity('Passwords should match.');
    } else {
        input.setCustomValidity('');
    }
}

function signup() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    console.log("User: " + username + "Pass: " + password)

    let json = {
        username: username,
        password: password,
        role: "reader"
    }

    console.log(json)

    fetch(<?php __DIR__ ?> "/../api/accounting/signup.php", {
            method: "POST",
            body: JSON.stringify(json)
        })
        .then(function(res) {
            console.log(res.text());
        })
}
</script>

<?php
include_once __DIR__ . '/footer.php';
?>