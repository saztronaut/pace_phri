<?php include './template.php';?>
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
            <button type="button" class="btn btn-default" id="getcodesBtn" onclick="getCodes()">
      <span class="glyphicon glyphicon-pencil"></span> &nbsp; Generate Codes </button> </div>
 </form>
 </div>
 <?php include './footer.php';?>
<script src="download.js"></script>
 <script> 
 window.onload = checkPrivilege('R');

 function checkPrivilege(min_account){
 	///check to see if user has sufficient privileges for page
 	data="min_account="+ min_account;
 	doXHR('./checkRights.php', function(){
 	var response=this.responseText;
 	if (response=="0"){
 	 window.location.assign('./landing_text.php');
 				}
 	  else {;}
 //	  return response;
 	}, data);

 	}

function getCodes(){
	  // validate the form on the client side, double password match, etc
	  // remove special chars
	  var practice = document.getElementById("practice").value;
	  var n_codes = document.getElementById("n_codes").value;  
	  data =  "practice=" + practice + "&n_codes=" + n_codes;
      url = './get_reg_codes.php';
      var d=new Date();
      var today = d.getDate() +"_"+ (d.getMonth()+1) +"_"+  d.getFullYear();      
      filename= "reg_codes_"+ practice +"_"+ today +".csv";
      createDownload(filename, url, data);

}

 </script>
 