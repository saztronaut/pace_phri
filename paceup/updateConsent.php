<?php include './template.php';?>
<br><br><div class="container-fluid text-center">
<form class="form-inline" method="POST" action="./userConsent.php" id="user-consent">

<h2 class="form-signin-heading">Update consent data</h2><hr />

<p id="errorMessage"></p>
        <div class="form-group" id="practice_div">
        <span id="practice_span"></span></div>
        <div class="form-group" id="consent_div">
        <select id="has_consent" name="has_consent" class="form-control">
       <option value='' disabled selected> Select which users you want to see</option>
       <option value='NPC'> Has no postal consent</option>
       <option value='NOA'> Has no online account</option>
       <option value='HPC'> Has postal consent</option>
       <option value='HOA'> Has online account</option>
       <option value='ALL'> All users</option>
       </select> </div>
        <div class="form-group">
        <button type="button" class="btn btn-default" id="pracBtn" onclick="getRef()">
      <span class="glyphicon glyphicon-search"></span> &nbsp; Show Registration codes </button> </div>   <br> <br>     
        <div class="form-group" id="reg_btn">
        <span id="user_span">Registration list will appear here</span>         
 </div>

        <div class="form-group">
            <button type="button" class="btn btn-default" id="rightsBtn" onclick="getConsentData()">
      <span class="glyphicon glyphicon-pencil"></span> &nbsp; Show data </button> </div>
 </form>
 </div><br>
 <span id="participant-consent"></span>
<?php include './footer.php';?>
 <script>

window.onload = getPractice();


function getPractice(){
	doXHR("./getPractice.php", function (){
	var $response = this.responseText;
	document.getElementById("practice_span").innerHTML=$response;
	});
}

function getConsentData(){
	var data = "reg="+document.getElementById("reference").value;
	doXHR("./getConsentData.php", function(){
		var $response = this.responseText;
	  	  if ($response.startsWith('{"data":')) {
		  	  var consentData=[];
	    	  var json = JSON.parse($response, function(key, value) {
	    		  consentData[key]=value; // all week info to go in consentData array
	    		  });
	    		  var myconsent= drawConsent(consentData);
	    		  var consentPrint=myconsent.join("\n");
	    		  document.getElementById('participant-consent').innerHTML= consentPrint;
	    	  }
	  	  else // no data coming from the query 
		  	  { document.getElementById('errorMessage').innerHTML = "<p>"+ $response + "</p>";}
		}, data);
}

function updateConsent(){
	 //var form= document.getElementById("consent_data");
	 var formdata = ""
	 var formvalues= ['e_consent', 'e_consent_a', 'e_consent_v', 'e_consent_t', 'e_consent_gp']
	 for (i in formvalues){
		 formdata+=formvalues[i]+"=";
		 formdata+=document.getElementById(formvalues[i]).checked;
		 formdata+="&";
		 }
	 var formvalues2 = ['age', 'gender', 'ethnicity']
	 for (i in formvalues2){
		 formdata+=formvalues2[i]+"=";
		 formdata+= $('input[name='+formvalues2[i]+']:checked').val();
		 formdata+="&";
	 }
	 var data = formdata+"&reg="+document.getElementById("reference").value;
	doXHR("./updateConsentData.php", function(){
		document.getElementById('feedback').innerHTML = "<p>"+ this.responseText +"</p>";
		}, data);
	
}


function getRef(){
	document.getElementById('participant-consent').innerHTML= "";
	var practice = document.getElementById('choosePractice').value;
	var consent = document.getElementById('has_consent').value;
	if (practice==null){
		data="";}
	else {data="practice="+ practice;}
	if (consent==null){
		}
	else{
       if (data!=""){
           data+="&"}
       data+="consent="+consent;
		}
	doXHR("./getReference.php", function () {
     var $response = this.responseText;
     document.getElementById("user_span").innerHTML=$response;
     print ='<div class="form-group"><button type="button" class="btn btn-default" id="pracBtn" onclick="getConsent()"><span class="glyphicon glyphicon-log-in"></span> &nbsp; Consent data </button> </div> ';
     }, data);

}

