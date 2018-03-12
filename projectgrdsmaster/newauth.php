<html>
<?php
    session_start();
    if (!(isset($_SESSION['userID']))){
        header('Location: accessdenied.php');
    } else {
        $header_type = 3;
        if (isset($_SESSION['userType'])){
            if ($_SESSION['userType'] == "Admin"){
                $header_type = 4;
            }
        }
        $userID = $_SESSION['userID'];
        echo "<div style='font-size: 0px; display: none;' id='hiddenuserid'>$userID</div>";
    }
    if (isset($_GET['daid'])) {
        $daid = $_GET['daid'];
        echo "<div id='hiddendaid'>$daid</div>";
    } else {
        //ERROR NO DAID GIVEN
    }
    ?>
    <!--SINGLE SIGNON-->

    <head>
        <title>New Authorisation
        </title>
        <?php 
        include "snippets/meta.php";
        ?>
            <!-- QUILL JS -->
            <link href="https://cdn.quilljs.com/1.3.2/quill.snow.css" rel="stylesheet">
            <script src="https://cdn.quilljs.com/1.3.2/quill.js"></script>
            <script type="text/javascript" src="js/newauth.js"></script>
            <script src="js/landingPage.js"></script>
            <link href="stylesheets/editpage.css" rel="stylesheet"> </head>

    <body onload="performOnLoad()">
        <?php 
        include "snippets/header.php";
        ?>
            <div class="container">
                <div id="newModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div id="modal-inner" class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">New Authorisation</h4> </div>
                            <div class="modal-body">
                                <p>Please choose a disposal authorisation ID for the new class</p>
                                <h5>DAID: </h5>
                                <div id='newDAIDError'></div>
                                <input style='display: inline-block;' id='newDAID' name='newDaid' placeholder='DAID'> </div>
                            <div class="modal-footer">
                                <button type='button' class='btn btn-primary' onClick='checkValid()'>Save</button>
                            </div>
                            <button id='hiddenmodaldismiss' style='display: none;' data-dismiss='modal'></button>
                        </div>
                    </div>
                </div>
                <div id="alldetails"> <span class="title">Create a new disposal authorisation
              <span id="daidholder"></span> </span>
                    <div id="record-details">
                        <div id="funError"></div>
                        <div id="functionholder"> Record Function:
                            <input id='functioninput' name='functioninput' onKeyDown='upperCase(this);' value=''> </div>
                        <div id="actError"></div>
                        <div id="activityholder"> Record Activity:
                            <input id='activityinput' name='activityinput' onKeyDown='upperCase(this);' value=''>
                        </div>
                        <div id="claError"></div>
                        <div id="classholder"> Record Class:
                            <input id='classinput' name='classinput' value=''>
                        </div>
                        <div id="rtpError"></div>
                        <div id="rtpholder"> Retention Period:
                            <input id='rtpinput' name='rtpinput' value=''>
                        </div>
                    </div>
                </div>
                <!-- Create the editor container -->
                <div id="editor" class="edit-window"> </div>
                <div id="descError"></div>
                <div id="buttonrow"> <a id="savebtn" class="btn btn-success" data-toggle="modal" data-target="#newModal" onclick="clearAllErrors();">Save</a> </div>
            </div>
            <?php 
        include "snippets/footer.php";
        ?>
                <!-- Initialise Quill -->
                <script type="text/javascript" src="js/quillsetup.js">
                </script>
    </body>

</html>