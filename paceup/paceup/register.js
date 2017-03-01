function registerNewUser() {
  var form = document.getElementById("register-form");
  var action = form.getAttribute("action");
  var keep_going = validateRegistration(form);
  //validate the form on the client side, double password match, etc
  //remove special chars
  //password must be hashed with salt (constant on client side, random per user on server side)
  if (keep_going==1) {
  var data = $(form).serialize();
  console.log(data);
  makeRequest(action, data);
  
	}
  else { 
	  document.getElementById('errorMessage').innerHTML = "Please fill out all the fields correctly";
  }
}

function displayErrors(error_string){
	
}


function makeRequest(url, data) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
      if(xhr.readyState == 4 && xhr.status == 200) {
        var result = xhr.responseText;
        console.log('Result: ', result);

          var json = JSON.parse(result, function(key, value) {
        	  if (key=="success"){
        	    	//refresh the page
        	    	window.location.reload(true);
        	  }
        	  else if (key==""){	  
        	  }
        	  else{
        		  giveFeedback(key, value, true);
        	  }
          })

        
      }
    }
  xhr.send(data);
  }



function validateRegistration(myform) {
	var validate = 1;
    if (validateUser()==0){
    	validate=0;
    }
	if (validateEmail('user_email')==0){
		validate=0;
	}
	if (validateCopy(copy_pass.value, pass.value)==0){
		validate=0;
	}
	if (document.getElementById('steps').value==""){
		document.getElementById('steps').value="PED";
	}
	if (document.getElementById('registration')==""){
		validate=0
	}

	return validate;
 }
	
function validateUser(){
	if (document.getElementById("username").value==''){
		  giveFeedback('username', "Please enter a username", true);			
		return 0;
	}
	else {
		  giveFeedback('username', "", false);	
		  return 1;
	}
}

function validateCopy(copy_pass, pass) {
	var passwordmatch = 0;
	if (pass==""){
		  giveFeedback('password', "Please enter a password", true);
	}
	else{
		 giveFeedback('password', "", false);
	}
	if (pass==copy_pass && pass!='') {
		passwordmatch=1;
	   giveFeedback('cpassword', "", false);
	}
	else {
	   giveFeedback('cpassword', "Please make sure both passwords match", true);
	}	
  return passwordmatch;
	
}

function validateEmail(email) {
	var isEmail=1
	var patt= new RegExp(document.getElementById(email).pattern);
	if (patt.exec((document.getElementById(email).value))) {
	  giveFeedback('email', "", false);
	}
	else{		
		isEmail= 0;
      giveFeedback('email', "Please enter a valid email address", true);	  
	}	
	return isEmail;
}

function giveFeedback(x, message, error){
	//x is the object of feedback, message is the feedback message, error =yes if about an error or no if not error
	
	var divname= x +"_div";
	var msgname= x +"_span";
	if (error==true){ 
		formgroup="form-group has-error";
		document.getElementById(msgname).className= "help-block";
		}
	else { 
		formgroup="form-group";
		}
	 document.getElementById(divname).className= formgroup;	
	 document.getElementById(msgname).innerHTML= message;	

	
}

function getOther(methodv){
	
	console.log (methodv);
	if (methodv=="ZZZ"){
         $showother= '<div class="form-group" id = "method_other_div">';
        $showother+='<input type="text" class="form-control" placeholder="Enter other method of recording seps" name="other_method" id="other_method"> </div>';
         document.getElementById('method_other_span').innerHTML= $showother;
    }
    else {    show_other=document.getElementById('method_other_span').innerHTML='';}

}

var button = document.getElementById("registerBtn");
button.addEventListener("click", registerNewUser);	

var getmethod = document.getElementById("steps");
$('#steps').bind('input', function(){
	getOther(getmethod.value);
});

getmethod.addEventListener("change", getOther(getmethod.value));

var copy_pass = document.getElementById("cpassword");
var pass= document.getElementById("password");

//watch for input into the password copy field and validate the password
$('#cpassword').bind('input', function(){
	validateCopy(copy_pass.value, pass.value);
});

$('#user_email').bind('input', function(){
	validateEmail('user_email');
});
