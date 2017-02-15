<!DOCTYPE html>
<?php
 require 'database.php';
 session_start();
    $_SESSION['choose_form'] = './landing_text.php';
    header('Refresh: 1; URL = ./main_index.php');
?>
