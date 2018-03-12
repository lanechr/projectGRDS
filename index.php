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
        $header_type = 2;
        echo "<div style='display: none;' id='hiddenuserid'></div>";
    }
    if (isset($_GET['daid'])){
        $daid = $_GET['daid'];
        echo "<div style='display: none;' id='hiddendaid'>$daid</div>";
    } else {
        echo "<div style='display: none;' id='hiddendaid'></div>";
    }
    ?>
    <!--SINGLE SIGNON-->

    <head>
        <title>GRDS Search</title>
        <?php 
        include "snippets/meta.php";
        ?>
        <script type="text/javascript" src="js/grdssearch.js"></script>
        <script src="js/landingPage.js"></script>
    </head>

    <body onload="performOnLoad('index')" onresize="resize()">
        <?php 
    include 'snippets/header.php'
    ?>
            <div class="container">
                <h1 id="title" class="text-center">Search for your disposal authorisation...</h1>
                <div id="documentSearchForm" class="text-center">
                    <div id="searchForm" class="align-center">
                        <!-- Keyword Search -->
                        <div id="input-container" class="align">
                            <input id="omniInput" onkeydown="toggleDropdowns()" onkeyup="toggleDropdowns()" onblur="searchGRDS();" placeholder="Enter DAN or keywords..."> </div>
                        <!-- Search Button -->
                        <div class="align search">
                            <button id="search" onclick="searchGRDS();">
                                <div id="search-icon"> <i class="material-icons md-light md-36">search</i> </div>
                                <div id="spinner" class=""></div>
                            </button>
                        </div>
                        <div id="dropdowns">
                            <!-- Function List -->
                            <div class="align">
                                <select name="grdsFunctionList" id="grdsFunctionList" onchange="getActivityArray(); searchGRDS();">
                                    <option value=''>SELECT FUNCTION</option>
                                </select>
                            </div>
                            <!-- Activity List -->
                            <div class="align">
                                <select name="grdsActivityList" id="grdsActivityList" onchange="searchGRDS();">
                                    <option value=''>SELECT ACTIVITY</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
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