function login() {
  var form = document.getElementById("login-form");
  var action = form.getAttribute("action");
  // validate the form on the client side, double password match, etc
  // remove special chars
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;  
  var data = "email=" + email + "&password=" + password;
  makeRequest(action, data);
}


function makeRequest(url, data) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(data);
  xhr.onreadystatechange = function () {
  if(xhr.readyState == 4 && xhr.status ==200){
  var $response = xhr.responseText;
  console.log($response);
    if ($response==1){
    	//refresh the page
    	window.location.reload(true);
    }
    else if ($response ==0){
    	document.getElementById('response').innerHTML= 'Incorrect email, username or password';  
    	  console.log($response);    	
    }
    else if ($response ==2){
    	document.getElementById('response').innerHTML= 'Please provide both values';  	
    	  console.log($response);
    }
  }
  }
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

var button = document.getElementById("loginBtn");
button.addEventListener("click", login);	
