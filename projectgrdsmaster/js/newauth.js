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
            if (results == "Basic") {
                window.location = "incorrectusertype.php";
            } else if (results == "Admin") {
                
            }
            else {
                //UNKNOWN ERROR
                window.location = "accessdenied.php";
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

function checkValid() {
    var newDAID = $("#newDAID").val();
    if (newDAID != "" && parseInt(newDAID > 999 && parseInt(newDAID)) < 10000){
        var available = DAIDAvailable(newDAID);
        if (available) {
            saveChanges();
        } else {
            $("#newDAIDError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> DAID is already in use, please use a different DAID. </div                 > ");
        }
    } else {
        $("#newDAIDError").html("<div style='position: relative; top: 10px;' class='alert alert-danger'> <strong> Error: </strong> Please enter a 4 digit number. </div                 > ");
    }
}

function saveChanges() {
    var daid = $("#newDAID").val();
    //Remove p tags
    var description = $(".ql-editor").html().split('<p>').join('').split('</p>').join('');
    var funcVal = $("#functioninput").val();
    var actVal = $("#activityinput").val();
    var classVal = $("#classinput").val();
    var rtpVal = $("#rtpinput").val();
    //Fix indenting
    description = description.split('ql-').join('');
    var submit = validateUpdateForm(funcVal, actVal, classVal, rtpVal, description);
    if (submit) {
        $.ajax({
            type: "POST"
            , url: "engine/createnewrecord.php"
            , data: {
                daid: daid
                , description: description
                , userID: userID
                , funcVal: funcVal
                , actVal: actVal
                , classVal: classVal
                , rtpVal: rtpVal
            }
            , success: function (results) {
                if (results == "1") {
                    window.location = "index.php?daid=" + daid;
                } else {
                    alert("Unknown Error");
                }
            }
        });
    } else {
        document.getElementById("hiddenmodaldismiss").click();
    }
}

function validateUpdateForm(fun, act, cla, rtp, description) {
    var fError, aError, cError, rtpError, dError = "";
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
    return result;
}

function upperCase(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
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

function clearAllErrors() {
    $("#funError").html("");
    $("#actError").html("");
    $("#claError").html("");
    $("#rtpError").html("");
    $("#descError").html("");
    $("#newDAIDError").html("");
}
