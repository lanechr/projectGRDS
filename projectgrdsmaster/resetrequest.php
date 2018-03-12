<?php 
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

    <body>
        <?php 
        include "snippets/header.php";
        ?>
        <div class="container">
            <h1 style="text-align: center"><b>Reset Password</b></h1>
            <div class='card-body' id="loginCard">
                <div id="form-area">
                    <div id="resetError"></div>
                    <input id="emailInput" class="form-control" name="email" placeholder="Email">
                    <div id="emailError"></div>
                    <div class="text-center">
                        <button id="resetbutton" onclick="submitResetRequest()" class="btn submitBtn">Reset Password<div style="" id="spinner" class=""></div></button>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        include "snippets/footer.php";
        ?>
    </body>

    </html>