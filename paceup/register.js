  window.onload = function() {
	showMethodsSelect()

	}

function registerNewUser() {
  var form = document.getElementById("register-form");
  var action = form.getAttribute("action");
  var keep_going = validateRegistration(form);
  //validate the form on the client side, double password match, etc
  //remove special chars
  //password must be hashed with salt (constant on client side, random per user on server side)
  if (keep_going==1) {
  var data = $(form).serialize();
  getConsent(action, data);
	}
  else { 
	  document.getElementById('errorMessage').innerHTML = "Please fill out all the fields correctly";
  }
}



function makeRequest(url, data) {

  doXHR(url,  function () {
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
          }, data);

  }



function validateRegistration(myform) {
	var validate = 1;
    if (validateUser('username')==0 ||validateUser('firstname')==0||validateUser('lastname')==0 ||validateEmail('user_email')==0||validateCopy(copy_pass.value, pass.value)==0){
		validate=0;
	}
	if (document.getElementById('steps').value==""){
		document.getElementById('steps').value="PED";
	}
	if (document.getElementById('registration')==""){
		  giveFeedback(registration, "Please enter a registration code", true);			
		validate=0;
	}

	return validate;
 }
	
function validateUser(givename){ //takes the control name as argument
	
    var AZ09 = new RegExp("^[a-zA-Z0-9_]*$");
    var AZ_space = new RegExp("^[a-zA-Z ]*$");
	if (document.getElementById(givename).value==''){
		  giveFeedback(givename, "Please enter a "+givename, true);			
		return 0;
	}
   // Check for white space
	else if (givename=='username') { 
		if(AZ09.test(document.getElementById(givename).value)) {
        //alert("Please Check Your Fields For Spaces");
        return 1;
    } else { 
		  giveFeedback(givename, "Please use only letters and numbers in your username", true);
    	return 0;}}

	else if (AZ_space.test(document.getElementById(givename).value)) {
		  giveFeedback(givename, "", false);	
		  return 1;
	} else { 
			  giveFeedback(givename, "Please use only letters in your name", true);
	    	return 0;}
}

function validateCopy(copy_pass, pass) {
	var passwordmatch = 0;
	var valid= 0;
	var minlength = new RegExp("^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9!$%@#£€*?&]{8,}$");
	if (pass==""){
		  giveFeedback('password', "Please enter a password", true);
	}
	else {
		 giveFeedback('password', "", false);
	}
    if (minlength.test(pass)){
    	valid=1;
	   if (pass==copy_pass && pass!='') {
		passwordmatch=1;
		giveFeedback('password', "", false);
	   giveFeedback('cpassword', "", false);
	          }
	   else {
	      giveFeedback('cpassword', "Please make sure both passwords match", true);
	   }	
       }
    else {giveFeedback('password', "Password must be at least 8 characters long and contain at least 1 letter and 1 number", true);}
  
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
	//check the method select and if "other" then show the "other" box
	if (methodv=="ZZZ"){
         $showother= '<div class="form-group" id = "method_other_div">';
        $showother+='<input type="text" class="form-control" placeholder="Enter other method of recording seps" name="other_method" id="other_method"> </div>';
         document.getElementById('method_other_span').innerHTML= $showother;
    }
    else {show_other=document.getElementById('method_other_span').innerHTML='';}

}

