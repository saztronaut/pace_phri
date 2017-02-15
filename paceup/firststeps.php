<?php
require 'database.php';
session_start();
if (isset($_SESSION['username'])){
$_SESSION['choose_form'] = './steps.php';}
else{
	$_SESSION['choose_form'] = './landing_text.php';}
header('Refresh: 1; URL = ./main_index.php');

echo "Redirecting you to the steps page";

?>
