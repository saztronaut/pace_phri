<?php include './template.php';?>

<div class="container-fluid text-center extra-pad">
<h2>Edit User </h2>
<form  class="form-inline" method="POST"  id="editUser">
<h2 class="form-inline-heading">Edit individuals</h2><hr />
<p> Here you can select a user, send a questionnaire, view the Steps pages as if you were that user, and update their email address</p>
<div class="form-group-inline" id="download_div">  
        
       <span id="practice_span"></span>
       <label class="checkbox-inline"><input type="checkbox" value="1" id='behind'>No steps for 7 days</label>
       <label class="checkbox-inline"><input type="checkbox" value="1" id='verybehind'>No steps for 28 days</label>
       <label class="checkbox-inline"><input type="checkbox" value="1" id='finished'>Finished 12 weeks</label>
       <label class="checkbox-inline"><input type="checkbox" value="1" id='not_finished'>Not finished 12 weeks</label>
       <label class="checkbox-inline"><input type="checkbox" value="1" id='has_quest'>Has filled in questionnaire</label>
       <label class="checkbox-inline"><input type="checkbox" value="1" id='no_quest'>Has not completed questionnaire</label></div>
       <div class="form-group-inline" id="user_div">
        <button type="button" class="btn btn-default" id="usersBtn" onclick="getUsers('select')">
      <span class="glyphicon glyphicon-refresh"></span> &nbsp; Update users list </button>                
      <button type="button" class="btn btn-default" id="downloadBtn" onclick="getUsers('download')">
      <span class="glyphicon glyphicon-download"></span> &nbsp; Download users list </button>        
        <span id="user_span"></span>
      <button type="button" class="btn btn-default" id="thisUserBtn" onclick="userInfo()">
      <span class="glyphicon glyphicon-hand-down"></span> &nbsp; Access selected user </button>   
       <hr /> <span id= "n_span"></span>
       <p id="UserInfo"></p>
        <div class="form-group-inline">
            <button type="button" class="btn btn-default" id="questBtn" onclick='sendQuest()'>
      <span class="glyphicon glyphicon-list-alt"></span> &nbsp; Send Questionnaire </button> 
            <button type="button" class="btn btn-default" id="apeBtn" onclick='apeUser()'>
      <span class="glyphicon glyphicon-eye-open"></span> &nbsp; View as User </button> </div></div>
      <br>
      <p id="response">
      <br>
      <p id="userDetails">
 </form>

</div>

<script src="download.js"></script>
<script>
// check user has permission first
// load up users as ddl

window.onload = getPractices();

function getPractices() {
    doXHR("./getPractice.php", function () {
        var $response = this.responseText;
        document.getElementById("practice_span").innerHTML = $response;
        getUsers("select");        
    });

}

function drawSelect(array) {	
    var select = "<select name='user' id='chooseUser' class='form-control''>";
    select += "<option value='' disabled selected> Select the user</option>";
    for (x in array) {
        select += "<option value='" + array[x][0] + "'> " + array[x][0] + " </option> ";
    }			
    select +=  "</select>";	
    return select;
}

function getUsers(action) {
    var data = "";
    var dataArray = [];
    if (document.getElementById("choosePractice")) {
        if (document.getElementById("choosePractice").value != null){
            dataArray.push("practice=" + document.getElementById("choosePractice").value);
            }
        if (document.getElementById("behind").checked && (document.getElementById("verybehind").checked === false)) {
            dataArray.push("behind=1");
            }
        if (document.getElementById("verybehind").checked) {
            dataArray.push("verybehind=1");
            }
        if (document.getElementById("finished").checked) {
            dataArray.push("finished=1");
            }
        if (document.getElementById("not_finished").checked) {
            dataArray.push("not_finished=1");
            }
        if (document.getElementById("has_quest").checked) {
            dataArray.push("has_quest=1");
            }
        if (document.getElementById("no_quest").checked) {
            dataArray.push("no_quest=1");
        }
    }
    data = dataArray.join("&");
    //console.log(data);
 
    doXHR("./getUser.php", function () {
        var $response = this.responseText;
        if ($response.startsWith("[")){
            
            if (action === "select"){ 
            	var myArray = JSON.parse($response);      
               var mySelect = drawSelect(myArray);
               document.getElementById("user_span").innerHTML = mySelect;
            }
            if (action === "download") {               
            	var myArray = JSON.parse($response);
                var addData = [];
                addData['data'] = myArray;
            	var mycsv = convertArrayToCSV(addData); //convert the array into CSV format
                downloadFile("usernames.csv", mycsv);
            }
            if (action === "emailQ") {
                //var    
            }
        }
    }, data);
}