function drawConsent(consent_data){
	
     getconsenttxt=[];
	 //my participation is voluntary
	 getconsenttxt.push("<form id='consent_data'>");
	 if (consent_data['e_consent']==1){
		 var print="checked='on'";} else { print="";}
	 getconsenttxt.push( '<div class="row">  <div class="col-sm-1"></div><div class="col-sm-9"> <p>I have read and understood the Patient Information Sheet for PACE-UP Next Steps. I have had the opportunity to consider the information </p></div>');
     getconsenttxt.push( "<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' name='e_consent' id='e_consent' " +print  +"><br></div></div></div>");
	 if (consent_data['e_consent_v']==1){
		 var print="checked='on'";} else { print="";}
	 getconsenttxt.push( "<div class='row'>  <div class='col-sm-1'></div><div class='col-sm-9'><p>I understand that my participation is voluntary and that I am free to withdraw at any time, without giving any reason, without my medical care or legal rights being affected</p></div>");
	 getconsenttxt.push( "<div class='col-md-2'> <div class='checkbox'> <input type='checkbox' value='1' name='e_consent_v' id='e_consent_v'" +print  +"><br></div></div></div>");
	 //agree to participate
	 	 if (consent_data['e_consent_a']==1){
		 var print="checked='on'";} else { print="";}
	 getconsenttxt.push( "<div class='row'>  <div class='col-sm-1'></div><div class='col-sm-9'><p>I agree to take part in PACE-UP Next Steps</p></div>");
	 getconsenttxt.push( "<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' name='e_consent_a' id='e_consent_a' " +print  +"><br></div></div></div>");
	 //GP records
	 	 	 if (consent_data['e_consent_gp']==1){
		 var print="checked='on'";} else { print="";}
	 getconsenttxt.push( "<div class='row'>  <div class='col-sm-1'></div><div class='col-sm-9'><p>I give permission for my GP records to be looked at by responsible individuals from St Georges, University of London </p></div>");
	 getconsenttxt.push( "<div class='col-md-2'><div class='checkbox' ><input type='checkbox' value='1' name='e_consent_gp' id='e_consent_gp' " +print  +"><br></div></div></div>");
	 //agree to contact
	 	 if (consent_data['e_consent_t']==1){
		 var print="checked='on'";} else { print="";}
	 getconsenttxt.push( "<div class='row'>  <div class='col-sm-1'></div><div class='col-sm-9'><p>I agree to being contacted for a short telephone interview about my physical activity and taking part in this study, if I am selected for this </p></div>");
	getconsenttxt.push( "<div class='col-md-2'><div class='checkbox'><input type='checkbox' value='1' name='e_consent_t' id='e_consent_t' " +print  +"><br></div></div></div>");
	getconsenttxt.push( "<div class='row'> <div class='col-md-1'></div> <div class='col-md-3'><strong> Gender </strong>");
	 if (consent_data['gender']=='F'){
	var print="checked='on'"; }else { print="";}
	getconsenttxt.push( " <div class='radio'><label><input type='radio' value='F' name='gender' " +print  +"> Female</label></div>");
	if (consent_data['gender']=='M'){
			 var print="checked='on'";} else { print="";}
	getconsenttxt.push( " <div class='radio'><label><input type='radio' value='M' name='gender' " +print  +"> Male</label></div></div>");
	getconsenttxt.push( "<div class='col-md-4'><strong> Ethnicity </strong>");
	if (consent_data['ethnicity']=='W'){
		 var print="checked='on'"; }else { print="";}
	getconsenttxt.push( "<div class='radio'><label><input type='radio' value='W' name='ethnicity' " +print  +"> White</label></div>");
	if (consent_data['ethnicity']=='M'){
		 var print="checked='on'";} else { print="";}
   getconsenttxt.push("<div class='radio'><label><input type='radio' value='M' name='ethnicity' " +print  +"> Mixed/multiple ethnicities</label></div>");
	if (consent_data['ethnicity']=='A'){
		 var print="checked='on'"; }else { print="";}
   getconsenttxt.push( "<div class='radio'><label><input type='radio' value='A' name='ethnicity' " +print  +"> Asian/Asian British</label></div>");
	if (consent_data['ethnicity']=='B'){
		 var print="checked='on'"; }else { print="";}
	getconsenttxt.push( "<div class='radio'><label><input type='radio' value='B' name='ethnicity' " +print  +"> Black/African/Caribbean/Black British</label></div>");
	if (consent_data['ethnicity']=='O'){
		 var print="checked='on'";} else { print="";}
	getconsenttxt.push( "<div class='radio'><label><input type='radio' value='O' name='ethnicity' " +print  +"> Other ethnic group</label></div></div>");
	getconsenttxt.push( "<div class='col-md-4'><strong> Age </strong>");
	if (consent_data['age']=='40'){
		 var print="checked='on'";} else { print="";}
	getconsenttxt.push( "<div class='radio'><label><input type='radio' value='40' name='age' " +print  +"> 40-59 years</label></div>");
	if (consent_data['age']=='60'){
		 var print="checked='on'"; }else { print="";}
	getconsenttxt.push( "<div class='radio'><label><input type='radio' value='60' name='age' " +print  +"> 60-74 years </label></div>");
	if (consent_data['age']=='75'){
		 var print="checked='on'";} else { print="";}
	getconsenttxt.push( "<div class='radio'><label><input type='radio' value='75' name='age' " +print  +"> 75 years and older</label></div></div></div>");
	getconsenttxt.push("<div class='row'><div class='col-md-2'></div>");
	getconsenttxt.push("<div class='col-md-10'><div class='form-group'><button type='button' class='btn btn-default' id='consBtn' onclick='updateConsent()'><span class='glyphicon glyphicon-pencil'></span> &nbsp; Update consent data </button> </div>")
	getconsenttxt.push("<span id='feedback'></span> </div></div> ");
	 getconsenttxt.push("</form>");	
	return getconsenttxt;
}
</script>