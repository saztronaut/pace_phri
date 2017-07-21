<?php include './template.php';?>
<br><br><div class="container-fluid text-center">

<form class="form-signin" method="POST" action="./download.php" id="download">

<h2 class="form-signin-heading">Download study data</h2><hr />

<p id="errorMessage"></p>
<div class="form-group" id="download_div">
        <div class="form-group" id="n_div">
        <select name='n_codes' id='whichdata' class='form-control' >
	     <option value='' disabled selected> Which file do you want to download?</option>
         <option value='Users'> Users</option> 
         <option value='Steps'> Steps</option> 		
         <option value='Practices'> Practices</option> 
         <option value='Targets'> Targets</option> 
         <option value='Methods'> Methods</option>
         <option value='Reference'> Registration codes and consent data</option>
         <option value='Questionnaire'> Questionnaires </option>
         <option value='Emails'> Sent Emails </option>
        </select>        
        </div>
        <div class="form-group" id="narrow_div">
        <select name='n_codes' id='narrowby' class='form-control' onfocusout="getNarrow()" >
	     <option value='Showall' selected> Show all</option>
         <option value='User'> Narrow by user</option> 	
         <option value='Practice'> Narrow by practice</option> 
        </select>  </div>   
        <div class="form-group" id="practice_div">
        <span id="practice_span"></span></div>
               <div class="form-group" id="user_div">
        <span id="user_span"></span>         
 </div>
        <span id= "n_span"></span>
        
        
       <hr />
        <div class="form-group">
            <button type="button" class="btn btn-default" id="downloadBtn">
      <span class="glyphicon glyphicon-download"></span> &nbsp; Download </button> </div></div>
 </form>
 </div>
 <?php include './footer.php';?>
 <script src='download.js'></script>
 <script>
var download = document.getElementById("downloadBtn");
download.addEventListener("click", getDownload);

//var choosenarrow = document.getElementById("narrowby");
//download.addEventListener("focusout", getNarrow(choosenarrow.value));

window.onload = checkPrivilege('R');

function checkPrivilege(min_account) {
    ///check to see if user has sufficient privileges for page
    data = "min_account="+min_account;
    doXHR('./checkRights.php', function(){
        var response=this.responseText;
        if (response === "0"){
            window.location.assign('./landing_text.php');
        }
    return response;
    }, data);

}

function getDownload(){
	  // validate the form on the client side, double password match, etc
	  // remove special chars
	  var whichdata = document.getElementById("whichdata").value;  
	  var narrowby = document.getElementById("narrowby").value; 
	  data =  "whichdata=" + whichdata +"&narrowby="+ narrowby;	  
	  if (narrowby=="User" ||narrowby=="Practice"){
          var narrow=document.getElementById('choose'+narrowby).value;
          data+= "&"+narrowby+"="+narrow;
		  }
	  //console.log(data);
      var url = './download.php';
      var d=new Date();
      var today = d.getDate() +"_"+ (d.getMonth()+1) +"_"+  d.getFullYear();
      var filename=whichdata+today+".csv";
      //console.log(filename);
      //console.log(data);
      createDownload(filename, url, data);
	  
}

function getNarrow(){
	
	narrow= document.getElementById("narrowby").value;
	//console.log(narrow);
    switch (narrow){
    case 'User' :
	    if (document.getElementById('choosePractice')) {
		    data="practice="+document.getElementById('choosePractice').value;
    	} else {
            data="";
        }
	doXHR("./getUser.php", function () {
        var $response = this.responseText;
            if ($response.startsWith("[")){
                var myArray = JSON.parse($response);
                var mySelect = drawSelect(myArray);
                document.getElementById("user_span").innerHTML = mySelect;
                document.getElementById("practice_span").innerHTML = "";
            }
        },data);
        break;
    case 'Practice' :
	    doXHR("./getPractice.php", function () {
	        var $response = this.responseText;
	        document.getElementById("practice_span").innerHTML=$response;
            document.getElementById("user_span").innerHTML = "";
	     }, 0);
    }
}


function drawSelect(array) {	
    var select = "<select name='user' id='chooseUser' class='form-control'>";
    select += "<option value='' disabled selected> Select the user</option>";
    for (x in array) {
        select += "<option value='" + array[x][0] + "'> " + array[x][0] + " </option> ";
    }			
    select +=  "</select>";	
    return select;
}


 </script>
 