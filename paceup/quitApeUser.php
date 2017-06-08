<?php
require 'sessions.php';
// unset the ape_user cookie, return viewing to normal
        if (isset($_SESSION['ape_user'])){
        	unset($_SESSION['ape_user']);
        }
        
	
?>

