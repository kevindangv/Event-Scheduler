/* Kevin Dang kd9me - Jennifer Huynh jph5au */

function eventModal() {
    var modal = document.getElementById("eventModal");

    var btn = document.getElementById("eventButton");

    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    }
}

function deleteModal() {
    var modal = document.getElementById("deleteModal");

    var btn = document.getElementById("deleteButton");

    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    }
}

function meetingModal() {
    var modal = document.getElementById("meetingModal");

    var btn = document.getElementById("meetingButton");

    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

var loginModal = function() {
    var modal = document.getElementById("loginModal");

    var btn = document.getElementById("loginButton");

    var span = document.getElementsByClassName("close")[0];

    var submitBtn = document.getElementById("submit");

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = () => {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function validate() {
    var username = document.getElementById("login").value;
    var password = document.getElementById("pass").value;
    if(username == "demo" && password == "demo") {
        alert("Login successful");
        document.getElementById("userButton").innerHTML = username;

    }
    else {
        alert("You have entered the wrong information");
    }
}
