<?php
function checkRights($minRole){
    require 'database.php';
    if (isset($_SESSION['username'])){
        $username = htmlspecialchars($_SESSION['username']);
        $token=MD5($_SESSION['session_token']);
        // practice tells you which practice the codes are for
        // n codes tells you how many codes to generate
        $checkauth= "SELECT roleID FROM users as u, sessions as s  WHERE u.username=s.username AND u.username='". $username ."' AND s.session='". $token ."' ;";
        $result= mysqli_query($connection, $checkauth) or die(0);
        $row = mysqli_fetch_array($result);

    switch ($minRole) {
	case 'U' : 
		if ($row['roleID']=="S"||$row['roleID']=="R"||$row['roleID']=="U"){ 
			return 1;
		} else {
			return 0;};
	    break;
	case 'R' : 
		if ($row['roleID']=="S"||$row['roleID']=="R"){ return 1;
		} else {
			return 0;
		};
	    break;
	case 'S' : 
		if ($row['roleID']=="S"){ 
			return 1;
		} else {
			return 0;
		};
	    break;
    }
    } else {
	return 0;
    }
}

?>
