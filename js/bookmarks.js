var userID = "";
var userType = "";

function performOnLoad() {
    document.getElementById("navbookmark").classList.add('active');

    userID = $("#hiddenuserid").html();
    validateUserType(userID);

    getBookmarks();
}

function validateUserType(userID) {
    $.ajax({
        type: "POST",
        url: "engine/getusertype.php",
        async: false,
        data: {
            userID: userID
        },
        success: function (results) {
            userType = results;
        }
    });
}

function getBookmarks() {
    $.ajax({
        type: "POST",
        url: "engine/getuserbookmarks.php",
        async: false,
        dataType: 'json',
        data: {
            userID: userID
        },
        success: function (results) {
            if (results == "1") {
                noResults("System Error: No ID given");
            } else if (results == "2") {
                noResults("You haven't created any bookmarks");
            } else {
                loadResults(results);
            }
        }
    });
}

function loadResults(results) {
    //Do Something
    var resultCount = results.length;
    document.getElementById("testOutput").innerHTML = resultCount + " results found";
    document.getElementById("resultsDiv").innerHTML = "";
    var i = 0;
    for (i == 0; i < resultCount; i++) {
        var result_no = i + 1;
        resultListInfo(results[result_no - 1].Function, results[result_no - 1].Activity, results[result_no - 1].Class, results[result_no - 1].Description.split("\\").join(""), results[result_no - 1].DAID, results[result_no - 1].RTP, results[result_no - 1].LastUpdate);
    }
}

function resultListInfo(functionName, activity, classType, description, recordID, retentionPeriod, dateAuthorised) {
    document.getElementById("resultsDiv").innerHTML += "<div class='card-body' id='card" + recordID + "'><h4 class='card-title'>" + functionName + "<h6 class='card-subtitle mb-2 text-muted'>" + activity + "</h6><h7 class='card-text'><b>" + classType + "</b></h7><br>" + description + "</h4><div><b>Retention Period: " + retentionPeriod + "</b></div><br>";
    //Check if record class is bookmarked
    var bookmarked = isBookmarked(recordID);
    if (bookmarked == "1") {
        document.getElementById("card" + recordID).innerHTML += "<button id='bkmrk" + recordID + "' type='button' onclick='addBookmark(" + recordID + ")' class='btn btn-primary align'><span class='tooltiptextBookmark'>Remove bookmark</span>Bookmarked</button></h4>";
    } else {
        document.getElementById("card" + recordID).innerHTML += "<button id='bkmrk" + recordID + "' type='button' onclick='addBookmark(" + recordID + ")' class='btn btn-outline-primary align'>Bookmark</button></h4>";
    }
    var notify = notifyOn(recordID);
    if (notify == "1") {
        document.getElementById("card" + recordID).innerHTML += "<button id='notify" + recordID + "' type='button' onclick='toggleNotify(" + recordID + ")' class='btn btn-primary align'><span class='tooltiptext'>Ensure notifications are<br />enabled on the <a href='/account.php'>Account page</a></span><i class='fa fa-bell'></i></button></h4>";
    } else {
        document.getElementById("card" + recordID).innerHTML += "<button id='notify" + recordID + "' type='button' onclick='toggleNotify(" + recordID + ")' class='btn btn-outline-primary align'><span class='tooltiptext'>Ensure notifications are<br />enabled on the <a href='/account.php'>Account page</a></span><i class='fa fa-bell'></i></button></h4>";
    }
    if (bookmarked != "1") {
        $("#notify" + daid).hide();
    }
    document.getElementById("card" + recordID).innerHTML += "<div class='idBox align btn'>ID: " + recordID + "</div>";
    if (userType == "Admin") {
        document.getElementById("card" + recordID).innerHTML += "<a href='edit.php?daid=" + recordID + "' class='updateButton align btn'>Update</a>";
    }
}

function toggleNotify(daid) {
    $.ajax({
        type: "POST",
        url: "engine/notifycontrol.php",
        data: {
            userID: userID,
            daid: daid
        },
        success: function (results) {
            if (results == "ON") {
                document.getElementById("notify" + daid).classList.remove('btn-outline-primary');
                document.getElementById("notify" + daid).classList.add('btn-primary');
            } else if (results == "OFF") {
                document.getElementById("notify" + daid).classList.remove('btn-primary');
                document.getElementById("notify" + daid).classList.add('btn-outline-primary');
            }
        }
    });
}

function noResults(errorMessage) {
    document.getElementById("testOutput").innerHTML = "";
    document.getElementById("resultsDiv").innerHTML = "<div class='card-body error-message text-center'><i class='fa fa-exclamation-circle'></i> <h7 class='card-text'>" + errorMessage + "</h7></div>";
}

function addBookmark(daid) {
    if (userID == "") {
        window.location = "login.php?daid=" + daid;
    }
    $.ajax({
        type: "POST",
        url: "engine/bookmarkcontrol.php",
        data: {
            userID: userID,
            daid: daid
        },
        success: function (results) {
            if (results == "Added") {
                document.getElementById("bkmrk" + daid).classList.remove('btn-outline-primary');
                document.getElementById("bkmrk" + daid).classList.add('btn-primary');
                document.getElementById("bkmrk" + daid).innerHTML = "Bookmarked";
                $("#notify" + daid).show();
            } else if (results == "Deleted") {
                document.getElementById("bkmrk" + daid).classList.remove('btn-primary');
                document.getElementById("bkmrk" + daid).classList.add('btn-outline-primary');
                document.getElementById("bkmrk" + daid).innerHTML = "Bookmark";
                $("#notify" + daid).hide();
            }
        }
    });
}

function isBookmarked(daid) {
    var response = "2";
    $.ajax({
        type: "POST",
        url: "engine/bookmarkcheck.php",
        async: false,
        data: {
            userID: userID,
            daid: daid
        },
        success: function (results) {
            if (results == "True") {
                response = "1";
            } else {
                response = "2";
            }
        }
    });
    return response;
}

function notifyOn(daid) {
    var response = "";
    $.ajax({
        type: "POST",
        url: "engine/notifycheck.php",
        async: false,
        data: {
            userID: userID,
            daid: daid
        },
        success: function (results) {
            response = results;
        }
    });
    return response;
}
