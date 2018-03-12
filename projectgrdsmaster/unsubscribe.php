<?php 
$header_type = 2;
if (isset($_GET['id'])) {
    $userID = $_GET['id'];
    echo "<div style='font-size: 0px; display: none;' id='hiddenuserid'>$userID</div>";
} else {
    //ERROR NO DAID GIVEN
    echo "<div id='hiddenuserid'></div>";
}
?>
    <html>

    <head>
        <title>GRDS Unsubscribe</title>
        <?php 
        include "snippets/meta.php";
        ?>
        <script src="js/unsubscribe.js"></script>
    </head>

    <body onload="performOnLoad()">
        <?php 
        include "snippets/header.php";
        ?>
        <div class="container">
            <h2 style="text-align: center"><b>Unsubscribed</b></h2>
            <h1 style="text-align: center">We've turned off notifications for your account.</h1>
            <h1 style="text-align: center">If you'd like to reenable them you can do so in the account page or by clicking the button below</h1>
            <div  style="text-align: center">
            <button id="resubscribe" onclick="resubscribe()" class="btn submitBtn">Resubscribe</button>
            <button id="unsubscribe" style="display: none;" onclick="unsubscribe()" class="btn submitBtn">Unsubscribe</button>
            </div>
        </div>
        <?php 
        include "snippets/footer.php";
        ?>
    </body>

    </html>