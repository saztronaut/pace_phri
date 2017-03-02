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
         <option value='Reference'> Registration codes</option>
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
        <span id="user_span"></span>          </div>
        <span id= "n_span"></span>
        
        
       <hr />
        <div class="form-group">
            <button type="button" class="btn btn-default" id="downloadBtn">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Download </button> </div></div>
 </form>
 </div>
 
 <script>
 var download = document.getElementById("downloadBtn");
download.addEventListener("click", getDownload);

//var choosenarrow = document.getElementById("narrowby");
//download.addEventListener("focusout", getNarrow(choosenarrow.value));

function getDownload(){
	  // validate the form on the client side, double password match, etc
	  // remove special chars
	  var whichdata = document.getElementById("whichdata").value;  
	  var narrowby = document.getElementById("narrowby").value; 
	  data =  "whichdata=" + whichdata +"&narrowby="+ narrowby;
      url = './download.php';
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", url, true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.send(data);
	  xhr.onreadystatechange = function () {
	  if(xhr.readyState == 4 && xhr.status ==200){
	  var $response = xhr.responseText;
	  document.getElementById("n_span").innerHTML=$response;
	  }
	  };
	  
}

function getNarrow(){
	
	narrow= document.getElementById("narrowby").value;
	console.log(narrow);
switch (narrow){
case 'User' :
	if (document.getElementById('choosePractice')){
		data="practice="+document.getElementById('choosePractice').value;}
	else {data=""}
	var xhr = new XMLHttpRequest();
     xhr.open("POST", "./getUser.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhr.send(data);
xhr.onreadystatechange = function () {
if(xhr.readyState == 4 && xhr.status ==200){
var $response = xhr.responseText;
console.log($response);
document.getElementById("user_span").innerHTML=$response;
}
};
break;
case 'Practice' :
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "./getPractice.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send();
	xhr.onreadystatechange = function () {
	if(xhr.readyState == 4 && xhr.status ==200){
	var $response = xhr.responseText;

	document.getElementById("practice_span").innerHTML=$response;
	
	}};

}
}

 </script>
 