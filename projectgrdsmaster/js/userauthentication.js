var daid = "";

function performOnLoadLogIn() {
    daid = $("#hiddendaid").html();
    document.getElementById("navlogin").classList.add('active');
    var inputEmail = document.getElementById("emailInput");
    inputEmail.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            submitLogin();
        }
    });
    var inputPassword = document.getElementById("passwordInput");
    inputPassword.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            submitLogin();
        }
    });
}

function performOnLoadSignUp() {
    document.getElementById("navsignup").classList.add('active');
    var inputFirstName = document.getElementById("fnameInput");
    inputFirstName.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            submitSignUp();
        }
    });
    var inputLastName = document.getElementById("lnameInput");
    inputLastName.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            submitSignUp();
        }
    });
    var inputEmail = document.getElementById("emailInput");
    inputEmail.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            submitSignUp();
        }
    });
    var inputPassword = document.getElementById("passwordInput");
    inputPassword.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            submitSignUp();
        }
    });
    var inputPasswordCheck = document.getElementById("passwordCheckInput");
    inputPasswordCheck.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            submitSignUp();
        }
    });
}

function submitLogin() {
    clearLoginErrors();
    var email = $("#emailInput").val();
    var password = $("#passwordInput").val();
    var submit = validateLoginForm(email, password);
    if (submit) {
        loginAJAX(email, password);
    } else {

    }
}

function submitSignUp() {
	clearLoginErrors();
	var email = $("#emailInput").val();
    var password = $("#passwordInput").val();
    var passwordCheck = $("#passwordCheckInput").val();
    var firstName = $("#fnameInput").val();
    var lastName = $("#lnameInput").val();
	var userType = "Basic";
	
    var submit = validateSignUpForm(email, firstName, lastName, password, passwordCheck);
	if (submit) {
        signupAJAX(email, password, firstName, lastName, userType);
    } else {

    }
}

function signupAJAX(email, password, firstName, lastName, userType) {
    $.ajax({
        type: "POST",
        url: "engine/authenticatesignup.php",
        data: {
            email: email,
            password: password,
            fname: firstName,
            lname: lastName,
            user_type: userType
        },
        success: function (results) {
            if (results == "1") {
                $("#signupError").html("<div class='alert alert-danger'> <strong> Error: </strong> A user with this email address already exists. </div > ");
            } else if (results == "2") {
                $("#signupError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please try again. </div > ");
            } else {
                //Sign Up Successful
                window.location="index.php";
            }
        }
    });
}

function loginAJAX(email, password) {
    $.ajax({
        type: "POST",
        url: "engine/authenticatelogin.php",
        data: {
            email: email,
            password: password
        },
        success: function (results) {
            if (results == "1") {
                $("#loginError").html("<div class='alert alert-danger'> <strong> Error: </strong> Your email or password is incorrect. </div > ");
            } else if (results == "2") {
                $("#loginError").html("<div class='alert alert-danger'> <strong> Error: </strong> Your email or password is incorrect. </div > ");
            } else {
                //Login Successful
                if (daid != "") {
                    window.location = "index.php?daid=" + daid;
                } else {
                    window.location = "index.php";
                }
            }
        }
    });
}

function validateLoginForm(email, password) {
    var eError, pError = "";
    var result = true;
    //PASSWORD
    if (password == "") {
        $("#pWordError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your password. </div                 > ");
        result = false;
    }
    //EMAIL
    if (email == "") {
        $("#emailError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your email. </div > ");
        result = false;
    } else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,10})+$/.test(email))) {
        $("#emailError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter a valid email. </div > ");
        result = false;
    }
    return result;
}

function validateSignUpForm(email, firstName, lastName, password, passwordCheck) {
    var eError, fError, lError, pError, pcError = "";
    var result = true;
    //FIRST NAME
    if (firstName == "") {
        $("#fnameError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your first name. </div > ");
        result = false;
    }
    else if (!(/^[a-zA-Z]+$/.test(firstName))) {
        $("#fnameError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please don't use any numbers or special characters apart from - and ' </div > ");
        result = false;
    }
    //LAST NAME
    if (lastName == "") {
        $("#lnameError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your last name. </div > ");
        result = false;
    }
    else if (!(/^[a-zA-Z]+$/.test(lastName))) {
        $("#lnameError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please don't use any numbers or special characters apart from - and ' </div > ");
        result = false;
    }
    //EMAIL
    if (email == "") {
        $("#emailError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your email. </div > ");
        result = false;
    }
    else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,10})+$/.test(email))) {
        $("#emailError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter a valid email. </div > ");
        result = false;
    }
    //PASSWORD
    if (password == "") {
        $("#pWordError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your password. </div > ");
        result = false;
    }
    else if (password.length <= 7){
	    $("#pWordError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please ensure your password has 8 or more characters. </div > ");
        result = false;
    }
    //PASSWORD CHECK
    if (passwordCheck == "") {
        $("#pWordCheckError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please re-enter your password. </div > ");
        result = false;
    }
    else if (passwordCheck != password){
	    $("#pWordCheckError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please ensure both passwords match. </div > ");
        result = false;
    }
    return result;
}



function clearLoginErrors() {
    $("#pWordError").html("");
    $("#emailError").html("");
    $("#loginError").html("");
    $("#signupError").html("");
    $("#fnameError").html("");
    $("#lnameError").html("");
    $("#pWordCheckError").html("");
}