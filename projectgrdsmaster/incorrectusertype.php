<?php 
	
$header_type = 1;
/*if (isset($_GET['id'])) {
    $userID = $_GET['id'];
    echo "<div style='font-size: 0px; display: none;' id='hiddenuserid'>$userID</div>";
} else {
    //ERROR NO DAID GIVEN
    echo "<div id='hiddenuserid'></div>";
}*/
?>

<html>

	<head>
    	<title>Access Denied</title>
    	<?php 
        include "snippets/meta.php";
        ?>
    </head>

    <body>
	    <?php 
        include "snippets/header.php";
        ?>
        <div class="container">
	        <h2 style="text-align: center"><b>Access Denied</b></h2>
	        <h1 style="text-align: center; margin-top: 20px;">You don't have the correct privileges to access this feature.</h1>
	        <h1 style="text-align: center">Please contact your system administrator.</h1>
	        
	        <div  style="text-align: center; margin-top: 30px;">
            	<a href="index.php"><button id="homeBtn" class="btn submitBtn">Back to Search</button></a>
            </div>
        </div>
        <?php 
        include "snippets/footer.php";
        ?>
    </body>

</html>