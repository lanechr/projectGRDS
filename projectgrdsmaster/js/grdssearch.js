//Array[ALL_CAPS]
var functions = [];
var functionCounts = [];
//JSON Object
var funcActPairs = [];
var activitiesList = [];
var activityCounts = [];
var currentFunction = "";
var currentActivity = "";
var previousSearch = "";
var updateSelects = 0;
var mobileDevice = false;
var userID = "";
var userType = "";

function searchGRDS() {
    var searchStr = $("#omniInput").val();
    if (!isNaN(searchStr)) {
        if (searchStr.length == 4) {
            idSearch(searchStr);
        }
        else {
            keywordSearch(searchStr);
        }
    }
    else {
        keywordSearch(searchStr);
    }
}

function idSearch(daid) {
    showSpinner();
    var daid = daid;
    $.ajax({
        type: "POST"
        , url: "engine/grdsidsearch.php"
        , dataType: 'json'
        , data: {
            daid: daid
        }
        , success: function (results) {
            hideSpinner();
            if (results == "1") {
                noResults("Error: No ID given");
            }
            else if (results == "2") {
                noResults("No record with that ID exists");
            }
            else {
                loadResults(results);
            }
        }
    });
}

function keywordSearch(keywords) {
    showSpinner();
    var keywords = keywords;
    var func = $("#grdsFunctionList").val();
    currentFunction = func;
    if (func != "") {
        func = func.split('_').join(' ');
    }
    var act = $("#grdsActivityList").val();
    currentActivity = act;
    if (act != "") {
        act = act.split('_').join(' ');
    }
    if (keywords != previousSearch) {
        updateSelects = 1;
        currentActivity = "";
        currentFunction = "";
        previousSearch = keywords;
        func = "";
        act = "";
    }
    $.ajax({
        type: "POST"
        , url: "engine/grdssearch.php"
        , dataType: 'json'
        , data: {
            keywords: keywords
            , functionStr: func
            , activity: act
        }
        , success: function (results) {
            hideSpinner();
            if (results == "1") {
                noResults("Error: No keywords given");
            }
            else if (results == "2") {
                noResults("No records with those keywords exist");
            }
            else {
                loadResults(results);
            }
        }
    });
}

function performOnLoad(pageLoc) {
    if (pageLoc == 'index'){
        document.getElementById("navhome").classList.add('active');
    } 
    if (window.innerWidth < 767) {
        document.getElementById("omniInput").placeholder = "Enter ID or Keywords";
    }
    userID = $("#hiddenuserid").html();
    var daid = $("#hiddendaid").html();
    validateUserType(userID);
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        mobileDevice = true;
    }
    var omni = document.getElementById("omniInput");
    omni.addEventListener("keydown", function (e) {
        if (e.keyCode === 13) {
            //checks whether the pressed key is "Enter"
            if ($("#omniInput").val() != "") {
                searchGRDS();
            }
        }
    });
    if (!mobileDevice) {
        //Create Select Menus
        $("#grdsFunctionList").niceSelect();
        $("#grdsActivityList").niceSelect();
    }
    createFuncActArrays();
    //called if daid has been passed by GET
    if (daid != "") {
        idSearch(daid);
    }
}
//MUST be called on load
//Creates functions array and funcActPairs JSON Object
function createFuncActArrays() {
    $.ajax({
        type: "POST"
        , url: "engine/activityarray.php"
        , dataType: 'json'
        , success: function (results) {
            funcActPairs = results;
            functions = Object.keys(results);
            clearFuncCount();
            appendFunctions();
        }
    });
}

