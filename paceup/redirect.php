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

// If a navigation form has been set, then use that
if (isset($_SESSION['choose_form'])){
	//echo $_SESSION['choose_form'];
	// There are certain forms which won't work if there is no user from whom the form can be populated
	//
	if  (isset($_SESSION['username']) && $_SESSION['username']!=''){
	}
	else {// if there is no username, don't show the steps form
		if ($_SESSION['choose_form']=='./steps.php'||$_SESSION['choose_form']=='./stepHistory.php'||$_SESSION['choose_form']=='./admin.php'||$_SESSION['choose_form']=='./downloadData.php'||$_SESSION['choose_form']=='./diary.php'){
			$_SESSION['choose_form']='./landing_text.php';
		//	header('Refresh: 1; URL = ./main_index.php');
		}
	}
}
else
{
	$_SESSION['choose_form']='./landing_text.php';
}

header('Refresh: 1; URL = ./main_index.php');



?>
