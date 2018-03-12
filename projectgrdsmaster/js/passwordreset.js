var userID = "";

function submitResetRequest() {
    showSpinner();
    clearResetErrors();
    var email = $("#emailInput").val();
    var submit = validateEmail(email);
    if (submit) {
        resetAJAX(email);
    } else {
        hideSpinner();
    }
}

function validateEmail(email) {
    var eError = "";
    var result = true;
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

function resetAJAX(email) {
    $.ajax({
        type: "POST",
        url: "engine/requestpasswordreset.php",
        data: {
            email: email
        },
        success: function (results) {
            if (results == "1") {
                $("#resetError").html("<div class='alert alert-danger'> <strong> Error: </strong> There is no account with that email address </div > ");
                hideSpinner();
            } else if (results == "2") {
                //SUCCESS
                window.location = "requestsuccess.php";
            } else {
                $("#resetError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please try again. </div > ");
                hideSpinner();
            }
        }
    });
}

function clearResetErrors() {
    $("#emailError").html("");
    $("#resetError").html("");
}

function performOnLoanToken() {
    var token = document.getElementById("hiddentoken").innerHTML;
    $.ajax({
        type: "POST",
        url: "engine/getuserbyresettoken.php",
        data: {
            token: token
        },
        success: function (results) {
            if (results == "NOENTRY"){
                //No password reset with that token
            } else if (results == "TIMEOUT") {
                //To much time has lapsed sincereset requested
            } else if (results == "INVALID") {
                //Password reset has been invalidated
            } else {
                userID = results;
            }
        }
    });
}

function validateNewPassword(password, passwordCheck) {
    var pError, pcError = "";
    var result = true;
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

function submitNewPassword() {
    clearNewPasswordErrors();
    var pWord = $("#passwordInput").val();
    var pWordCheck = $("#passwordCheckInput").val();
    var submit = validateNewPassword(pWord, pWordCheck);
    if (submit) {
        newPasswordAJAX(pWord);
    }
}

function clearNewPasswordErrors() {
    $("#tokenpageError").html("");
    $("#pWordError").html("");
    $("#pWordCheckError").html("");
}

function newPasswordAJAX(pWord) {
    $.ajax({
        type: "POST",
        url: "engine/newpassword.php",
        data: {
            pword: pWord,
            userID: userID
        },
        success: function (results) {
            if (results == "1") {
                //SUCCESS
                window.location = "login.php";
            } else {
                $("#tokenpageError").html("<div class='alert alert-danger'> <strong> Error: </strong> An unknown Error occured </div > ");
            }
        }
    });
}

function showSpinner() {
    document.getElementById("spinner").classList.add('resetspinner');
}

function hideSpinner() {
    document.getElementById("spinner").classList.remove('resetspinner');
}