<?php 
	
$header_type = 2;

?>

<html>

	<head>
    	<title>Access Denied</title>
    	<?php 
        include "snippets/meta.php";
        ?>
        <link rel="stylesheet" href="stylesheets/landingPageStyle.css">
    </head>
    <body>
	    <?php 
        include "snippets/header.php";
        ?>
        <div class="container">
	        <h2 style="text-align: center"><b>Access Denied</b></h2>
	        <h1 style="text-align: center; margin-top: 20px;">This page is not accessible.</h1>
	        
	        <div  style="text-align: center; margin-top: 30px;">
            	<a href="index.php"><button id="homeBtn" class="btn btn-secondary" style="width: 200px">Back to Search</button></a>
            	<a href="login.php"><button id="loginBtn" class="btn submitBtn">Go to Login</button></a>
            </div>
        </div>
        <?php 
        include "snippets/footer.php";
        ?>
    </body>

</html>