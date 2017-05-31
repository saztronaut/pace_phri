<?php include './template.php';?>
<br><br>
<div class="container-fluid text-center">

<form class="form-signin" method="POST" action="./process_pwd_reset.php" id="reset-form">

<h2 class="form-signin-heading">Reset Password</h2><hr />

		<p id="feedbackMessage"></p>
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
       <hr />
        <div class="form-group">
            <button type="button" class="btn btn-default" id="resetBtn">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Reset Password </button> </div>
 </form>
 </div>
<?php include './footer.php';?>
  <script src="reset.js"> </script>