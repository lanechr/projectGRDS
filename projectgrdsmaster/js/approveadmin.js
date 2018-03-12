function performOnLoad() {
    userID = $("#hiddenuserid").html();
    validateUserType();
    var adminEmail = document.getElementById("adminEmailInput");
    adminEmail.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            if ($("#adminEmailInput").val() != "") {
                searchUser();
            }
        }
    });
}

function validateUserType() {
    $.ajax({
        type: "POST"
        , url: "engine/getusertype.php"
        , data: {
            userID: userID
        }
        , success: function (results) {
            if (results == "Basic") {
                window.location = "incorrectusertype.php";
            }
            else {
                //UNKNOWN ERROR
            }
        }
    });
}

function searchUser() {
    clearErrors();
    var email = $("#adminEmailInput").val();
    var success = validateEmail(email);
    if (success) {
        getUserAJAX(email);
    }
}

function getUserAJAX(email) {
    $.ajax({
        type: "POST"
        , url: "engine/getuserinfobyemail.php"
        , data: {
            email: email
        }
        , success: function (results) {
            if (results == "1") {
                noResults("No user with that email address");
            }
            else {
                var data = results.split(",");
                loadUser(data[0], data[1], data[2], data[3]);
            }
        }
    });
}

function loadUser(userID, userType, fName, lName) {
    document.getElementById("resultsDiv").innerHTML = "";
    document.getElementById("resultsDiv").innerHTML = "<div class='userCard'><table><tr class='userTopRow'><th class='idCol'>User ID</th><td class='spacer'></td><th class='nameCol'>First Name</th><th>Last Name</th><th class='adminCol'>Admin</td></th><tr class='userBottomRow'><td id='userIDholder'>" + userID + "</td><td class='spacer'></td><td>" + fName + "</td><td>" + lName + "</td><td id='switchCol'><label class='switch'><input id='adminCheck' type='checkbox' onchange='toggleAdmin()'><span class='slider round'></span></label></td></tr></table><div id='toggleError'></div></div>";
    
    if (userType == "Admin") {
        document.getElementById("adminCheck").checked = true;
    } 
}

function noResults(errorMessage) {
    document.getElementById("resultsDiv").innerHTML = "<div class='card-body error-message text-center'><i class='fa fa-exclamation-circle'></i> <h7 class='card-text'>" + errorMessage + "</h7></div>";
}

function validateEmail(email) {
    var eError = "";
    var result = true;
    //EMAIL
    if (email == "") {
        $("#emailError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter an email. </div > ");
        result = false;
    }
    else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,10})+$/.test(email))) {
        $("#emailError").html("<div class='alert alert-danger'> <strong> Error: </strong> Please enter a valid email. </div > ");
        result = false;
    }
    return result;
}

function clearErrors() {
    $("#emailError").html("");
}

function toggleAdmin() {
    var isChecked = document.getElementById("adminCheck").checked;
    var newUserType = "";
    if (isChecked) {
        newUserType = "Admin";
    } else {
        newUserType = "Basic";
    }
    var currentUserID = $("#hiddenuserid").html();
    var userID = document.getElementById("userIDholder").innerHTML;
    if (currentUserID != userID){
        setUserTypeAJAX(userID, newUserType);
    } else {
        $("#toggleError").html("<div class='alert alert-danger'> <strong> Error: </strong> You cant toggle your own admin status. </div > ");
        document.getElementById("adminCheck").checked = true
    }
}

function setUserTypeAJAX(userID, newUserType) {
    $.ajax({
        type: "POST"
        , url: "engine/setusertype.php"
        , data: {
            userID: userID
            , type: newUserType
        }
        , success: function (results) {
            if (results == "1") {
                //Error
            }
            else {
                //Success
            }
        }
    });
}
