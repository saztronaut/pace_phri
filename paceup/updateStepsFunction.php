<?php

function addSteps($username, $input, $date_set, $method, $haswalk=false, $walkon=null) {
 require 'database.php'; 
 require 'updateTargetAutoFunctions.php';
 require 'setBaselineFunctions.php';

     $setwalk = '';
     $walk='';
     $walkarg="";
     if ($haswalk==true) {
          if ($walkon=='true'){
          	$walk = ", '1'";
          	$setwalk= ", add_walk";
          	$walkarg= ", add_walk='1'";
          } else if ($walkon=='false') {
          	$walk = ", '0'";
          	$setwalk= ", add_walk";
          	$walkarg= ", add_walk='0'";
          }
     }
  
     $query = "SELECT username, date_read, date_entered, steps, method, add_walk FROM readings WHERE username = '". $username ."' AND date_read= '". $date_set ."';" ;
     $checkSteps= mysqli_query($connection, $query);
  
     if ($checkSteps-> num_rows<1) {
  	     $addSteps = "INSERT INTO readings (username, date_read, date_entered " . $setwalk . ", steps, method) VALUES ('". $username ."', '". $date_set ."', NOW() ". $walk .",'". $input ."', '". $method ."');" ;
         if (mysqli_query($connection, $addSteps)){ 
         	$_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $username;
            $msg="Success";
   
         // update targets here. 
         //check for baseline steps
         if (setBase($username)==1){
         	$msg = "Refresh";
         } else if (updateTarget($username)==1){
         	$msg = "Refresh";
         }
   
      } else {
      	$msg="Fail";
      }
   } else {	
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

    	$addSteps = "UPDATE readings SET date_entered=NOW() ". $walkarg .", steps='". $input ."', method='". $method ."' WHERE username='". $username ."' AND date_read='". $date_set ."';";
    	if (mysqli_query($connection, $addSteps)){
    		$msg="Success";
    		if (setBase($username)==1){
    			$msg = "Refresh";
    		} else if (updateTarget($username)==1){
    			$msg = "Refresh";
    		}
    		
    	}
    	else {$msg="Fail";}
   }
mysqli_free_result($checkSteps);
mysqli_close($connection);
return $msg;
}

?>