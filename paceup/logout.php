<?php 
include 'database.php';
include 'sessions.php';
?>

<?php
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["choose_form"]);
   unset($_SESSION["roleID"]);
   unset($_SESSION["ape_user"]);
   unset($_SESSION["get_username"]);
   mysqli_close($connection);
   
   header('Refresh: 1; URL = ./landing_text.php');
?>


