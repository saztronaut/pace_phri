<?php
 require 'database.php';
 require 'sessions.php';
require 'updateStepsFunction.php';
 include 'checkUserRights.php';
 
 
 $msg=''; 
 if ($_POST){
 	if (isset($_SESSION['username'])) {
 	   $username = htmlspecialchars($_SESSION['username'], ENT_QUOTES);

 	}
 	if (isset($_SESSION['ape_user'])){
 		$auth= checkRights('R');
 		if ((int)$auth === 1) {
 		    $username = htmlspecialchars($_SESSION['ape_user']);
 		}
    }
     if ($_POST['steps']!="undefined" && $_POST['steps']!="") {
        $input = htmlspecialchars($_POST['steps'], ENT_QUOTES);
        $input = preg_replace("/[^0-9]+/", "", $input);
        
     } else {
  	    $input ='';
     }
     $username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);
     $date_set = date("Y-m-d", strtotime(htmlspecialchars($_POST['date_set'])));
     $method = htmlspecialchars($_POST['method']);
  $haswalk = false;
  $walkon = "";
  if (isset($_POST['walk'])){
    $haswalk = true;
    $walkon = htmlspecialchars($_POST['walk'], ENT_QUOTES);
    $msg = addSteps($username, $input, $date_set, $method, $haswalk, $walkon);
  } else {
     $msg = addSteps($username, $input, $date_set, $method, $haswalk);
  }
}
if ($msg=='') {$msg="unknown";}
echo $msg;


exit;
?>