function loadResults(results) {
    //Do Something
    var resultCount = results.length;
    document.getElementById("testOutput").innerHTML = resultCount + " results found";
    document.getElementById("resultsDiv").innerHTML = "";
    var i = 0;
    clearFuncCount();
    clearActCount();
    for (i == 0; i < resultCount; i++) {
        functionCounts[functions.indexOf(results[i].Function.split(" ").join("_"))] += 1;
        activityCounts[activitiesList.indexOf(results[i].Activity)] += 1;
        var result_no = i + 1;
        resultListInfo(results[result_no - 1].Function, results[result_no - 1].Activity, results[result_no - 1].Class, results[result_no - 1].Description.split("\\").join(""), results[result_no - 1].DAID, results[result_no - 1].RTP, results[result_no - 1].LastUpdate);
    }
    if (updateSelects == 1) {
        appendFunctions();
        appendActivities();
        updateSelects = 0;
        currentActivity = "";
        currentFunction = "";
    }
    else {
        //Add result counts to select menus
        if (currentActivity == "") {
            appendActivities();
        }
    }
    //Maintain selected option
    $("#grdsFunctionList").val(currentFunction);
    $("#grdsActivityList").val(currentActivity);
    if (!mobileDevice) {
        $("#grdsFunctionList").niceSelect("update");
        $("#grdsActivityList").niceSelect("update");
    }
}

function getActivityArray() {
    var func = $("#grdsFunctionList").val();
    var activities = funcActPairs[func];
    activitiesList = [];
    $("#grdsActivityList").html("");
    $("#grdsActivityList").append("<option value=''>SELECT ACTIVITY</option>");
    for (var act in activities) {
        activitiesList.push(activities[act]);
        var noSpace = activities[act].split('_').join(' ');
        $("#grdsActivityList").append("<option value='" + activities[act] + "'>" + noSpace + " (" + activityCounts[activitiesList.indexOf(activities[act])] + ")</option>");
    }
    functionSelected();
    if (!mobileDevice) {
        $("#grdsFunctionList").niceSelect("update");
        $("#grdsActivityList").niceSelect("update");
    }
}

function appendFunctions() {
    $("#grdsFunctionList").html("");
    var count = 0;
    // 0 = false, 1 = true
    var disabled = 0;
    for (var func in functions) {
        if (count == 0) {
            disabled = 1;
            $("#grdsFunctionList").append("<option value=''>SELECT FUNCTION</option>");
        }
        else {
            var noSpace = functions[func].split('_').join(' ');
            var resultNo = functionCounts[functions.indexOf(functions[func])];
            if (resultNo == 0) {
                $("#grdsFunctionList").append("<option value='" + functions[func] + "'>" + noSpace + "</option>");
            }
            else {
                $("#grdsFunctionList").append("<option value='" + functions[func] + "'>" + noSpace + " (" + resultNo + ")</option>");
            }
        }
        count++;
    }
    if (!mobileDevice) {
        $("#grdsFunctionList").niceSelect("update");
    }
}

function appendActivities() {
    $("#grdsActivityList").html("");
    if (activitiesList == '') {
        $("#grdsActivityList").append("<option value=''>SELECT ACTIVITY</option>");
    }
    else {
        var count = 0;
        // 0 = false, 1 = true
        var disabled = 0;
        $("#grdsActivityList").append("<option value=''>SELECT ACTIVITY</option>");
        for (var act in activitiesList) {
            var noSpace = activitiesList[act].split('_').join(' ');
            var resultNo = activityCounts[activitiesList.indexOf(activitiesList[act])];
            if (resultNo == 0) {
                $("#grdsActivityList").append("<option value='" + activitiesList[act] + "'>" + noSpace + "</option>");
            }
            else {
                $("#grdsActivityList").append("<option value='" + activitiesList[act] + "'>" + noSpace + " (" + resultNo + ")</option>");
            }
        }
    }
    if (!mobileDevice) {
        $("#grdsActivityList").niceSelect("update");
    }
}

function resultListInfo(functionName, activity, classType, description, recordID, retentionPeriod, dateAuthorised) {
    document.getElementById("resultsDiv").innerHTML += "<div class='card-body' id='card" + recordID + "'><h4 class='card-title'>" + functionName + "<h6 class='card-subtitle mb-2 text-muted'>" + activity + "</h6><h7 class='card-text'><b>" + classType + "</b></h7><br>" + description + "</h4><div><b>Retention Period: " + retentionPeriod + "</b></div><br>";
    //Check if record class is bookmarked
    var bookmarked = isBookmarked(recordID);
    if (bookmarked == "1") {
        document.getElementById("card" + recordID).innerHTML += "<button id='bkmrk" + recordID + "' type='button' onclick='addBookmark(" + recordID + ")' class='btn btn-primary align'><span class='tooltiptextBookmark'>Remove bookmark</span>Bookmarked</button></h4>";
    }
    else {
        document.getElementById("card" + recordID).innerHTML += "<button id='bkmrk" + recordID + "' type='button' onclick='addBookmark(" + recordID + ")' class='btn btn-outline-primary align'>Bookmark</button></h4>";
    }
    document.getElementById("card" + recordID).innerHTML += "<div class='idBox align btn'>ID: " + recordID + "</div>";
    if (userType == "Admin") {
        document.getElementById("card" + recordID).innerHTML += "<a href='edit.php?daid=" + recordID + "' class='updateButton align btn'>Update</a>";
    }
}

