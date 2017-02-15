<?php include 'database.php'; ?>

<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION['choose_form']);
   mysqli_close($connection);
   
   header('Refresh: 1; URL = ./main_index.php');
?>


