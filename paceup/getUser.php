<?php
    require 'database.php';
	require 'sessions.php';	
$condition=[];
$whereClause="";
if ($_POST){
	if (isset($_POST['practice'])){
		$pracID = htmlspecialchars($_POST['practice']);
		if ($pracID!=""){
			$condition[]="pracID='".$pracID."'";
		}
	} else {
		$pracID="";
	}
	if (isset($_POST['behind'])){
		$behind = htmlspecialchars($_POST['behind']);
		if ($behind==1){
			$condition[]=" username NOT IN  (SELECT username FROM readings WHERE DATEDIFF(CURDATE(), date_read)<7)";
		}
	} else {
		$behind="";
	}
	if (isset($_POST['verybehind'])){
		$verybehind = htmlspecialchars($_POST['verybehind']);
		if ($verybehind==1){
			$condition[]=" username NOT IN  (SELECT username FROM readings WHERE DATEDIFF(CURDATE(), date_read)<28)";
		}
	} else {
		$verybehind="";
	}
	if (isset($_POST['finished'])){
		$finished = htmlspecialchars($_POST['finished']);
		if ($finished==1){
			$condition[]=" (finish_show>1)";
		}
	} else {
		$finished="";
	}
	if (isset($_POST['not_finished'])){
		$not_finished = htmlspecialchars($_POST['not_finished']);
		if ($not_finished==1){
			$condition[]=" (finish_show=0)";
		}
	}
	if (isset($_POST['has_quest'])){
		$has_quest = htmlspecialchars($_POST['has_quest']);
		if ($has_quest==1){
			$condition[]=" username IN (SELECT username FROM questionnaire)";
		}
	}
	if (isset($_POST['no_quest'])){
		$no_quest = htmlspecialchars($_POST['no_quest']);
		if ($no_quest==1){
			$condition[]=" username NOT IN (SELECT username FROM questionnaire)";
		}
	}
} else {$pracID ="";}

$n_clause= count($condition)-1;
if ($n_clause>=0){
$whereClause=" WHERE ". $condition[0];
} else {
	$whereClause= "";
}


for ($x=1; $x<=$n_clause; $x++){
	$whereClause.=" AND ". $condition[$x];
	
}

  $lookup = "SELECT username, forename, lastname, email, referenceID FROM users ". $whereClause .";";
  $result = mysqli_query($connection, $lookup) 
    or die($lookup . mysql_error());
  if ($result){
//	echo "<select name='user' id='chooseUser' class='form-control'>";
//	echo "<option value='' disabled selected> Select the user</option>";
//		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//			echo "<option value='". $row['username'] ."'> ". $row['username'] ." </option> ";}		
		
		
//	echo "</select>";
    echo json_encode(mysqli_fetch_all($result));
  }
	else {
		echo $lookup;
	}


//	exit;
?>