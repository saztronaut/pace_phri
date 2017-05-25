<?php include './template.php';?>
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
<?php include './footer.php';?>
<script>

var button = document.getElementById("resetBtn");
button.addEventListener("click", redirectGo);

function redirectGo(){
	  var data= document.getElementById('email').value;
	  doXHR('./createPasswordToken.php', function () {	  	
		  var $response = this.responseText;
		  document.getElementById("response").innerHTML= "Please check your inbox - you should have received an email to reset your password";
		  console.log($response);
	  }, 'email='+data);  
	}
	
</script>

