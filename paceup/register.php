<?php
 require 'database.php';
 require 'sessions.php';
    
 $errors = [];
 if($_POST)
 {

  $username = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $password = MD5($_POST['password']);
  $startdate =date('Y-m-d');
  $method = htmlspecialchars($_POST['steps']);
  $registration = htmlspecialchars($_POST['registration']);
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
  
  $practice='AAA';  
  
  if ($username_unique->num_rows>0) {$errors['username']='Please choose a different username, that name is taken'; }
  if ($email_unique->num_rows>0) {$errors['email']= 'Email already in use'; }  
  else if ($username_unique->num_rows<1 && $email_unique->num_rows<1 ) {
   $addUser = "INSERT INTO users(username, password, email, pracID, start_date, pref_method, roleID, referenceID) VALUES (LOWER('" . $username . "'), '" . $password . "', LOWER('" . $email . "'), '". $practice ."', '" . $startdate . "', 'PED', 'U', '". $registration ."');";
   //echo $addUser;
   if(mysqli_query($connection, $addUser))
    {
      $_SESSION['valid'] = true;
      $_SESSION['timeout'] = time();
      $_SESSION['username'] = $username;
      $_SESSION['choose_form']='./steps.php';
         header('Refresh: 0; URL = main_index.php');
    }
   

  }
  }
  catch(PDOException $e){
       echo $e->getMessage();
  }
  

  }
  if(!empty($errors)) {
  	// won't work b/c of single-quotes
  	// echo "{ 'errors': " . json_encode($errors) . "}";
  	$result_array = $errors;
  	echo json_encode($result_array); }
  	else {echo json_encode(array('success' => 'yes'));}
  	exit;  
  

?>