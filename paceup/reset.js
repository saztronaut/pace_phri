
function reset() {
  // validate the form on the client side, double password match, etc
  // remove special chars
  var email = document.getElementById("user_email").value;
  var password = document.getElementById("password").value;  
  var cpassword = document.getElementById("cpassword").value; 
  var data = "email=" + email + "&password=" + password + "&cpassword=" + cpassword;
  makeRequest('./process_pwd_reset.php', data);
}


function makeRequest(url, data) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
  if(xhr.readyState == 4 && xhr.status ==200){
  var $response = xhr.responseText;
    	document.getElementById('feedbackMessage').innerHTML= $response;  
    	  console.log($response);    	
    }
  }
  xhr.send(data);
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

var copy_pass = document.getElementById("cpassword");
var pass= document.getElementById("password");


$('#cpassword').bind('input', function(){
	validateCopy(copy_pass.value, pass.value);
});

$('#user_email').bind('input', function(){
	validateEmail('user_email');
});

document.getElementById("resetBtn").addEventListener("click", reset);