function sendQuest(){
	var username = document.getElementById("chooseUser").value;
    data = "username=" + username;
    doXHR('./sendQuestionnaire.php', function() {
        //console.log(this.responseText);
        response = this.responseText;
        if (parseInt(response) === 0){
            document.getElementById('response').innerHTML = "Questionnaire could not be sent";
        } else if (parseInt(response) === 1) {
            document.getElementById('response').innerHTML = "Questionnaire sent to " + username;
        } else {            
            document.getElementById('response').innerHTML = "Questionnaire could not be sent";
        }                  
    }, data);
}

function apeUser(){
    data = "username=" + document.getElementById("chooseUser").value;
    doXHR('./apeUser.php', function() {  
        document.getElementById('response').innerHTML = this.responseText;
    }, data);
}


function userInfo(){
    var username = document.getElementById("chooseUser").value;
    data = "username=" + username;
    doXHR('get_my_data.php', function () {
        var $response = this.responseText;
       // console.log($response);
        if ($response=="0"){
            //redirect('./landing_text.php');
        } else {
            var jsonp = JSON.parse($response);
            var json = jsonp['userDetails'];
            var emails = jsonp['emails'];
            var lastSteps = jsonp['lastSteps'];
            var target = jsonp['target'];
            if (parseInt(json) === 0) {
            } else {//print data
                var print=[];
                print.push("<div class=\"row\"><div class=\"col-md-6\"> <h4>User Details</h4>");
                print.push("<div class=\"row\">");
                print.push("<div class=\"col-xs-4 text-right\"><b>First name:</b></div>");
                print.push("<div class=\"col-xs-4\"><span id='forename'> "+ json['forename']+ "</span></div>");
                print.push("<div class=\"col-xs-4\"><div class='form-group'>");
                print.push("<span id='forenameBtnEdit'><button type='button' class='btn btn-default' id='forenameBtn' onclick='edit(\"forename\", \""+json['forename']+"\", \""+ username +"\")'> Edit </button> </span></div></div></div>");
                print.push("<div class=\"row\">");
                print.push("<div class=\"col-xs-4 text-right\"><b>Last name: </b></div>");
                print.push("<div class=\"col-xs-4\"><span id ='lastname'>"+ json['lastname']+ "</span></div>");
                print.push("<div class=\"col-xs-4\"><div class='form-group'>");
                print.push("<span id='lastnameBtnEdit'><button type='button' class='btn btn-default' id='lastnameBtn' onclick='edit(\"lastname\", \""+json['lastname']+"\", \""+ username +"\")'> Edit </button> </span></div></div></div>");
                print.push("<div class=\"row\"><div class=\"col-xs-4 text-right\"><p><b>Email: </b></p></div>");
                print.push("<div class=\"col-xs-4\"><span id='email'>"+ json['email']+ "</span></div>");
                print.push("<div class=\"col-xs-4\"><div class='form-group'>");
                print.push("<span id='emailBtnEdit'><button type='button' class='btn btn-default' id='emailBtn' onclick='edit(\"email\", \""+json['email']+"\", \""+ username +"\")'> Edit </button></span> </div></div></div>");				
                print.push("<div class=\"row\"><div class=\"col-xs-4 text-right\"><p><b>Practice Name: </b></p></div><div class=\"col-xs-4\"><p>"+ json['practice_name']+ "</p></div><div class=\"col-xs-4\"></div></div>");
                print.push("<div class=\"row\"><div class=\"col-xs-4 text-right\"><p><b>Start date: </b></p></div><div class=\"col-xs-4\"><p>"+ json['start_date']+ "</p></div><div class=\"col-xs-4\"></div></div>");
                if (json['method_name'] === "Other") {
                    print.push("<div class=\"row\"><div class=\"col-md-2\"></div><div class=\"col-xs-4 text-right\"><p><b>Preferred step counter: </b></p></div><div class=\"col-xs-4\"><p> "+ json['other_method']+ "</p></div><div class=\"col-xs-4\"></div></div>");
                } else {
                    print.push("<div class=\"row\"><div class=\"col-xs-4 text-right\"><p><b>Preferred step counter: </b></p></div><div class=\"col-xs-4\"><p> "+ json['method_name']+ "</p></div><div class=\"col-xs-4\"></div></div>");						
                }
                print.push("<div class=\"row\"><div class=\"col-xs-4 text-right\"><p><b>Gender: </b></p></div><div class=\"col-xs-4\"><p id='gender'> "+ json['gender']+ "</p></div>");
                print.push("<div class=\"col-xs-4\"><div class='form-group'>");
                print.push("<span id='genderBtnEdit'><button type='button' class='btn btn-default' id='genderBtn' onclick='edit(\"gender\", \""+json['gender']+"\", \""+ username +"\")'> Edit </button></span> </div></div></div>");
                print.push("<div class=\"row\"><div class=\"col-xs-4 text-right\"><p><b>Ethnicity: </b></p></div><div class=\"col-xs-4\"><p id='ethnicity'> "+ json['ethnicity']+ "</p></div>");
                print.push("<div class=\"col-xs-4\"><div class='form-group'>");
                print.push("<span id='ethnicityBtnEdit'><button type='button' class='btn btn-default' id='ethnicityBtn' onclick='edit(\"ethnicity\", \""+json['ethnicity']+"\", \""+ username +"\")'> Edit </button></span> </div></div></div>");             
                print.push("<div class=\"row\"><div class=\"col-xs-4 text-right\"><p><b>Age: </b></p></div><div class=\"col-xs-4\"><p id='age'>"+ json['age']+ "</p></div>");
                print.push("<div class=\"col-xs-4\"><div class='form-group'>");
                print.push("<span id='ageBtnEdit'><button type='button' class='btn btn-default' id='ageBtn' onclick='edit(\"age\", \""+json['age']+"\", \""+ username +"\")'> Edit </button></span> </div></div></div>");
                print.push("</div><div class=\"col-xs-6\">");
                if (emails!=0){
                	 print.push("<h4> Emails</h4>");
                	 print.push("<div class=\"row\"><div class=\"col-xs-6 text-right\"> <p class=\"strong\"><b>Email purpose</b></p> </div>");
                	 print.push("<div class=\"col-xs-6 text-left\"> <p class=\"strong\"> <b>Date time sent</b></p> </div>");
                	 print.push("</div>");
                    for (x in emails) {
                        print.push("<div class=\"row\"><div class=\"col-xs-6 text-right\">"+ emails[x].purpose_name + "</div>");
                        print.push("<div class=\"col-xs-6 text-left\">"+ emails[x].time_sent + "</div>"); 
                        print.push("</div>");                      
                    }
                    
                }
                if (lastSteps!=0){
               	 print.push("<h4> Last Recorded Steps</h4>");
                   for (x in lastSteps) {
                       print.push("<div class=\"row\"><div class=\"col-xs-6 text-right\"><b>Day of Steps:</b></div> <div class=\"col-xs-6 text-left\">"+ lastSteps[x].date_read + "</div></div>");
                       print.push("<div class=\"row\"><div class=\"col-xs-6 text-right\"><p><b>Day of Recording:</b></div> <div class=\"col-xs-6 text-left\">"+ lastSteps[x].date_entered + "</div></div>"); 
                       print.push("<div class=\"row\"><div class=\"col-xs-6 text-right\"><p><b>Steps Recorded:</b></div> <div class=\"col-xs-6 text-left\">"+ lastSteps[x].steps + "</div></div>");            
                   }
                   
               }
                if (target!=0){
               	 print.push("<h4> Latest Target</h4>");
                   for (x in target) {
                       print.push("<div class=\"row\"><div class=\"col-xs-6 text-right\"><p><b>Days to reach target:</b> </div> <div class=\"col-xs-6 text-left\">"+ target[x].days + "</div></div>");
                       print.push("<div class=\"row\"><div class=\"col-xs-6 text-right\"><p><b>Steps to reach:</b></div> <div class=\"col-xs-6 text-left\">"+ target[x].steps + "</div></div>"); 
                       print.push("<div class=\"row\"><div class=\"col-xs-6 text-right\"><p><b>Date set:</b></div> <div class=\"col-xs-6 text-left\">"+ target[x].date_set + "</div></div>");                   
                   }
                   
               }
                print.push("</div></div>");
                getprint = print.join("");
                document.getElementById('UserInfo').innerHTML= getprint;
            }
        }
    }, data);
}

