<html>
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
    <!--SINGLE SIGNON-->

    <head>
        <title>My Bookmarks</title>
        <?php 
        include "snippets/meta.php";
        ?>
        <script type="text/javascript" src="js/bookmarks.js"></script>
        <script src="js/landingPage.js"></script>
    </head>

    <body onload="performOnLoad()">
        <?php 
    include 'snippets/header.php'
    ?>
            <div class="container">
                <h1 id="title" class="text-center">Bookmarks</h1>
                <div id="resultsWrapper">
                    <div id="testOutput"> </div>
                    <div id="resultsDiv"> </div>
                </div>
            </div>
            <?php 
    include "snippets/footer.php";
    ?>
    </body>

</html>