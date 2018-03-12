<?php 
session_start();
if (isset($_SESSION['userID'])){
    //User logged in
    header('Location: index.php');
}
if (isset($_GET['daid'])){
    $daid = $_GET['daid'];
    echo "<div style='display: none;' id='hiddendaid'>$daid</div>";
} else {
    echo "<div style='display: none;' id='hiddendaid'></div>";
}
$header_type = 2;
?>
    <html>

    <head>
        <title>GRDS Log In</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="stylesheets/landingPageStyle.css">
        <!-- jQuery -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <script src="js/userauthentication.js"></script>
    </head>

    <body onload="performOnLoadLogIn()">
        <?php 
        include "snippets/header.php";
        ?>
        <div class="container">
            <h1 style="text-align: center"><b>Log In</b></h1>
            <div class='card-body' id="loginCard">
                <div id="form-area">
                    <div id="loginError"></div>
                    <input id="emailInput" class="form-control" name="email" placeholder="Email">
                    <div id="emailError"></div>
                    <input id="passwordInput" class="form-control" name="password" type="password" placeholder="Password">
                    <div id="pWordError"></div>
                    <span id="resetlinks"><a href="signup.php">Create Account</a> | <a href="resetrequest.php">Forgot Password</a></span>
                    <br>
                    <div class="text-center">
                        <button onclick="submitLogin()" class="btn submitBtn">Log In</button>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        include "snippets/footer.php";
        ?>
    </body>

    </html>