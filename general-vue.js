if (logout.includes("true")) {
    // localStorage.clear();
    document.cookie = `uid=; expires=Thu, 01 Jan 1970 00:00:00 UTC;`;
    document.cookie = `username=; expires=Thu, 01 Jan 1970 00:00:00 UTC;`;
    document.cookie = `api=; expires=Thu, 01 Jan 1970 00:00:00 UTC;`;
    document.cookie = `api_key=; expires=Thu, 01 Jan 1970 00:00:00 UTC;`;
    document.cookie = `role=; expires=Thu, 01 Jan 1970 00:00:00 UTC;`;
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

let header = new Vue({
    el: "#header",
    data() {
        return {
            loggedin: false,
            admin: false,
            role: getCookie("role"),
            username: getCookie("username")
        }
    },

    mounted() {
        if (this.role == "Admin") {
            this.admin = true;
        } else {
            this.admin = false;
        }

        if (this.username) {
            this.loggedin = true;
        } else {
            this.loggedin = false;
        }
    },

    watch: {
        admin(roleChange) {
            if (this.role == "Admin") {
                this.admin = true;
            } else {
                this.admin = false;
            }
            if (this.username) {
                this.loggedin = true;
            } else {
                this.loggedin = false;
            }
        }
    }
})