<?php
 require 'database.php';
 require 'sessions.php';
 //Adds a comment to the database
 $msg=''; 
 if ($_POST)
 {$username = htmlspecialchars($_SESSION['username']);
 $week = htmlspecialchars($_POST['weekno']);
 $comment = htmlspecialchars($_POST['comment']);
 //Stringify adds quotation marks on to parse the info and this is converted to &quot; 
 //strip the first and last 5 chars off the string
 $comment=trim($comment, "&quot;");
 $comment=str_replace("'", "", $comment);
 
 if ($comment!='' && $username!='' && $week!=''){
 	//is this an existing comment or a new one
   $findComment = "SELECT * FROM notes WHERE username='".$username."' AND week='".$week."';";
   $result=mysqli_query($connection, $findComment) or die("Error looking at notes query".mysql_error());
   if ($result->num_rows==0){
   	//Comment does not already exist
 	$addComment= "INSERT INTO notes (username, week, text) VALUES('".$username."','".$week."','".$comment."');" ;
 	if (mysqli_query($connection, $addComment) or die("Error adding comment".mysql_error())){
 		$msg=1;
 	} else {$msg=0;}
 	}
   else{
   	//Comment should be updated
   	$updateComment="UPDATE notes SET text='".$comment."' WHERE username='".$username."' AND week='".$week."';";
   			if (mysqli_query($connection, $updateComment) or die("Error adding comment".mysql_error())){
   				$msg=1;
   			} else {$msg=0;}
   }	
 }
 }
 echo $msg;
exit;
?>