function getConsent(action, data){
	
	 doXHR('./checkconsent',function () {

	        var result = this.responseText;
	        console.log('Result: ', result);
	        var consent='';
	        var valid=1;
	        var json = JSON.parse(result, function(key, value) {
	        	  if (key=="consent"){
	        		  consent=value;
	        	  }
	          	  else if (key=="msg"){	 ; 
	        	  }
	        	  else if (key=="email"|| key=="username"){
	        		  giveFeedback(key, value, true);
	        		  valid=0;
	        	  }
	          })

	        //only show modal popup if the data on the first form is valid
	        if (valid==1 && (consent==1||consent==0)){
	        	var getconsent=[];
	       	 getconsent.push=( "<form> <div class='form-group' id='consent-form'>");
	    	 // if the registration code has a consent form recorded, only ask for consent in terms of the website. 
	    	 getconsent.push=( "<div class='row'> <div class='col-md-10'><strong>Please read the form carefully and check each box to state you agree</strong><br></div>\
	    	 <div class='col-md-2'><strong>* = mandatory</strong></div>");
	        
	        if (consent==1){;
            	//this user has already signed consent
       	 getconsent.push=( "<div class='row'> <div class='col-md-10'><p>I agree to take part in PACE-UP Next Steps </p></div>\
    	 <div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='e_consent_a'>*<br></div></div></div>\
	   	 <div class='row'> <div class='col-md-10'><p>I have read and understood the <a href='./privacy.php' target='_blank'>privacy policy</a> </p></div>\
		 <div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='privacy'>*<br></div></div></div>\
		 <div class='row'> <div class='col-md-10'><p>I have read and understood the <a href='./cookies.php' target='_blank'>cookies policy</a>  </p></div>\
		 <div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='cookies'>*<br></div></div></div>");
            }
            else if (consent==0){//this user has not signed consent
           	 //read and understood
           	 getconsent.push=( '<div class="row"> <div class="col-md-10"> <p>I have read and understood the Patient Information Sheet for PACE-UP Next Steps. I have had the opportunity to consider the information </p></div>');
        	 getconsent.push=( "<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='e_consent'><br>*</div></div></div>");
        	 //my participation is voluntary
        	 getconsent.push=( "<div class='row'> <div class='col-md-10'><p>I understand that my participation is voluntary and that I am free to withdraw at any time, without giving any reason, without my medical care or legal rights being affected</p></div>\
        	 <div class='col-md-2'> <div class='checkbox'> <input type='checkbox' value='1' id='e_consent_v'><br>*</div></div></div>");
        	 //agree to participate
        	 getconsent.push=( "<div class='row'> <div class='col-md-10'><p>I agree to take part in PACE-UP Next Steps</p></div>");
        	 getconsent.push=( "<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='e_consent_a'>*<br></div></div></div>");
        	 //GP records
        	 getconsent.push=( "<div class='row'> <div class='col-md-10'><p>I give permission for my GP records to be looked at by responsible individuals from St Georges, University of London </p></div>\
        	 <div class='col-md-2'><div class='checkbox' ><input type='checkbox' value='1' id='e_consent_gp'><br></div></div></div>");
        	 //agree to contact
        	 getconsent.push=( "<div class='row'> <div class='col-md-10'><p>I agree to being contacted for a short telephone interview about my physical activity and taking part in this study, if I am selected for this </p></div>\
        	 <div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='e_consent_t'><br></div></div></div>\
    	   	 <div class='row'> <div class='col-md-10'><p>I have read and understood the <a href='./privacy.php' target='_blank'>privacy policy</a> *</p></div>\
    		 <div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='privacy'><br></div></div></div>\
    		 <div class='row'> <div class='col-md-10'><p>I have read and understood the <a href='./cookies.php' target='_blank'>cookies policy</a> *</p></div>\
            <div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' id='cookies'><br></div></div></div>\
    		 		<a href='#' data-toggle='tooltip' title=''><strong> Please complete this information</strong></a>\
    		 <div class='row'> <div class='col-md-1'></div> <div class='col-md-3'><strong> Gender </strong>\
            <div class='radio'><label><input type='radio' value='F' name='gender'> Female</label></div>\
             <div class='radio'><label><input type='radio' value='M' name='gender'> Male</label></div></div>\
             <div class='col-md-4'><strong> Ethnicity </strong>\
             <div class='radio'><label><input type='radio' value='W' name='ethnicity'> White</label></div>\
             <div class='radio'><label><input type='radio' value='M' name='ethnicity'> Mixed/multiple ethnicities</label></div>\
             <div class='radio'><label><input type='radio' value='A' name='ethnicity'> Asian/Asian British</label></div>\
             <div class='radio'><label><input type='radio' value='B' name='ethnicity'> Black/African/Caribbean/Black British</label></div>\
             <div class='radio'><label><input type='radio' value='O' name='ethnicity'> Other ethnic group</label></div></div>\
             <div class='col-md-4'><strong> Age </strong>\
             <div class='radio'><label><input type='radio' value='40' name='age'> 40-59 years</label></div>\
             <div class='radio'><label><input type='radio' value='60' name='age'> 60-74 years </label></div>\
             <div class='radio'><label><input type='radio' value='75' name='age'> 75 years and older</label></div></div></div>\
             <span id='modal_feedback'></span>");
            }

		 getconsent.push('</div></form></div>\
		 <div class="modal-footer">');
		 getconsent.push('<button type="button" class="btn btn-default" onclick="continueConsent(\''+ action +'\',\''+ data +'\',\''+ consent+'\')"> Continue </button></div>');
		 console.log(data);
		 consentdialog=getconsent.join("");
		 document.getElementById('consent_message').innerHTML= consentdialog;
		 $('#consentModal').modal('show');
            
	      } else if (consent==2||consent==""){
	        	console.log(consent);
	        	giveFeedback('registration', 'Sorry, this registration code is not valid', true);	        	
	        }
	    }, data);	  
              	
	  }

