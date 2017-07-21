<?php

if ($_POST){
	$pracID= htmlspecialchars($_POST['practice']);	
	$pracID = preg_replace("/[^A-Za-z]+/", "", $pracID);
	$consent = htmlspecialchars($_POST['consent']);
	$consent = preg_replace("/[^ACHLNOP]+/", "", $consent);
} else {$pracID="";
   $consent="ALL";}
    require 'database.php';
	require 'sessions.php';	
  $condition="";

  switch ($consent){
  	case 'NPC' : $condition = "WHERE e_consent=0 OR e_consent IS NULL";
  	break;
  	case 'NOA' : $condition = "WHERE reference.referenceID NOT IN (SELECT referenceID FROM users) ";
  	break;
  	case 'HPC' : $condition = "WHERE e_consent=1";
  	break;
  	case 'HOA' : $condition = "WHERE reference.referenceID IN (SELECT referenceID FROM users)";
  	break;
  	case 'ALL' : $condition = "WHERE (e_consent=1 OR e_consent=0 OR e_consent IS NULL)";
  	break;
  }
    if ($pracID!=""){$condition .= " AND upper(practice)=upper('".$pracID."')";}
   
$lookup=    "SELECT reference.referenceID, username, forename, lastname
          FROM reference LEFT JOIN users on reference.referenceID = users.referenceID
			". $condition ." ORDER BY referenceID;";
    
//  $lookup = "SELECT referenceID FROM reference ".$condition.";";
  $result = mysqli_query($connection, $lookup) 
    or die("Error getting references" . mysql_error());
  if ($result){
	echo "<select name='ref' id='reference' class='form-control'>";
	echo "<option value='' disabled selected> Select the reference</option>";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			echo "<option value='". $row['referenceID'] ."'> ". $row['referenceID'] .", ". $row['username'] ." ". $row['forename'] ." ". $row['lastname'] ."  </option> ";}		
		
		
	echo "</select>";}
	else { echo $lookup;}


//	exit;
?>