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
        header("Location: accessdenied.php");
    }
    ?>
    <!--SINGLE SIGNON-->

    <head>
        <title>GRDS Search</title>
        <?php 
        include "snippets/meta.php";
        ?>
        <script type="text/javascript" src="js/approveadmin.js"></script>
        <script src="js/landingPage.js"></script>
    </head>

    <body onload="performOnLoad()">
        <?php 
    include 'snippets/header.php'
    ?>
            <div class="container">
                <h1 id="title" class="text-center">Search User to Approve</h1>
                <div id="documentSearchForm" class="text-center">
                    <div id="searchForm" class="align-center">
                        <!-- Keyword Search -->
                        <div class="align">
                            <input id="adminEmailInput" onblur="searchUser()" placeholder="Enter user's email..."> </div>
                        <!-- Search Button -->
                        <div class="align search">
                            <button id="search" onclick="searchUser();">
                                <div id="search-icon"> <i class="material-icons md-light md-36">search</i> </div>
                                <div id="spinner" class=""></div>
                            </button>
                        </div>
                    </div>
                    <br><br>
                    <div id="emailError"></div>
                </div>
                <div id="resultsWrapper">
                    <div id="resultsDiv"> </div>
                </div>
            </div>
            <?php 
    include "snippets/footer.php";
    ?>
    </body>

</html>