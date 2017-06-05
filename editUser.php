<?php include './template.php';?>

	<div class='jumbotron text-center'>
    <h1>PACE-UP</h1>
<p> Administrative tools for PACE-UP</p> </div>
<div class="container-fluid text-center extra-pad">

<form  class="form-inline" method="POST"  id="edit">
<h2 class="form-inline-heading">Edit individuals</h2><hr />
<div class="form-group-inline" id="download_div">  
        <div class="form-group-inline" id="practice_div">
        
        <span id="practice_span"></span></div>
               <div class="form-group-inline" id="user_div">
        <button type="button" class="btn btn-default" id="usersBtn" onclick=getUsers()>
      <span class="glyphicon glyphicon-refresh"></span> &nbsp; Update users list </button>       
        <span id="user_span"></span>         
 </div>
        <span id= "n_span"></span>
        
        
       <hr />
        <div class="form-group-inline">
            <button type="button" class="btn btn-default" id="questBtn" onclick='sendQuest()'>
      <span class="glyphicon glyphicon-list-alt"></span> &nbsp; Send Questionnaire </button> </div></div>
 </form>

</div>

<script>
// check user has permission first
// load up users as ddl

window.onload = getPractices();

function getPractices(){
doXHR("./getPractice.php", function () {
	var $response = this.responseText;
	document.getElementById("practice_span").innerHTML=$response;
	});
	getUsers();

}
function getUsers(){
	if (document.getElementById('choosePractice')){
		data="practice="+document.getElementById('choosePractice').value;}
	else {data=""}
	doXHR("./getUser.php", function () {
var $response = this.responseText;

document.getElementById("user_span").innerHTML=$response;
},data);
	
}
function sendQuest(){
    data="username="+ document.getElementById("chooseUser").value;
	doXHR('./sendQuestionnaire.php', function(){
console.log(this.responseText);
		}, data);
}



</script>