<!DOCTYPE html>
<?php
 require 'database.php';
// require 'sessions.php';
    session_start();
    $_SESSION['choose_form'] = './register_form.php';
    header('Refresh: 1; URL = ./main_index.php');
?>



