<?php
require 'database.php';
require 'setBaselineFunctions.php';

if (isset($_POST['username'])){
	$username = htmlspecialchars($_SESSION['username']);
	setBase($username);
}

?>