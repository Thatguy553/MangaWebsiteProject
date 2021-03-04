function checkPass(input) {
    if (input.value != document.getElementById('signup-password').value) {
        input.setCustomValidity('Passwords should match.');
    } else {
        input.setCustomValidity('');
    }
}

function signup() {
    let username = document.getElementById("signup-username").value;
    let password = document.getElementById("signup-password").value;
    let json = {
        username: username,
        password: password
    }
    fetch("/../api/accounting/signup.php", {
        method: "POST",
        body: JSON.stringify(json)
    })
        .then(function (res) {
            console.log(res.text());
        })
}