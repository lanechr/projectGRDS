<?php 
session_start();
if (isset($_SESSION['userID'])){
    //User logged in
    header('Location: index.php');
}
$header_type = 2;
?>
    <html>

    <head>
        <title>GRDS Sign Up</title>
        <?php 
        include "snippets/meta.php";
        ?>
        <script src="js/userauthentication.js"></script>
    </head>

    <body onload="performOnLoadSignUp()">
        <?php 
        include "snippets/header.php";
        ?>
        <div class="container">
            <h1 style="text-align: center"><b>Sign Up</b></h1>
            <div class='card-body' id="loginCard">
            <div id="form-area">
	            <div id="signupError"></div>
                <input id="fnameInput" class="form-control" name="fname" placeholder="First Name">
                <div id="fnameError"></div>
                <input id="lnameInput" class="form-control" name="lname" placeholder="Last Name">
                <div id="lnameError"></div>
                <br>
                <input id="emailInput" class="form-control" name="email" placeholder="Email">
                <div id="emailError"></div>
                <input id="passwordInput" class="form-control" name="password" type="password" placeholder="Password">
                <div id="pWordError"></div>
                <input id="passwordCheckInput" class="form-control" name="passwordcheck" type="password" placeholder="Re-enter Password">
                <div id="pWordCheckError"></div>
                <br>
                <div class="text-center">
	                <button onclick="submitSignUp()" class="btn submitBtn">Sign Up</button>
                </div>
            </div>
            </div>
        </div>
        <?php 
        include "snippets/footer.php";
        ?>
    </body>

    </html>