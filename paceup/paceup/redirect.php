<?php
require 'database.php';
require 'sessions.php';

//Takes a form to redirect the page to

if ($_POST){
	$_SESSION['choose_form']= isset($_POST['choose_form']) ? $_POST['choose_form']: './landing_text.php';
}
else{
if (isset($_SESSION['username']) && $_SESSION['username']!=''){
$_SESSION['choose_form'] = './steps.php';}
else{
	$_SESSION['choose_form'] = './landing_text.php';}
}
	
header('Refresh: 1; URL = ./main_index.php');

//echo "Redirecting you to the steps page";

?>
