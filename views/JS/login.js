function login() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    let json = {
        username: username,
        password: password
    }

    fetch("/../api/accounting/login.php", {
        method: "POST",
        body: JSON.stringify(json)
    })
}