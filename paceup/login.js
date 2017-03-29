
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

  doXHR(url, function () {
  var $response = this.responseText;
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
  }, data);
}

//



var logbutton = document.getElementById("loginBtn");
logbutton.addEventListener("click", login);	




