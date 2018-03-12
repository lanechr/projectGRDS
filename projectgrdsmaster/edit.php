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
        <title>Edit GRDS:
            <?php echo $daid?>
        </title>
        <?php 
        include "snippets/meta.php";
        ?>
            <!-- QUILL JS -->
            <link href="https://cdn.quilljs.com/1.3.2/quill.snow.css" rel="stylesheet">
            <script src="https://cdn.quilljs.com/1.3.2/quill.js"></script>
            <script type="text/javascript" src="js/editrecords.js"></script>
            <script src="js/landingPage.js"></script>
            <link href="stylesheets/editpage.css" rel="stylesheet"> </head>

    <body onload="performOnLoad()">
        <?php 
        include "snippets/header.php";
        ?>
            <div class="container">
                <div id="editModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div id="modal-inner" class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Editing Record: <?php echo $daid?></h4> </div>
                            <div class="modal-body">
                                <p>Would you like to edit the current Disposal Authorisation or supersede it and create a new Authorisation?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal" data-target="#editModal" onClick="saveChanges()">Edit Current</button>
                                <button type="button" class="btn btn-primary" onClick="showNewModal()">Supersede</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="alldetails"> <span class="title">Updating
              <span id="daidholder"></span> </span>
                    <div id="record-details">
                        <div id="funError"></div>
                        <div id="functionholder"></div>
                        <div id="actError"></div>
                        <div id="activityholder"></div>
                        <div id="claError"></div>
                        <div id="classholder"></div>
                        <div id="rtpError"></div>
                        <div id="rtpholder"></div>
                    </div>
                </div>
                <!-- Create the editor container -->
                <div id="editor" class="edit-window"> </div>
                <div id="descError"></div>
                <div id="reason">
                    <label>Reason for change</label>
                    <br>
                    <textarea rows="5" name="reason" id="reasontextbox"></textarea>
                    <div id="reasonError"></div>
                </div>
                <div id="buttonrow"> <a id="cancelbtn" class="btn btn-warning" onclick="window.history.go(-1);">Cancel</a> <a id="savebtn" class="btn btn-success" onClick="showOldModal()" data-toggle="modal" data-target="#editModal">Update</a> </div>
            </div>
            <?php 
        include "snippets/footer.php";
        ?>
                <!-- Initialise Quill -->
                <script type="text/javascript" src="js/quillsetup.js">
                </script>
    </body>

</html>