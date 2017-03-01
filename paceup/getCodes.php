<br><br>
<div class="container-fluid text-center">
  
  <form class="form-signin" method="POST" action="./get_codes.php" id="register-code">

        <h2 class="form-signin-heading">Get Registration Codes</h2><hr />

		<p id="errorMessage"></p>
		<div class="form-group" id="practice_div">
		<?php include 'practice.php'; ?>
		<span id= "practice_span"></span>
		</div>
        <div class="form-group" id="n_div">
        <select name='n_codes' id='n_codes' class='form-control' >
	     <option value='' disabled selected> How many codes do you want to generate?</option>
         <option value='1'> 1 code</option> 
         <option value='5'> 5 codes</option> 		
         <option value='10'> 10 codes</option> 
         <option value='15'> 15 codes</option> 
         <option value='20'> 20 codes</option> 
         <option value='50'> 50 codes</option> 
        </select>        
        <span id= "n_span"></span>
        </div>
       <hr />
        <div class="form-group">
            <button type="button" class="btn btn-default" id="getcodesBtn">
      <span class="glyphicon glyphicon-pencil"></span> &nbsp; Generate Codes </button> </div>
 </form>
 </div>

 <script>
 var codeBtn = document.getElementById("getcodesBtn");
codeBtn.addEventListener("click", getCodes);

function getCodes(){
	  // validate the form on the client side, double password match, etc
	  // remove special chars
	  var practice = document.getElementById("practice").value;
	  var n_codes = document.getElementById("n_codes").value;  
	  data =  "practice=" + practice + "&n_codes=" + n_codes;
      url = './get_reg_codes.php';
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", url, true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.send(data);
	  xhr.onreadystatechange = function () {
	  if(xhr.readyState == 4 && xhr.status ==200){
	  var $response = xhr.responseText;
	  document.getElementById("n_span").innerHTML=$response;
	  }
	  };
	  
}

 </script>
 