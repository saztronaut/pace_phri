<?php
 require 'database.php';
 require 'sessions.php';
 include 'get_json_encode.php';
 
 $errors = [];
 if($_POST)
 {
  $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
  $username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);
  $firstname = htmlspecialchars($_POST['firstname'], ENT_QUOTES);
  $firstname = preg_replace("/[^a-zA-Z ]+/", "", $firstname);
  $lastname = htmlspecialchars($_POST['lastname'], ENT_QUOTES);
  $lastname = preg_replace("/[^a-zA-Z ]+/", "", $lastname);
  $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
 $practice="";
  $password = MD5($_POST['password']); // keep this in here for the current users
  $salt = bin2hex(openssl_random_pseudo_bytes(6));
  // hash will become the new password
  $hash = base64_encode(hash('sha256', $password.$salt, true).$salt);
  $startdate =date('Y-m-d');
  $method = htmlspecialchars($_POST['steps'], ENT_QUOTES);
  if (isset($_POST['other_method'])){
        $other_method = htmlspecialchars($_POST['other_method'], ENT_QUOTES); }
  else {$other_method ='';}
  $registration = htmlspecialchars($_POST['registration'], ENT_QUOTES);
  $registration = preg_replace("/[^a-zA-Z0-9]+/", "", $registration);
  $e_consent= filter_var($_POST['e_consent'], FILTER_VALIDATE_INT);
  $e_consent_v= filter_var($_POST['e_consent_v'], FILTER_VALIDATE_INT);
  $e_consent_gp= filter_var($_POST['e_consent_gp'], FILTER_VALIDATE_INT);
  $e_consent_a= filter_var($_POST['e_consent_a'], FILTER_VALIDATE_INT);
  $e_consent_t= filter_var($_POST['e_consent_t'], FILTER_VALIDATE_INT);
  $age= filter_var($_POST['age'], FILTER_VALIDATE_INT);
  $gender= htmlspecialchars($_POST['gender'], ENT_QUOTES);
  $gender = preg_replace("/([^MF])+/", "", $gender);
  $ethnicity= htmlspecialchars($_POST['ethnicity'], ENT_QUOTES); 
  $ethnicity = preg_replace("/([^ABMOW])+/", "", $ethnicity);
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  	$errors['email'] = 'Please use a valid email address'; 	
  }  
 

  else
  {
 // check registration code is not in the users table and registration code IS in the registration table. Retrieve practice number
  $check_reg="SELECT practice FROM reference WHERE referenceID='".$registration."' AND referenceID NOT in (SELECT referenceID from users);";
  $get_reg= (mysqli_query($connection, $check_reg));
  if ($get_reg->num_rows==0){
  	$errors['registration']='The registration code you provided is not valid. Please try again. ';
  } else {
  	$reg_row=mysqli_fetch_array($get_reg);
    $practice=$reg_row['practice'];  
    
  $check_user = "SELECT * FROM users WHERE username ='" . $username . "';" ;
  $check_email = "SELECT * FROM users WHERE email ='" . $email . "';" ;
  $username_unique= mysqli_query($connection, $check_user);
  $email_unique= mysqli_query($connection, $check_email);  
  if ($username_unique->num_rows>0) {
  	$errors['username']='Please choose a different username, that name is taken'; }
  if ($email_unique->num_rows>0) {
  	$errors['email']= 'Email already in use'; }  
  else if ($username_unique->num_rows<1 && $email_unique->num_rows<1 ) {
      // create Registration argument
      $arg = "";
      if ($age != 'undefined'){
          $arg .= ", age=". $age;
      }
      if ($gender != 'undefined'){
          $arg .= ", gender='". $gender ."'";
      }
      if (ethnicity != 'undefined'){
          $arg .= ", ethnicity='". $ethnicity ."'";
      }

   $addUser = "INSERT INTO users(username, password, pass, salt, email, forename, lastname, pracID, start_date, pref_method, other_method, roleID, referenceID) VALUES (LOWER('" . $username . "'), '" . $password . "', '". $hash ."','" . $salt . "', LOWER('" . $email . "'), LOWER('" . $firstname . "'), LOWER('" . $lastname . "'), '". $practice ."', '" . $startdate . "', '". $method ."', '". $other_method ."',  'U', '". $registration ."');";
   $updateConsent = "UPDATE reference SET  e_consent = '" . $e_consent . "', e_consent_v= '" . $e_consent_v . "', e_consent_a= '" . $e_consent_a . "', e_consent_gp='" . $e_consent_gp . "', e_consent_t= '" . $e_consent_t . "' " . $arg ." WHERE referenceID = '". $registration ."';";
 // $errors['query']= $addUser;
  //echo $addUser;
   if (mysqli_query($connection, $addUser))
    {// send an email to the user as well
    	mysqli_query($connection, $updateConsent);
     $message ="Thank you for signing up to the PACE-UP next-steps website!\n
All the information you need to start the 12-week walking programme is online, including information on how to use the pedometer and set your walking targets.\n
We would be grateful if you could complete and return the paper consent form, enclosed in your pedometer pack, using the free-post envelope provided. If you have misplaced the form or the envelope please contact Charlotte Wahlich (PACE-UP research assistant) on cwahlich@sgul.ac.uk who can provide you with a replacement. \n
We hope that you enjoy the 12-week walking programme!
Best wishes, 
The PACE-UP team";
     $subject= 'Welcome to PACE-UP Next Steps';
      $headers = "MIME-Version: 1.0" . "\r\n ";
     $headers .= "Content-type:text/html;charset=UTF-8"."\r\n ";
     $headers .= 'From: sarah@sarahkerry.co.uk' . "\r\n ";
     $headers .= 'Return-Path: sarah@sarahkerry.co.uk '. "\r\n";
     $headers .= "X-Sender: no-reply < sarah@sarahkerry.co.uk >" . "\r\n";
     $headers .= 'X-Mailer: PHP/' . phpversion(). "\r\n" ;
     // comment out mail so not sending a whole bunch of emails to incorrect addresses   
     //mail($email, $subject , $message, $headers);
    mail($email, $subject , $message, $headers,"-f sarah@sarahkerry.co.uk");
     
     $addEmail = "INSERT INTO emails VALUES ('". $username ."', NOW(), 'W','". $email ."');";
     mysqli_query($connection, $addEmail) or die($addEmail . mysql_error());
     
     $errors['success']= 'yes';
     
      $_SESSION['valid'] = true;
      $_SESSION['timeout'] = time();
      $_SESSION['username'] = $username;
      $_SESSION['roleID'] = 'U';
      //$_SESSION['choose_form']='./intro.php';
    //     header('Refresh: 0; URL = intro.php');
        
    }
   
  }
  mysqli_free_result($username_unique);
  mysqli_free_result($email_unique);
  }
  mysqli_free_result($get_reg);
  }
  }
  if(!empty($errors)) {
  	$result_array = $errors;
  	echo json_encode($result_array); }
  	else {;}
  	exit;  
  
?>