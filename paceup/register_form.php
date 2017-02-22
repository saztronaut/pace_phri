<br><br>
<div class="container-fluid text-center">
  
  <form class="form-signin" method="POST" action="./register.php" id="register-form">

        <h2 class="form-signin-heading">Sign Up</h2><hr />

		<p id="errorMessage"></p>
        <div class="form-group" id = "username_div">
        <input type="text" class="form-control" placeholder="Username" name="username" id="username" >
        <span id= "username_span"></span>
        </div>

        <div class="form-group" id = "email_div">
        <input type="email" class="form-control" placeholder="Email address" name="email" id="user_email" pattern= "[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
        <span id="check-e"></span><span id= "email_span"></span>
        </div>

        <div class="form-group" id = "password_div">
        <input type="password" class="form-control" placeholder="Password" name="password" id="password" >
        <span id= "password_span"></span></div>

        <div class="form-group" id="cpassword_div">
        <input type="password" class="form-control" placeholder="Retype Password" name="cpassword" id="cpassword">        
        <span id= "cpassword_span"></span></div>
		<div class="form-group" id="method_div">
		<?php include 'method.php'; ?>
		<span id= "method_span"></span>
		</div>
        <div class="form-group" id="registration_div">
        <input type="text" class="form-control" placeholder="Registration code" name="registration" id="registration" >
        <span id= "registration_span"></span>
        </div>
       <hr />
        <div class="form-group">
            <button type="button" class="btn btn-default" id="registerBtn">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account </button> </div>
 </form>
 </div>

  <script src="register.js"> </script>

