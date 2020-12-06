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
    let json = {
        username: username,
        password: password
    }
    fetch("/../api/accounting/signup.php", {
            method: "POST",
            body: JSON.stringify(json)
        })
        .then(function(res) {
            console.log(res.text());
        })
}