function showMethodsSelect(){
	 doXHR("./getMethods.php", function getThisArray(){
		  var methods = JSON.parse(this.responseText); //methods just contains the potential methods that the user could draw from
		  var pref_method="PED";
		  document.getElementById('method_div').innerHTML=selectMethods("steps", "PED", methods);
		  
	 
	 });
	
}

function continueConsent(action, data, result){
	 
	  console.log(data);
	  var form = document.getElementById("consent-form");
	  if (document.getElementById("cookies").checked){ var cookies=1 ;} else { var cookies=0 ;}
	  if (document.getElementById("privacy").checked){ var privacy=1 ;} else { var privacy=0 ;}
	  if (document.getElementById("e_consent_a").checked){ var e_consent_a=1 ;} else { var e_consent_a=0 ;}
	  console.log(e_consent_a);
	  var consented=0;
	  if (result==1 && privacy==1 && cookies==1 && e_consent_a==1){
		  var e_consent='';
		  var e_consent_gp='';
		  var e_consent_t='';
		  var e_consent_v='';
		  var age ='';
	      var ethnicity = '';
		  var gender='';
		  consented=1;
	  }
	  else if (result==0){
		  if (document.getElementById("e_consent").checked){ var e_consent=1 ;} else { var e_consent=0 ;}
		  if (document.getElementById("e_consent_gp").checked){ var e_consent_gp=1 ;} else { var e_consent_gp=0 ;}
		  if (document.getElementById("e_consent_v").checked){ var e_consent_v=1 ;} else { var e_consent_v=0 ;}
		  if (document.getElementById("e_consent_t").checked){ var e_consent_t=1 ;} else { var e_consent_t=0 ;}
		  var age = $('input[name=age]:checked').val();
		  var gender = $('input[name=gender]:checked').val();
		  var ethnicity = $('input[name=ethnicity]:checked').val();
	   if (e_consent=='1' && e_consent_v=='1' && e_consent_a=='1' && privacy=='1' && cookies=='1'){
		  consented=1;}
	  }
	  if (consented==1){
		  var consentdata ="e_consent="+e_consent+"&e_consent_v="+e_consent_v+"&e_consent_a="+e_consent_a+"&e_consent_gp="+e_consent_gp+"&e_consent_t="+e_consent_t + "&age="+age+"&gender="+gender+"&ethnicity="+ethnicity;
	  data+="&"+consentdata;
	  makeRequest(action, data);}
	  else { document.getElementById('modal_feedback').innerHTML="<strong>Please fill out all the fields</strong>";}
	
}

var button = document.getElementById("registerBtn");
button.addEventListener("click", registerNewUser);	

//var getmethod = document.getElementById("steps");

$('#steps').bind('input', function(){
	getOther(document.getElementById("steps").value);
});

//getmethod.addEventListener("change", getOther(getmethod.value));

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



