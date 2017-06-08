<?php include './template.php';?>

	<div class='jumbotron text-center'>
    <h1>PACE-UP</h1>
<p> Administrative tools for PACE-UP</p> </div>
<div class="container-fluid text-center extra-pad">

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
    console.log(data);
 
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
    data = "username=" + document.getElementById("chooseUser").value;
    doXHR('./sendQuestionnaire.php', function() {
        console.log(this.responseText);
    }, data);
}

function apeUser(){
    data = "username=" + document.getElementById("chooseUser").value;
    doXHR('./apeUser.php', function() {
        console.log(this.responseText);
    }, data);
}

function showUser(){
    data = "username=" + document.getElementById("chooseUser").value;
	
}
</script>