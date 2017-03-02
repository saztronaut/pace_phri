<br>
<br>
<div class="container-fluid text-center">
  
  <form class="form-signin" method="POST" action="./add-practice.php" id="add=practice">

        <h2 class="form-signin-heading">Add New Practice</h2><hr />

		<p id="errorMessage"></p>
	        <div class="form-group" id = "practice_div">
        <input type="text" class="form-control" placeholder="Practice Name" name="practice" id="practice" >
        <span id= "practice_span"></span>
        </div>
        <div class="form-group" id = "pracID_div">
        <label for="pracID">Give practice a three letter code, for example 'GWD' for 'Greyswood Practice' </label>
        <input type="text" class="form-control" placeholder="Practice Name" name="pracID" id="pracID" >
        <span id= "pracID_span"></span>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-default" id="addBtn">
      <span class="glyphicon glyphicon-home"></span> &nbsp; Add Practice </button> </div>
 </form>
 </div>
 <script>
 //check that the code Practice name and the code are unique, and that both fields are entered and both are unique
 
 //if this is satisfied, then add the practice to the database
  var addBtn = document.getElementById("addBtn");
addBtn.addEventListener("click", addPractice);

function addPractice(){
	  // validate the form on the client side, double password match, etc
	  // remove special chars
	  console.log("addPractice");
	  var practice = document.getElementById("practice").value;
	  var pracID = document.getElementById("pracID").value;  
	  if (validateID('pracID')==1 && practice!=""){
		  console.log("valid");
	  data =  "practice=" + practice + "&pracID=" + pracID;
      url = './add-practice.php';
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", url, true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.send(data);
	  xhr.onreadystatechange = function () {
	  if(xhr.readyState == 4 && xhr.status ==200){
	  var $response = xhr.responseText;
	  document.getElementById("errorMessage").innerHTML=$response;
	  }
	  document.getElementById("errorMessage").innerHTML="Waiting for response";
	  }}
	  document.getElementById("errorMessage").innerHTML="<p> You must enter a practice name and ID</p>";
	  
	  ;
	  
}

$('#pracID').bind('input', function(){
	validateID('pracID');
})

function validateID (input){
		var divname= input +"_div";
		var msgname= input +"_span";
		valid = 0
		var value= document.getElementById(input).value;
		console.log(value);
		
		var message = "";

		if (value.length==3){
			formgroup="form-group";
			message= "";
			valid=1;}
		else { 
		   message="Practice code must be 3 letters long";
		   formgroup="form-group has-error";
			document.getElementById(msgname).className= "help-block";
		}
		
		 document.getElementById(divname).className= formgroup;	
		 document.getElementById(msgname).innerHTML= message;	

		return valid;
	}
;

 </script>
 