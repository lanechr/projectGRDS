<?php 
    session_start();
    if (isset($_SESSION['userID'])){
        $header_type = 3;
        if (isset($_SESSION['userType'])){
            if ($_SESSION['userType'] == "Admin"){
                $header_type = 4;
            }
        }
        $userID = $_SESSION['userID'];
        echo "<div style='font-size: 0px; display: none;' id='hiddenuserid'>$userID</div>";
    } else {
        header("Location: login.php");
    }
?>
<html>

<head>
    <title>My Account</title>
    <?php 
        include "snippets/meta.php";
        ?>
    <script src="js/account.js"></script>
</head>

<body onload="performOnLoad()">
    <?php 
        include "snippets/header.php";
        ?>
    <div id="acc-container" class="container">
        <h1 id="acc-title">Account</h1>
        <div class='card-body' id="acc-card">
            <div id="edit-error" class="edit-error"></div>
            <table id="acc-details-display">
                <!-- Settings button -->
                <tr>
                    <td class="td-fixed">
                    </td>
                    <td class="acc-edit">
                        <i id="edit-btn" class="fa fa-pencil-square-o"></i>
                        <i style="display: none;" id="cancel-btn" class="fa fa-times"></i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h2 class="acc-h2">First Name:</h2>
                    </td>
                    <td id="fname" class="final-details">
                    </td>
                    <td class="editing-details">
                        <input id="acc-fname" class="form-control" name="fname" value="">
                        <!-- PLACEHOLDER VALUE -->
                    </td>
                </tr>
                <tr>
                    <td class="td-fixed">
                        <h2 class="acc-h2">Last Name:</h2>
                    </td>
                    <td id="lname" class="final-details">
                    </td>
                    <td class="editing-details">
                        <input id="acc-lname" class="form-control" name="lname" value="">
                        <!-- PLACEHOLDER VALUE -->
                    </td>
                </tr>
                <tr>
                    <td class="td-fixed">
                        <h2 class="acc-h2">Email:</h2>
                    </td>
                    <td id="email" class="final-details">

                    </td>
                    <td class="editing-details">
                        <input id="acc-email" class="form-control" name="email" value="">
                        <!-- PLACEHOLDER VALUE -->
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="submit-btn-container">
                            <button onclick="submitChanges()" id="save-btn" class="btn">Save Changes</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="pWordSuccess"></div>
                    </td>
                </tr>
                <tr style="display:none;" class="passwordeditrow">
                    <td colspan="2">
                        <div id="pWordError"></div>
                    </td>
                </tr>
                <tr class="passwordfinalrow">
                    <td class="td-fixed">
                        <h2 class="acc-h2">Password:</h2>
                    </td>
                    <td id="pwd" class="">
                        <p class="user-details"><span class="fake-link" onclick="showPasswordChange()">Change Password</span></p>
                    </td>
                </tr>
                <tr style="display:none;" class="passwordeditrow">
                    <td class="td-fixed">
                        <h2 class="acc-h2">Old Password: </h2>
                    </td>
                    <td class="password-edits">
                        <input id="oldpassword" class="form-control" name="oldpassword" value="" type="password">
                        <!-- PLACEHOLDER VALUE -->
                    </td>
                </tr>
                <tr style="display:none;" class="passwordeditrow">
                    <!--                Spacer-->
                </tr>
                <tr style="display:none;" class="passwordeditrow">
                    <td class="td-fixed">
                        <h2 class="acc-h2">New Password: </h2>
                    </td>
                    <td class="password-edits">
                        <input id="newpassword" class="form-control" name="newpassword" value="" type="password">
                        <!-- PLACEHOLDER VALUE -->
                    </td>
                </tr>
                <tr style="display:none;" class="passwordeditrow">
                    <td class="td-fixed">
                        <h2 class="acc-h2">Repeat Password: </h2>
                    </td>
                    <td class="password-edits">
                        <input id="passwordcheck" class="form-control" name="passwordcheck" value="" type="password">
                        <!-- PLACEHOLDER VALUE -->
                    </td>
                </tr>
                <tr style="display:none;" class="passwordeditrow">
                    <!--                Spacer-->
                </tr>
                <tr style="display:none;" class="passwordeditrow">
                    <td class="td-fixed"></td>
                    <td>
                        <div id="accountbuttonrow">
                            <a style="display: inline-block;" id="cancelbtn" class="btn btn-secondary" onclick="hidePasswordChange();">Cancel</a>
                            <a style="display: inline-block;" id="savebtn" class="btn btn-success" onclick="changePassword()">Save</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='switch'><input id='notificationCheck' type='checkbox' onchange='toggleUserNotify()'><span class='slider round'></span></label>
                    </td>
                    <td>
                        <p id="notifications" class="user-details">Receive email notifications when GRDS is updated</p>
                    </td>
                </tr>
            </table>
            <!-- <i class="fa fa-exclamation-circle"></i>This email is invalid. -->
        </div>
    </div>
    <?php 
        include "snippets/footer.php";
        ?>
</body>

</html>
