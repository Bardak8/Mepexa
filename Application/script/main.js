function open_signup_menu() {
    document.getElementById("signup_menu").style.display = "block";
    document.getElementById("main_menu").style.display = "none";
}

function open_signin_menu() {
    document.getElementById("signin_menu").style.display = "block";
    document.getElementById("main_menu").style.display = "none";
}

function open_main_menu() {
    document.getElementById("main_menu").style.display = "block";
    document.getElementById("signin_menu").style.display = "none";
    document.getElementById("signup_menu").style.display = "none";
}