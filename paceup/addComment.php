<?php
 require 'database.php';
 require 'sessions.php';
 //Adds a comment to the notes table for a given user
 $msg=''; 
 if ($_POST) { 
	$username = filter_var($_SESSION['username'], FILTER_SANITIZE_STRING);
 	$week = filter_var($_POST['weekno'], FILTER_VALIDATE_INT);
 	$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES);
 //Stringify adds quotation marks on to parse the info and this is converted to &quot; 
 //strip the first and last 5 chars off the string
 	$comment=trim($comment, "&quot;");
 	$comment=str_replace("'", "", $comment);
 
 if ($comment!='' && $username!='' && $week!=''){
 	//is this an existing comment or a new one
 	$findComment = "SELECT week FROM notes WHERE username=? AND week=?";
 	$stmt = $connection->stmt_init();
   if ($stmt->prepare($findComment)){
       $stmt->bind_param("si", $username, $week);
       $stmt->execute();
       $stmt->store_result();
       $result= $stmt->num_rows;
       //$result= ;

   //$result=mysqli_query($connection, $findComment) or die("Error looking at notes query".mysql_error());
   if ($result==0){
   	//Comment does not already exist
   	 	$stmt = $connection->stmt_init();
   	$addComment = "INSERT INTO notes (username, week, text) VALUES(?, ?, ?)";
   	if ($stmt->prepare($addComment)){
   	     $stmt->bind_param("sis", $username, $week, $comment);
         $stmt->execute(); 
 		$msg=1;
 	} else {$msg=0;}
 	}
   else{
   	//Comment should be updated
   	   	 	$stmt = $connection->stmt_init();
   	        $updateComment="UPDATE notes SET text=? WHERE username=? AND week=?;";
   	           	if ($stmt->prepare($updateComment)){
   	     $stmt->bind_param("ssi", $comment, $username, $week);
         $stmt->execute();     
 		$msg=1;
 	} else {$msg=0;}
   }
        
 }
 }
 }
 $connection-> close; 
 echo $msg;
exit;
?>
