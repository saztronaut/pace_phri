<br><br>
<div class="container-fluid text-center">
  
  <form class="form-signin" method="POST" action="./register.php" id="register-form">

        <h2 class="form-signin-heading">Sign Up</h2><hr />

		<p id="errorMessage"></p>
        <div class="form-group" id = "username_div">
        <input type="text" class="form-control" placeholder="Username" name="username" id="username" >
        <span id= "username_span"></span>
        </div>
        <div class="form-group" id = "firstname_div">
        <input type="text" class="form-control" placeholder="First name" name="firstname" id="firstname" >
        <span id= "firstname_span"></span>
        </div>
        <div class="form-group" id = "lastname_div">
        <input type="text" class="form-control" placeholder="Last name" name="lastname" id="lastname" >
        <span id= "lastname_span"></span>
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
		<!-- ?php include 'method.php'; ? remove php inserts from the code-->
		<span id= "method_span"></span>
		</div>	
	    <span id= "method_other_span"></span>
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

<!-- Modal -->
<div id="consentModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
<br><br>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Participant consent form</h4>
      </div>
      <div class="modal-body">
        <p id="consent_message">
	</p>

      </div>
    </div>

  </div>
</div>

  <script src="register.js"> </script>
<script src="drawMethodsSelect.js"> </script>
