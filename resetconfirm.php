<?php

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    echo "<div id='hiddentoken'>$token</div>";
} else {
    //ERROR NO TOKEN GIVEN
    
}

$header_type = 2;
?>
    <html>

    <head>
        <title>GRDS Reset Password</title>
        <?php 
        include "snippets/meta.php";
        ?>
        <script src="js/passwordreset.js"></script>
    </head>

    <body onload="performOnLoanToken()">
        <?php 
        include "snippets/header.php";
        ?>
            <div class="container">
                <h1 style="text-align: center"><b>Reset Password</b></h1>
                <div class='card-body' id="loginCard">
                    <div id="form-area">
                        <div id="tokenpageError"></div>
                        <input id="passwordInput" class="form-control" name="password" type="password" placeholder="Password">
                        <div id="pWordError"></div>
                        <input id="passwordCheckInput" class="form-control" name="passwordcheck" type="password" placeholder="Re-enter Password">
                        <div id="pWordCheckError"></div>
                        <br>
                        <div class="text-center">
                            <button onclick="submitNewPassword()" class="btn submitBtn">Reset Password</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        include "snippets/footer.php";
        ?>
    </body>

    </html>