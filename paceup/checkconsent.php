<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';



$msg="";
$results=[];

if ($_POST){
	
	$username = htmlspecialchars($_POST['username']);
	$firstname = htmlspecialchars($_POST['firstname']);
	$lastname = htmlspecialchars($_POST['lastname']);
	$email = htmlspecialchars($_POST['email']);
	$password = MD5($_POST['password']);
	$startdate =date('Y-m-d');
	$method = htmlspecialchars($_POST['steps']);
    $registration = htmlspecialchars($_POST['registration']);	
    $check_reg="SELECT consent FROM reference WHERE referenceID='".$registration."' AND referenceID NOT in (SELECT referenceID from users);";
    $get_reg= (mysqli_query($connection, $check_reg));
if ($get_reg->num_rows==0){
	$msg=2;
	$results['consent']=2;
} else {
	$reg_row=mysqli_fetch_array($get_reg);
	if ($reg_row['consent']==0){
	$msg=0;
	$results['consent']=0;
	}else {$msg=1;
	$results['consent']=1;}
    }
    
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	$errors['email'] = 'Please use a valid email address';}
    
    	//Insert query here to look up practice code from the registration code	 
     
    
    	$check_user = "SELECT * FROM users WHERE username ='" . $username . "';" ;
    	$check_email = "SELECT * FROM users WHERE email ='" . $email . "';" ;
    	$username_unique= (mysqli_query($connection, $check_user));
    	$email_unique= (mysqli_query($connection, $check_email));
    	if ($username_unique->num_rows>0) {$results['username']='Please choose a different username, that name is taken'; }
    	if ($email_unique->num_rows>0) {$results['email']= 'Email already in use'; }
    
    	 

}
//echo $msg;
if(!empty($results)) {

	$result_array = $results;
	echo json_encode($result_array); }
	else {echo json_encode(array('msg' => $msg));}
	exit;


	?>