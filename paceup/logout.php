<?php 
include 'database.php';
include 'sessions.php';
?>

<?php
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["choose_form"]);
   mysqli_close($connection);
   
   header('Refresh: 1; URL = ./main_index.php');
?>


