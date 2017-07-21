<?php

require 'sessions.php';
require 'database.php';
require 'checkUserRights.php';

if ($_POST['min_account']){
    $minRole = htmlspecialchars($_POST['min_account']);
    $minRole= preg_replace("/[^RSU]+/", "", $min_account);
    $message= checkRights($minRole);
    echo $message;
}
exit
?>
