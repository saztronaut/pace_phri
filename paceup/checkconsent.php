<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';



$msg="";
if ($_POST){
$registration = htmlspecialchars($_POST['registration']);	
$check_reg="SELECT consent FROM reference WHERE referenceID='".$registration."' AND referenceID NOT in (SELECT referenceID from users);";
$get_reg= (mysqli_query($connection, $check_reg));
if ($get_reg->num_rows==0){
	$msg=2;
} else {
	$reg_row=mysqli_fetch_array($get_reg);
	if ($reg_row['consent']==0){
	$msg=0;}else {$msg=1;}
    
}

}
echo $msg;
	?>