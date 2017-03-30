<?php
 require 'database.php';
 require 'sessions.php';
 $msg=''; 
 if ($_POST)
 {$username = htmlspecialchars($_SESSION['username']);
  if ($_POST['steps']!="undefined" && $_POST['steps']!=""){
        $input = htmlspecialchars($_POST['steps']);} 
  else {$input ='';}
  $date_set = date("Y-m-d", strtotime(htmlspecialchars($_POST['date_set'])));
  $method = htmlspecialchars($_POST['method']);
  $walk='';
  if ($_POST['walk']){
  if ($_POST['walk']=='true'){$walk = '1';} else if ($walk=='false') {$walk = '0';}}
  
  $query = "SELECT username, date_read, date_entered, steps, method, add_walk FROM readings WHERE username = '". $username ."' AND date_read= '". $date_set ."';" ;

  $checkSteps= mysqli_query($connection, $query);
  
  if ($checkSteps-> num_rows<1) {
  	$addSteps = "INSERT INTO readings (username, date_read, date_entered, add_walk, steps, method) VALUES ('". $username ."', '". $date_set ."', NOW(), '". $walk ."','". $input ."', '". $method ."');" ;
   if (mysqli_query($connection, $addSteps))
    { $_SESSION['valid'] = true;
      $_SESSION['timeout'] = time();
      $_SESSION['username'] = $username;
         $msg="Success";}
         else {$msg="Fail";}
   }
   else {	
    	$row = mysqli_fetch_array($checkSteps);
    	$oldsteps = $row['steps'];
    	$oldwalk = $row['add_walk'];
    	$oldmethod = $row['method'];
    	if ($input=="" ||$input==0){
    		$input=$oldsteps;
    	}
    	if ($walk==""){
    		$walk=$oldwalk;
    	} 
    	if ($method=="" ||isset($method)==0){
    		$method=$oldmethod;
    	}
    	$addSteps = "UPDATE readings SET date_entered=NOW(), add_walk=". $walk .", steps='". $input ."', method='". $method ."' WHERE username='". $username ."' AND date_read='". $date_set ."';";
    	if (mysqli_query($connection, $addSteps)){
    		$msg="Success";
    	}
    	else {$msg="Fail";}
   }
 }
if ($msg=='') {$msg="unknown";}
echo $msg;

mysqli_free_result($checkSteps);
mysqli_close($connection);
exit;
?>
