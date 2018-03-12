var userID = "";

function performOnLoad() {
    userID = $("#hiddenuserid").html();
    /* Enables editing mode */
    $('#edit-btn').click(function () {
        clearAllErrors()
        $('.final-details').hide();
        $('#edit-btn').hide();
        $('#cancel-btn').show();
        $('.editing-details').show();
        $('.submit-btn-container').show();
    });
    /* Cancels editing mode */
    $('#cancel-btn').click(function () {
        clearAllErrors();
        $('.final-details').show();
        $('#edit-btn').show();
        $('#cancel-btn').hide();
        $('.editing-details').hide();
        $('.submit-btn-container').hide();
    });
    var inputFirstName = document.getElementById("acc-fname");
    inputFirstName.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            submitChanges();
        }
    });
    var inputLastName = document.getElementById("acc-lname");
    inputLastName.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            submitChanges();
        }
    });
    var inputEmail = document.getElementById("acc-email");
    inputEmail.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            submitChanges();
        }
    });
    populateAccountPage();
}

function showPasswordChange() {
    $(".passwordfinalrow").hide();
    $(".passwordeditrow").show();
    clearAllErrors();
}

function hidePasswordChange() {
    $(".passwordfinalrow").show();
    $(".passwordeditrow").hide();
    clearAllErrors();
}

function populateAccountPage() {
    $.ajax({
        type: "POST"
        , url: "engine/getuserinfobyid.php"
        , data: {
            userID: userID
        }
        , success: function (results) {
            if (results == "1") {
                noResults("No user with that ID");
            }
            else {
                var data = results.split(",");
                loadUser(data[0], data[1], data[2], data[3], data[4]);
            }
        }
    });
}

function loadUser(email, type, fName, lName, notify) {
    document.getElementById("fname").innerHTML = "<p id class='user-details'>" + fName + "</p>";
    $("#acc-fname").val(fName);
    document.getElementById("lname").innerHTML = "<p id class='user-details'>" + lName + "</p>";
    $("#acc-lname").val(lName);
    document.getElementById("email").innerHTML = "<p id class='user-details'>" + email + "</p>";
    $("#acc-email").val(email);
    if (notify == "1") {
        document.getElementById("notificationCheck").checked = true;
    }
}

function submitChanges() {
    clearAllErrors();
    // Input values
    var firstName = $("#acc-fname").val();
    var lastName = $("#acc-lname").val();
    var email = $("#acc-email").val();
    var submit = validateChangesForm(email, firstName, lastName);
    if (submit) {
        accountInfoSubmit(email, firstName, lastName);
    }
}

function changePassword() {
    clearAllErrors();
    // Input values
    var oldPassword = $("#oldpassword").val();
    var newPassword = $("#newpassword").val();
    var passwordCheck = $("#passwordcheck").val();
    var submit = validatePasswordForm(oldPassword, newPassword, passwordCheck);
    if (submit) {
        checkPassword(oldPassword, newPassword);
    }
}

function checkPassword(password, newPassword) {
    $.ajax({
        type: "POST"
        , url: "engine/checkuserpassword.php"
        , data: {
            userID: userID
            , password: password
        }
        , success: function (results) {
            if (results == "1") {
                newPasswordAJAX(newPassword);
            }
            else {
                $("#pWordError").html("<div class='alert alert-danger'> <strong> Error: </strong> Your old password is incorrect. </div > ");
            }
        }
    });
}

function newPasswordAJAX(newPassword) {
    $.ajax({
        type: "POST"
        , url: "engine/newpassword.php"
        , data: {
            pword: newPassword
            , userID: userID
        }
        , success: function (results) {
            if (results == "1") {
                //SUCCESS
                hidePasswordChange();
                $("#oldpassword").val("");
                $("#newpassword").val("");
                $("#passwordcheck").val("");
                $("#pWordSuccess").html("<div class='alert alert-success'> <strong> Error: </strong> Your password was reset </div > ");
            }
            else {
                $("#pWordError").html("<div class='alert alert-danger'> <strong> Error: </strong> An unknown Error occured </div > ");
            }
        }
    });
}

function validateChangesForm(email, firstName, lastName, password, passwordCheck) {
    var eError, fError, lError, pError, pcError = "";
    var result = true;
    //FIRST NAME
    if (firstName == "") {
        $("#edit-error").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your first name. </div> ");
        result = false;
    }
    else if (!(/^[a-zA-Z]+$/.test(firstName))) {
        $("#edit-error").html("<div class='alert alert-danger'> <strong> Error: </strong> Please don't use any numbers or special characters apart from - and ' </div> ");
        result = false;
    }
    //LAST NAME
    if (lastName == "") {
        $("#edit-error").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your last name. </div> ");
        result = false;
    }
    else if (!(/^[a-zA-Z]+$/.test(lastName))) {
        $("#edit-error").html("<div class='alert alert-danger'> <strong> Error: </strong> Please don't use any numbers or special characters apart from - and ' </div> ");
        result = false;
    }
    //EMAIL
    if (email == "") {
        $("#edit-error").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your email. </div> ");
        result = false;
    }
    else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,10})+$/.test(email))) {
        $("#edit-error").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter a valid email. </div> ");
        result = false;
    }
    return result;
}

function validatePasswordForm(oldPassword, newPassword, passwordCheck) {
    var oError, pError, pcError = "";
    var result = true;
    //NOLD PASSWORD
    if (oldPassword == "") {
        $("#pWordError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your current password. </div > ");
        result = false;
    }
    //NEW PASSWORD
    else if (newPassword == "") {
        $("#pWordError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter your new password. </div > ");
        result = false;
    }
    else if (newPassword.length <= 7) {
        $("#pWordError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please ensure your new password has 8 or more characters. </div > ");
        result = false;
    }
    //PASSWORD CHECK
    else if (passwordCheck == "") {
        $("#pWordError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please re-enter your new password. </div > ");
        result = false;
    }
    else if (passwordCheck != newPassword) {
        $("#pWordError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please ensure both new passwords match. </div > ");
        result = false;
    }
    return result;
}

function accountInfoSubmit(email, firstName, lastName) {
    $.ajax({
        type: "POST"
        , url: "engine/updateaccount.php"
        , data: {
            userID: userID
            , email: email
            , fname: firstName
            , lname: lastName
        }
        , success: function (results) {
            if (results != "1") {
                $("#edit-error").html("<div class='alert alert-danger'> <strong> Error: </strong> An unknown error occured </div > ");
            }
            else {
                //Sign Up Successful
                location.reload();
            }
        }
    });
}

function toggleUserNotify() {
    if (document.getElementById("notificationCheck").checked) {
        resubscribe();
    }
    else {
        unsubscribe();
    }
}

function unsubscribe() {
    $.ajax({
        type: "POST"
        , url: "engine/unsubscribeuser.php"
        , data: {
            userID: userID
        }
    });
}

function resubscribe() {
    $.ajax({
        type: "POST"
        , url: "engine/resubscribeuser.php"
        , data: {
            userID: userID
        }
    });
}

function clearAllErrors() {
    clearAccountErrors();
    clearPasswordErrors();
    clearPasswordSuccess();
}

function clearAccountErrors() {
    $("#edit-error").html("");
}

function clearPasswordErrors() {
    $("#pWordError").html("");
}

function clearPasswordSuccess() {
    $("#pWordSuccess").html("");
}