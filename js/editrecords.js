var userID = "";
var currentDaid = "";
var oldDesc = "";
var oldFunc = "";
var oldAct = "";
var oldClass = "";

function performOnLoad() {
    userID = $("#hiddenuserid").html();
    validateUserType();
}

function validateUserType() {
    $.ajax({
        type: "POST"
        , url: "engine/getusertype.php"
        , data: {
            userID: userID
        }
        , success: function (results) {
            if (results == "1") {
                
            }
            else if (results == "2") {
                
            }
            else if (results == "Admin") {
                var daid = $("#hiddendaid").html();
                if (daid != "") {
                    getRecordByID(daid);
                }
            }
            else if (results == "Basic") {
                window.location = "incorrectusertype.php";
            }
            else {
                //UNKNOWN ERROR
            }
        }
    });
}

function getRecordByID(daid) {
    var daid = daid;
    currentDaid = daid;
    $.ajax({
        type: "POST"
        , url: "engine/grdsidsearch.php"
        , dataType: 'json'
        , data: {
            daid: daid
        }
        , success: function (results) {
            if (results == "1") {
                
            }
            else if (results == "2") {
                
            }
            else {
                loadResults(results);
            }
        }
    });
}

function loadResults(results) {
    $("#daidholder").html("Record ID: " + results[0].DAID);
    $("#functionholder").html("Record Function: <input id='functioninput' name='functioninput' onKeyDown='upperCase(this);' value='" + results[0].Function + "'>");
    $("#activityholder").html("Record Activity: <input id='activityinput' name='activityinput' onKeyDown='upperCase(this);' value='" + results[0].Activity + "'>");
    $("#rtpholder").html("Retention Period: <input id='rtpinput' name='rtpinput' value='" + results[0].RTP + "'>");
    oldFunc = results[0].Function;
    oldAct = results[0].Activity;
    oldClass = results[0].Class;
    oldDesc = results[0].Description;
    $("#classholder").html("Record Class: <input id='classinput' name='classinput' value='" + results[0].Class + "'>");
    
    quill.clipboard.dangerouslyPasteHTML(results[0].Description.split("indent-").join("ql-indent-").split("\\").join(""));
}

function saveChanges() {
    var daid = $("#hiddendaid").html();
    //Remove p tags
    var description = $(".ql-editor").html().split('<p>').join('').split('</p>').join('');
    var reason = $("#reasontextbox").val();
    var funcVal = $("#functioninput").val();
    var actVal = $("#activityinput").val();
    var classVal = $("#classinput").val();
    var rtpVal = $("#rtpinput").val();
    //Fix indenting
    description = description.split('ql-').join('');
    var submit = validateUpdateForm(funcVal, actVal, classVal, rtpVal, description, reason);
    if (submit) {
        $.ajax({
            type: "POST"
            , url: "engine/updaterecord.php"
            , data: {
                daid: daid
                , description: description
                , oldDescription: oldDesc
                , reason: reason
                , userID: userID
                , funcVal: funcVal
                , actVal: actVal
                , classVal: classVal
                , rtpVal: rtpVal
            }
            , success: function (results) {
                results = results.split(",");
                if (results[0] == "Success") {
                    notify(results[1]);
                    window.location = "index.php?daid=" + daid;
                } else {
                    alert("Unknown Error");
                }
            }
        });
    }
}

function validateUpdateForm(fun, act, cla, rtp, description, reason) {
    var fError, aError, cError, rtpError, dError, rError = "";
    var result = true;
    //FUNCTION
    if (fun == "") {
        $("#funError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> Function cannot be blank. </div> ");
        result = false;
    }
    //ACTIVITY
    if (act == "") {
        $("#actError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> Activity cannot be blank. </div> ");
        result = false;
    }
    //CLASS
    if (cla == "") {
        $("#claError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> Class cannot be blank. </div> ");
        result = false;
    }
    //RTP
    if (rtp == "") {
        $("#rtpError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> Retention Period cannot be blank. </div> ");
        result = false;
    }
    //DESCRIPTION
    if (description == "") {
        $("#descError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> Description cannot be blank. </div> ");
        result = false;
    }
    else if (description == "<br>") {
        $("#descError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> Description cannot be blank. </div> ");
        result = false;
    }
    //REASON
    if (reason == "") {
        $("#reasonError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> Reason cannot be blank. </div > ");
        result = false;
    }
    return result;
}

