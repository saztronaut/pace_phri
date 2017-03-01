<div class="jumbotron text-center">
<h1>PACE-UP</h1>
<p>A Pedometer Intervention to Increase Walking in Adults</p>
<p> Reset your password</p>

<form class="form-inline" method="POST" id="reset_pwd">
<div class="form-group" id="email_div">
<label for="email">Email address:</label>
<input type="email" class="form-control" id="email">

</div>
<button type="button" class="btn btn-default"  id="resetBtn">Reset</button>
</form>
<p id= "response"></p>
</div>
<script>

var button = document.getElementById("resetBtn");
button.addEventListener("click", redirect);

function redirect(){
	  var data= document.getElementById('email').value;
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", './createPasswordToken.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.onreadystatechange = function () {	  
	  if(xhr.readyState == 4 && xhr.status ==200){		
		  var $response = xhr.responseText;
		  document.getElementById("response").innerHTML= "Please check your inbox - you should have received an email to reset your password";
		  console.log($response);
	  }
	  }
	  xhr.send('email='+data);  
	}
	
</script>

