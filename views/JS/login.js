let login = document.getElementById("login-form");

login.addEventListener('submit', (e) => {
    e.preventDefault();

    let username = document.getElementById("login-username").value;
    let password = document.getElementById("login-password").value;

    let json = {
        username: username,
        password: password
    }

    fetch("/../api/accounting/login.php", {
        method: "POST",
        body: JSON.stringify(json)
    })

    window.location = "http://localhost/";
})