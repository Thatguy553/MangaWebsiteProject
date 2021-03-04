if (logout.includes("true")) {
    localStorage.clear();
}

let header = new Vue({
    el: "#header",
    data() {
        return {
            loggedin: false,
            admin: false
        }
    },

    mounted() {
        if (localStorage['role'] == "Admin") {
            this.admin = true;
        } else {
            this.admin = false;
        }

        if (localStorage['username']) {
            this.loggedin = true;
        } else {
            this.loggedin = false;
        }
    },

    watch: {
        admin(roleChange) {
            if (localStorage['role'] == "Admin") {
                this.admin = true;
            } else {
                this.admin = false;
            }
            if (localStorage['username']) {
                this.loggedin = true;
            } else {
                this.loggedin = false;
            }
        }
    }
})