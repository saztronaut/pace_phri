
<div class="jumbotron text-center">
<h1>PACE-UP</h1>
<p>A Pedometer Intervention to Increase Walking in Adults</p>
<p> Record your steps online and track your progress</p>

<form class="form-inline" method="POST" action="./login.php" id="login-form">
<div class="form-group" id="email_div">
<label for="email">Email address:</label>
<input type="email" class="form-control" id="email">

</div>
<div class="form-group" id = "password_div">
<label for="password">Password:</label>
<input type="password" class="form-control" id="password">
</div>
<button type="button" class="btn btn-default"  id="loginBtn">Submit</button>

</form><p id= "response"></p><br>

<form class="form-inline" id ="reset-form">
<p> First time logging in? <a href="./register_form.php">Click here to sign up</a> </p>
<label for="resetBtn"> Forgotten your password? :</label>
<button type="button" class="btn btn-default" id="resetBtn" onclick = "redirect('./reset_password.php')" >Click here</button>

</form>
</div>
<script src="login.js"> </script>

