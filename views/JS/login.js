let login = document.getElementById("login-form");
// Your Client Side sitekey
let sitekey = 'YOUR_CLIENT_SIDE_KEY';

// Automatically called by google on page load
var onloadCallback = function () {
    grecaptcha.render('g-recaptcha', {
        'sitekey': sitekey
    });
};

// Called to get the captcha response when the form is submitted
function response() {
    return grecaptcha.getResponse();
}

// Listens for the form to be submitted
login.addEventListener('submit', (e) => {
    // Stops the page from refreshing or going to wherever the action='' specifys
    e.preventDefault();

    // Call the response since we know it should have been completed
    let CaptchaRes = response()

    // form array (idk the dif between this and an array it just is) to store POST data
    const formData = new FormData();
    formData.append('site-key', sitekey);
    formData.append('g-recaptcha-response', CaptchaRes)

    // Send the response data and site key for verification to google
    fetch('/../api/accounting/verify.php', {
        method: "POST",
        body: formData
    })
        // resolved the returned json
        .then(res => res.json())
        // Handle the resolved json
        .then(data => {

            // Login the user if googles verification says its OK
            if (data.Error == 'false') {
                console.log('No Errors');
                console.log(data);
                Login();
                // Otherwise just log the errors google returned
            } else {
                console.log('It seems there was errors');
                console.log(data);
            }
        })
})

function Login() {
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
        .then(res => res.json())
        .then(data => {
            console.log(data);
            localStorage['uid'] = data.UID;
            localStorage['username'] = data.user;
            localStorage['api'] = data.API;
            localStorage['api_key'] = data.Key;
            localStorage['role'] = data.role;
            window.location = "http://localhost/";
        })
}
