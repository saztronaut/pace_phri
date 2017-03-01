<?php
if($_POST)
{ 
    require 'database.php';
	require 'sessions.php';	
  if (isset($_POST['object_id'])) {$give_name = $_POST['object_id']; } else {$give_name = 'steps'; }
  if (isset($_POST['preference'])) {$give_pref = $_POST['preference']; } else {$give_pref = 'PED'; }
}
else {
	$give_name = 'steps';
	$give_pref = 'PED';
	
}

  
  $lookup = "SELECT methodID, method_name FROM methods;";
  $result = mysqli_query($connection, $lookup) 
    or die("Hmm, that didn't seem to work" . mysql_error());
	echo "<select name='". $give_name ."' id='". $give_name ."' class='form-control' >";
	echo "<option value='' disabled selected> Select the device you are using to track your steps</option>";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			if ($row['methodID']==$give_pref){
				echo "<option selected='selected' value='". $row['methodID'] ."'> ". $row['method_name'] ." </option> ";
			}
			else{
			echo "<option value='". $row['methodID'] ."'> ". $row['method_name'] ." </option> ";}		
		}		
		
	echo "</select>";
	
	mysqli_free_result($result);
//	exit;
?>