function edit(control, input, username){
    var editData = "";
    if (control === "age"){
        editData = "<form class = 'form-inline'> <div class='form-group'>";
        editData += "<label class='radio-inline'><input type='radio' value='40' name='" + control + "'>40-59 years</label>";
        editData += "<label class='radio-inline'><input type='radio' value='60' name='" + control + "'>60-74 years</label>"; 
        editData += "<label class='radio-inline'><input type='radio' value='75' name='" + control + "'>75+ years</label></div></form>"; 
    } else if (control === "gender") {
        editData = "<form class = 'form-inline'> <div class='form-group'>";
        editData += "<label class='radio-inline'><input type='radio' value='M' name='" + control + "'>Male</label>";
        editData += "<label class='radio-inline'><input type='radio' value='F' name='" + control + "'>Female</label>";
        editData += "</div></form>";
        //editDate += "<span id='"+ control +"BtnEdit'><button type='button' class='btn btn-default' id='ageBtn' onclick='update(\"age\", \""+ username +"\")'> Update </button></span>";                     
    } else if (control === "ethnicity") {
        editData += "<form class = 'form-inline'> <div class='form-group'>";
        editData += "<div class='radio'><label><input type='radio' value='W' name='ethnicity'> White</label> </div>";
        editData += "<div class='radio'><label><input type='radio' value='M' name='ethnicity'> Mixed/multiple ethnicities </label></div>";
     	editData += "<div class='radio'><label><input type='radio' value='A' name='ethnicity'> Asian/Asian British </label></div>";
        editData += "<div class='radio'><label><input type='radio' value='B' name='ethnicity'> Black/African/Caribbean/Black British </label></div>";
        editData += "<div class='radio'><label><input type='radio' value='O' name='ethnicity'> Other ethnic group </label></div></div>";
        editData += "</div></form>";
    } else {	
   var editData = "<form class = 'form-inline'> <div class='form-group'><input type='text' class='form-control' id='new"+ control +"' style='width: 12em' placeholder="+ input +"></input></div></form>";
        }
    document.getElementById(control).innerHTML= editData;
    document.getElementById(control+"BtnEdit").innerHTML= "<span id='"+ control +"BtnEdit'><button type='button' class='btn btn-default' id='"+ control +"Btn' onclick='update(\""+ control +"\", \""+ username +"\")'> Update </button></span>";      ;
}

function update(control, username){
	var data = "";
    if (control === "age" | control === "ethnicity" | control === "gender") { // get value from radio boxes
		  data = "username=" + username + "&control=" + control + "&input=" + $('input[name=' + control +']:checked').val();
        }
    else { //get value from input fields
		  data = "username=" + username + "&control=" + control + "&input=" + document.getElementById("new" + control).value;
		  //console.log(data);
    }
    doXHR("./updateUserDetails.php", function () {
       // console.log(this.responseText);
        }, data);
    
    
}
    
</script>