function notify(changeID) {
    $.ajax({
            type: "POST"
            , url: "engine/notifychange.php"
            , data: {
                changeID: changeID
            }
        });
    }

function upperCase(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

function showNewModal(){
    document.getElementById("modal-inner").innerHTML = "<div class='modal-header'<button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>Editing Record: " + currentDaid + "<?php echo $daid?></h4> </div><div class='modal-body'><p>Please enter a new Disposal Authorisation ID for this record.</p><h5>DAID: </h5><div id='newDAIDError'></div><input style='display: inline-block;' id='newDAID' name='newDaid' placeholder='DAID'><div><div class='modal-footer'><button type='button' class='btn btn-primary' onClick='supercede()'>Save</button></div><button id='hiddenmodaldismiss' style='display: none;' data-dismiss='modal'></button>";
}

function showOldModal(){
    clearAllErrors();
    document.getElementById("modal-inner").innerHTML = "<div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>Editing Record: " + currentDaid + "<?php echo $daid?></h4> </div><div class='modal-body'><p>Would you like to edit the current Disposal Authorisation or supersede it and create a new Authorisation?</p></div><div class='modal-footer'><button type='button' class='btn btn-primary' data-dismiss='modal' data-target='#editModal' onClick='saveChanges()'>Edit Current</button><button type='button' class='btn btn-primary' onClick='showNewModal()'>Supersede</button></div>";
}

function supercede() {
    clearAllErrors();
    var newDAID = $("#newDAID").val()
    if (newDAID != "" && parseInt(newDAID > 999 && parseInt(newDAID)) < 10000){
        var available = DAIDAvailable($("#newDAID").val());
        if (available) {
            supercedeAJAX(newDAID);
        } else {
            $("#newDAIDError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> DAID is already in use, please use a different DAID. </div                 > ");
        }
    } else {
        $("#newDAIDError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> Please enter a 4 digit number. </div                 > ");
    }
}

function supercedeAJAX(newDAID) {
    var newRecord = newDAID;
    var daid = $("#hiddendaid").html();
    //Remove p tags
    var description = $(".ql-editor").html().split('<p>').join('').split('</p>').join('');
    var reason = $("#reasontextbox").val();
    var funcVal = $("#functioninput").val();
    var actVal = $("#activityinput").val();
    var classVal = $("#classinput").val();
    var rtpVal = $("#rtpinput").val();
    //Fix indenting
    description = description.split('ql-').join('');
    var submit = validateUpdateForm(funcVal, actVal, classVal, rtpVal, description, reason);
    if (submit) {
        $.ajax({
            type: "POST"
            , url: "engine/supercederecord.php"
            , data: {
                oldDaid: daid
                , description: description
                , oldDescription: oldDesc
                , reason: reason
                , userID: userID
                , funcVal: funcVal
                , actVal: actVal
                , classVal: classVal
                , rtpVal: rtpVal
                , newRecord: newRecord
            }
            , success: function (results) {
                results = results.split(",");
                if (results[0] == "Success") {
                    notifySuperceded(results[1]);
                    window.location = "index.php?daid=" + newDAID;
                } else {
                    alert("Unknown Error");
                }
            }
        });
    } else {
        document.getElementById("hiddenmodaldismiss").click();
    }
}

function DAIDAvailable(checkDAID){
    var result = false;
    $.ajax({
            type: "POST"
            , url: "engine/daidavailable.php"
            , async: false
            , data: {
                daid: checkDAID
            }
            , success: function (results) {
                if (results == 1) {
                    result = true;
                }
            }
        });
    return result;
}

function notifySuperceded(changeID) {
    $.ajax({
            type: "POST"
            , url: "engine/notifychangesuperceded.php"
            , data: {
                changeID: changeID
            }
        });
    }

function clearAllErrors() {
    $("#funError").html("");
    $("#actError").html("");
    $("#claError").html("");
    $("#rtpError").html("");
    $("#descError").html("");
    $("#reasonError").html("");
    $("#newDAIDError").html("");
}