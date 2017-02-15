
<?php
	if (isset($_SESSION['username'])){
	  $username = $_SESSION['username'];
	  echo "<li><a href='#'><span class='glyphicon glyphicon-user'></span> Welcome " . $username . " </a></li>";
    echo "<li><a href='./logout.php'><span class='glyphicon glyphicon-log-in'></span> Log out</a></li>";
	}
	else
	{
	echo "<li><a href='./newUser.php'><span class='glyphicon glyphicon-user'></span> Sign Up </a></li>";
    echo "<li><a href='./index.php'><span class='glyphicon glyphicon-log-in'></span> Login </a></li>";

	}

?>
