<?php
 require 'database.php';
 require 'sessions.php';
 include 'get_json_encode.php';
 
 $errors = [];
 if($_POST)
 {

  $username = htmlspecialchars($_POST['username']);
  $firstname = htmlspecialchars($_POST['firstname']);
  $lastname = htmlspecialchars($_POST['lastname']);
  $email = htmlspecialchars($_POST['email']);
  $password = MD5($_POST['password']);
  $startdate =date('Y-m-d');
  $method = htmlspecialchars($_POST['steps']);
  if (isset($_POST['other_method'])){
  $other_method = htmlspecialchars($_POST['other_method']); }
  else {$other_method ='';}
  $registration = htmlspecialchars($_POST['registration']);
  $e_consent= htmlspecialchars($_POST['e_consent']);
  $e_consent_v= htmlspecialchars($_POST['e_consent_v']);
  $e_consent_gp= htmlspecialchars($_POST['e_consent_gp']);
  $e_consent_a= htmlspecialchars($_POST['e_consent_a']);
  $e_consent_t= htmlspecialchars($_POST['e_consent_t']);
  $age= htmlspecialchars($_POST['age']);
  $gender= htmlspecialchars($_POST['gender']);
  $ethnicity= htmlspecialchars($_POST['ethnicity']);
  //add salt in here
  define('IND_SALT', 'RandomString');
   $salt = IND_SALT;
  //
  

  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  	$errors['email'] = 'Please use a valid email address';
  
  //Insert query here to look up practice code from the registration code
  	
  }
 
  
  try
  {
  $check_user = "SELECT * FROM users WHERE username ='" . $username . "';" ;
  $check_email = "SELECT * FROM users WHERE email ='" . $email . "';" ;
  $username_unique= (mysqli_query($connection, $check_user));
  $email_unique= (mysqli_query($connection, $check_email));
  // check registration code is not in the users table and registration code IS in the registration table. Retrieve practice number
  
  $check_reg="SELECT practice FROM reference WHERE referenceID='".$registration."' AND referenceID NOT in (SELECT referenceID from users);";
  $get_reg= (mysqli_query($connection, $check_reg));
  if ($get_reg->num_rows==0){
  	$errors['registration']='The registration code you provided is not valid. Please try again. ';
  } else {
  	$reg_row=mysqli_fetch_array($get_reg);
  $practice=$reg_row['practice'];  
  
  if ($username_unique->num_rows>0) {$errors['username']='Please choose a different username, that name is taken'; }
  if ($email_unique->num_rows>0) {$errors['email']= 'Email already in use'; }  
  else if ($username_unique->num_rows<1 && $email_unique->num_rows<1 ) {
  	
   $addUser = "INSERT INTO users(username, password, email, forename, lastname, pracID, start_date, e_consent, e_consent_v, e_consent_a, e_consent_gp, e_consent_t, pref_method, other_method, age, gender, ethnicity, roleID, referenceID) VALUES (LOWER('" . $username . "'), '" . $password . "', LOWER('" . $email . "'), LOWER('" . $firstname . "'), LOWER('" . $lastname . "'), '". $practice ."', '" . $startdate . "', '" . $e_consent . "', '" . $e_consent_v . "', '" . $e_consent_a . "', '" . $e_consent_gp . "', '" . $e_consent_t . "', '". $method ."', '". $other_method ."', '". $age ."', '". $gender ."', '". $ethnicity ."',  'U', '". $registration ."');";
 
 // $errors['query']= $addUser;
  //echo $addUser;
   if(mysqli_query($connection, $addUser))
    {// send an email to the user as well
     $email_msg ="Thank you for signing up to the PACE-UP next-steps website!
All the information you need to start the 12-week walking programme is online, including information on how to use the pedometer and set your walking targets.
We would be grateful if you could complete and return the paper consent form, enclosed in your pedometer pack, using the free-post envelope provided. If you have misplaced the form or the envelope please contact Charlotte Wahlich (PACE-UP research assistant) on cwahlich@sgul.ac.uk who can provide you with a replacement.
We hope that you enjoy the 12-week walking programme!
Best wishes, 
The PACE-UP team";

     
      $_SESSION['valid'] = true;
      $_SESSION['timeout'] = time();
      $_SESSION['username'] = $username;
      $_SESSION['roleID'] = $row['U'];
      $_SESSION['choose_form']='./intro.php';
         header('Refresh: 0; URL = main_index.php');
    }
   

  }
  }}
  catch(PDOException $e){
       echo $e->getMessage();
  }
  

  }
  if(!empty($errors)) {

  	$result_array = $errors;
  	echo json_encode($result_array); }
  	else {echo json_encode(array('success' => 'yes'));}
  	exit;  
  

?>
