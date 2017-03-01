
<?php
	if (isset($_SESSION['username'])){
	  $username = $_SESSION['username'];
	  $role = $_SESSION['roleID'];
	  if ($role=="R"||$role=="S"){
	  	echo "<li><a href='#' onclick='javascript:redirect2(";
	echo '"./admin.php"';
	echo ")'><span class='glyphicon glyphicon-pencil'></span> Admin </a></li>";
	  }
	  echo "<li><a href='#'><span class='glyphicon glyphicon-user'></span> Welcome " . $username . " </a></li>";
    echo "<li><a href='./logout.php'><span class='glyphicon glyphicon-log-in' id='logout'></span> Log out</a></li>";
	}
	else
	{
	echo "<li><a href='#' onclick='javascript:redirect2(";
	echo '"./register_form.php"';
	echo ")'><span class='glyphicon glyphicon-user'> </span> Sign Up </a></li>";
    echo "<li><a href='#' onclick='javascript:redirect2(";
    echo '"./landing_text.php"';
    echo ")'><span class='glyphicon glyphicon-log-in'></span> Login </a></li>";
	}

?>

<script>
function redirect2(myform){
	  console.log('trigger');
	  var dataString="choose_form=./"+myform;
	  	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", './redirect.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.onreadystatechange = function () {	  
	  if(xhr.readyState ==4 && xhr.status ==200){
		  window.location.reload(true);
	      }
	  }
	  xhr.send(dataString);  
	}




</script>

