<?php

//Just returns the data from the methods table

require 'database.php';
require 'sessions.php';

$methodsarray=[];

$methods = "SELECT methodID, method_name FROM methods;";
$getmethods = mysqli_query($connection, $methods)
or die("Error getting methods" . mysql_error());
while ($drawmethods = mysqli_fetch_array($getmethods, MYSQLI_ASSOC)) {
	$methodsarray[$drawmethods['methodID']]=$drawmethods['method_name'];
}

if (empty($methodsarray)){
	echo 0;
	
}
else {
	echo json_encode($methodsarray);	
}

mysqli_close($connection);

exit;
