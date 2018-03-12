var userID

function performOnLoad() {
    userID = $("#hiddenuserid").html();
    unsubscribe();
}

function unsubscribe() {
    $.ajax({
        type: "POST",
        url: "engine/unsubscribeuser.php",
        data: {
            userID: userID
        },
        success: function (results) {
            if (results == "1") {
                //Success
                $("#unsubscribe").hide();
                $("#resubscribe").show();
            } else {
                //Error
            }
        }
    });
}

function resubscribe() {
    $.ajax({
        type: "POST",
        url: "engine/resubscribeuser.php",
        data: {
            userID: userID
        },
        success: function (results) {
            if (results == "1") {
                //Success
                $("#resubscribe").hide();
                $("#unsubscribe").show();
            } else {
                //Error
            }
        }
    });
}