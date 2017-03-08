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
  getConsent(action, data);
  //var consent= continueConsent(action, data);
	}
  else { 
	  document.getElementById('errorMessage').innerHTML = "Please fill out all the fields correctly";
  }
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

function getConsent(action, data){
	
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", './checkconsent.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.onreadystatechange = function () {
	      if(xhr.readyState == 4 && xhr.status == 200) {
	        var result = xhr.responseText;
	        console.log('Result: ', result);
	        if (result==2 || result==""){
            	//the registration code as not valid	        	
	        }
	        else{ 
	       	 var getconsent= "<form> <div class='form-group' id='consent-form'>";
	    	 // if the registration code has a consent form recorded, only ask for consent in terms of the website. 
	    	 getconsent+="<strong>Please read the form carefully and check each box to state you agree</strong><br>";
	        
	        if (result==1){;
            	//this user has already signed consent
       	 getconsent+="<div class='row'> <div class='col-md-10'><p>I agree to take part in PACE-UP Next Steps</p></div>";
    	 getconsent+="<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='e_consent_a'><br></div></div></div>";
	   	 getconsent+="<div class='row'> <div class='col-md-10'><p>I have read and understood the <a href='./privacy.php' target='_blank'>privacy policy</a></p></div>";
		 getconsent+="<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='privacy'><br></div></div></div>";
		 getconsent+="<div class='row'> <div class='col-md-10'><p>I have read and understood the <a href='./cookies.php' target='_blank'>cookies policy</a> </p></div>";
		 getconsent+="<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='cookies'><br></div></div></div>";
            }
            else if (result==0){//this user has not signed consent
           	 //read and understood
           	 getconsent+='<div class="row"> <div class="col-md-10"> <p>I have read and understood the Patient Information Sheet for PACE-UP Next Steps. I have had the opportunity to consider the information</p></div>';
        	 getconsent+="<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='e_consent'><br></div></div></div>";
        	 //my participation is voluntary
        	 getconsent+="<div class='row'> <div class='col-md-10'><p>I understand that my participation is voluntary and that I am free to withdraw at any time, without giving any reason, without my medical care or legal rights being affected</p></div>";
        	 getconsent+="<div class='col-md-2'> <div class='checkbox'> <input type='checkbox' value='1' id='e_consent_v'><br></div></div></div>";
        	 //agree to participate
        	 getconsent+="<div class='row'> <div class='col-md-10'><p>I agree to take part in PACE-UP Next Steps</p></div>";
        	 getconsent+="<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='e_consent_a'><br></div></div></div>";
        	 //GP records
        	 getconsent+="<div class='row'> <div class='col-md-10'><p>I give permission for my GP records to be looked at by responsible individuals from St Georges, University of London </p></div>";
        	 getconsent+="<div class='col-md-2'><div class='checkbox' ><input type='checkbox' value='1' id='e_consent_gp'><br></div></div></div>";
        	 //agree to contact
        	 getconsent+="<div class='row'> <div class='col-md-10'><p>I agree to being contacted for a short telephone interview about my physical activity and taking part in this study, if I am selected for this </p></div>";
        	 getconsent+="<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='e_consent_t'><br></div></div></div>";	
    	   	 getconsent+="<div class='row'> <div class='col-md-10'><p>I have read and understood the <a href='./privacy.php' target='_blank'>privacy policy</a></p></div>";
    		 getconsent+="<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='privacy'><br></div></div></div>";
    		 getconsent+="<div class='row'> <div class='col-md-10'><p>I have read and understood the <a href='./cookies.php' target='_blank'>cookies policy</a> </p></div>";
    		 getconsent+="<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='cookies'><br></div></div></div>";             
        	 getconsent+="<a href='#' data-toggle='tooltip' title=''><strong> Please complete this information</strong></a>";
    		 getconsent+="<div class='row'> <div class='col-md-1'></div> <div class='col-md-3'><strong> Gender </strong>";
             getconsent+="<label class='checkbox'><input type='checkbox' value='F'> Female</label>";
             getconsent+="<label class='checkbox'><input type='checkbox' value='M'> Male</label></div>";
             getconsent+="<div class='col-md-4'><strong> Ethnicity </strong>";
             getconsent+="<label class='checkbox'><input type='checkbox' id='ethnicity' value='W'> White</label>";
             getconsent+="<label class='checkbox'><input type='checkbox' id='ethnicity'  value='M'> Mixed/multiple ethnicities</label>";
             getconsent+="<label class='checkbox'><input type='checkbox' id='ethnicity'  value='A'> Asian/Asian British</label>";
             getconsent+="<label class='checkbox'><input type='checkbox' id='ethnicity'  value='B'> Black/African/Caribbean/Black British</label>";
             getconsent+="<label class='checkbox'><input type='checkbox' id='ethnicity'  value='O'> Other ethnic group</label></div>";
             getconsent+="<div class='col-md-4'><strong> Age </strong>";
             getconsent+="<label class='checkbox'><input type='checkbox' id='age' value='40'> 40-59 years</label>";
             getconsent+="<label class='checkbox'><input type='checkbox' id='age'  value='60'> 60-74 years </label>";
             getconsent+="<label class='checkbox'><input type='checkbox' id='age'  value='75'> 75 years and older</label></div></div>";
           
            }

		 getconsent+="</div></form></div>";
		 getconsent+='<div class="modal-footer">';
		 getconsent+='<button type="button" class="btn btn-default" onclick="continueConsent(\''+ action +'\',\''+ data +'\',\''+ result+'\')"> Continue </button></div>';
		 console.log(data);
		 document.getElementById('consent_message').innerHTML= getconsent;
		 $('#consentModal').modal('show');
            
	      }
	    }}
	  xhr.send(data);	  
              	
	  }

function continueConsent(action, data, result){

	  var form = document.getElementById("consent-form");
	  var cookies= document.getElementById("cookies").value;
	  var privacy= document.getElementById("privacy").value;
	  var e_consent_a= document.getElementById("e_consent_a").value;
	  var consented=0;
	  if (result==1 && privacy=='1' && cookies=='1' && e_consent_a=='1'){
		  var e_consent='';
		  var e_consent_gp='';
		  var e_consent_t='';
		  var e_consent_v='';
		  consented=1;
	  }
	  else if (result==0){
		  var e_consent= document.getElementById("e_consent").value;
		  var e_consent_v= document.getElementById("e_consent_v").value;
		  var e_consent_gp= document.getElementById("e_consent_gp").value;
		  var e_consent_t= document.getElementById("e_consent_t").value;
	   if (e_consent=='1' && e_consent_v=='1' && e_consent_a=='1' && e_consent_gp=='1' && e_consent_t=='1' && privacy=='1' && cookies=='1'){
		  consented=1;}
	  }
	  if (consented==1){
		  var consentdata ="e_consent="+e_consent+"&e_consent_v="+e_consent_v+"&e_consent_a="+e_consent_a+"&e_consent_gp="+e_consent_gp+"&e_consent_t="+e_consent_t;
	  console.log(consentdata);
	  //check is filled out? 
	  data+="&"+consentdata;
	  console.log(data);
	  makeRequest(action, data);}
	
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

$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();;
})