function noResults(errorMessage) {
    document.getElementById("testOutput").innerHTML = "";
    document.getElementById("resultsDiv").innerHTML = "<div class='card-body error-message text-center'><i class='fa fa-exclamation-circle'></i> <h7 class='card-text'>" + errorMessage + "</h7></div>";
}

function functionSelected() {
    var e = document.getElementById("grdsFunctionList");
    var value = e.options[e.selectedIndex].value;
    var textValue = e.options[e.selectedIndex].text;
    if (value != "") {
        document.getElementById("grdsActivityList").disabled = false;
    }
    else {
        document.getElementById("grdsActivityList").disabled = true;
    }
}
//Show and hide dropdowns
function toggleDropdowns() {
    var searchStr = $("#omniInput").val();
    if (!isNaN(searchStr)) {
        //Hide Dropdowns
        $("#dropdowns").slideUp(400);
    }
    else if (searchStr == "") {
        //Hide Dropdowns
        $("#dropdowns").slideUp(400);
    }
    else {
        //Show Dropdowns
        $("#dropdowns").slideDown(400);
    }
}

function clearFuncCount() {
    var funcCount = 0;
    functionCounts = [];
    while (funcCount < functions.length) {
        functionCounts.push(0);
        funcCount += 1;
    }
}

function clearActCount() {
    var actCount = 0;
    activityCounts = [];
    while (actCount < activitiesList.length) {
        activityCounts.push(0);
        actCount += 1;
    }
}

function showSpinner() {
    document.getElementById("spinner").classList.add('spinner');
    document.getElementById("search-icon").classList.add('hide-search-icon');
}

function hideSpinner() {
    document.getElementById("spinner").classList.remove('spinner');
    document.getElementById("search-icon").classList.remove('hide-search-icon');
}

function validateUserType(userID) {
    $.ajax({
        type: "POST"
        , url: "engine/getusertype.php"
        , data: {
            userID: userID
        }
        , success: function (results) {
            userType = results;
        }
    });
}

function addBookmark(daid) {
    if (userID == "") {
        window.location = "login.php?daid=" + daid;
    }
    $.ajax({
        type: "POST"
        , url: "engine/bookmarkcontrol.php"
        , data: {
            userID: userID
            , daid: daid
        }
        , success: function (results) {
            if (results == "Added") {
                document.getElementById("bkmrk" + daid).classList.remove('btn-outline-primary');
                document.getElementById("bkmrk" + daid).classList.add('btn-primary');
                document.getElementById("bkmrk" + daid).innerHTML = "Bookmarked";
            }
            else if (results == "Deleted") {
                document.getElementById("bkmrk" + daid).classList.remove('btn-primary');
                document.getElementById("bkmrk" + daid).classList.add('btn-outline-primary');
                document.getElementById("bkmrk" + daid).innerHTML = "Bookmark";
            }
        }
    });
}

function isBookmarked(daid) {
    var response = "2";
    $.ajax({
        type: "POST"
        , url: "engine/bookmarkcheck.php"
        , async: false
        , data: {
            userID: userID
            , daid: daid
        }
        , success: function (results) {
            if (results == "True") {
                response = "1";
            }
            else {
                response = "2";
            }
        }
    });
    return response;
}

function resize() {
    if (window.innerWidth < 767) {
        document.getElementById("omniInput").placeholder = "Enter DAN or Keywords";
    } else {
        document.getElementById("omniInput").placeholder = "Enter Disposal Authorisation Number or Keywords...";
    }
}