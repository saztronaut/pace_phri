<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';

$msg="";
$results=[];

if ($_POST){
	
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);

    $email = htmlspecialchars($_POST['email'], ENT_QUOTES); //will check is email

    $registration = htmlspecialchars($_POST['registration'], ENT_QUOTES);
    $registration = preg_replace("/[^a-zA-Z0-9]+/", "", $registration);
    $check_reg="SELECT e_consent, e_consent_a, e_consent_v, e_consent_t, e_consent_gp, age, ethnicity, gender FROM reference WHERE referenceID='".$registration."' AND referenceID NOT in (SELECT referenceID from users);";
    $get_reg= (mysqli_query($connection, $check_reg));
if ($get_reg->num_rows==0){
	$msg=2;
	$results['consent']=2; // registration code does not exist
} else {
	$reg_row=mysqli_fetch_array($get_reg);
	if ($reg_row['e_consent']==0){
	$msg=0;
	$results['consent']=0; // no consent data stored
	}else {$msg=1;
	$results['e_consent']=$reg_row['e_consent'];
	$results['e_consent_a']=$reg_row['e_consent_a'];
	$results['e_consent_v']=$reg_row['e_consent_v'];
	$results['e_consent_t']=$reg_row['e_consent_t'];
	$results['e_consent_gp']=$reg_row['e_consent_gp'];
	$results['age']=$reg_row['age'];
	$results['gender']=$reg_row['gender'];
	$results['ethnicity']=$reg_row['ethnicity'];
	$results['consent']=1;}
    }
    mysqli_free_result($get_reg);
    
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
    mysqli_free_result($username_unique);
    mysqli_free_result($email_unique);
    	 

}





//echo $msg;
if(!empty($results)) {

	$result_array = $results;
	echo json_encode($result_array); }
	else {echo json_encode(array('msg' => $msg));}
	exit;


	?>