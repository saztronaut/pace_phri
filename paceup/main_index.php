<!DOCTYPE html>
<!-- This is the main shell of the pages. It asks whether a page has been navigated to and displays that page as $show-insert -->
<?php
 require 'database.php';
 require 'sessions.php';
 // If a navigation form has been set, then use that
    if (isset($_SESSION['choose_form'])){
    	//echo $_SESSION['choose_form'];
    	// There are certain forms which won't work if there is no user from whom the form can be populated
    	//
    	if  (isset($_SESSION['username']) && $_SESSION['username']!=''){
    	}
    	else {// if there is no username, don't show the steps form
    		if ($_SESSION['choose_form']=='./steps.php'||$_SESSION['choose_form']=='./stepHistory.php'){
    			$_SESSION['choose_form']='./landing_text.php';
    			header('Refresh: 1; URL = ./main_index.php');
    		}
    	}
    }
    else 
    {
    	$_SESSION['choose_form']='./landing_text.php';
    }
    
 ?>

<html lang="en">
<head>
  <title>PACE-UP Next Steps - increase your steps, track your progress</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php include "./style.html"; ?>
</head>
<body>

<?php include './nav.php';
$show_insert = $_SESSION['choose_form'];
include $show_insert; ?>


<?php include './footer.php';?>
</body>
