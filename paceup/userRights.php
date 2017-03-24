<br><br><div class="container-fluid text-center">
<form class="form-signin" method="POST" action="./updateRights.php" id="user-rights">

<h2 class="form-signin-heading">Download study data</h2><hr />

<p id="errorMessage"></p>
        <div class="form-group" id="user_div">
        <span id="user_span"></span>         
 </div>
       <div class="form-group" id ="role_div">
       <select id="role" name="role" class="form-control">
       <option value='' disabled selected> Select role</option>
       <option value='U'> Participant</option>
       <option value='R'> Researcher</option>
       <option value='S'> Super User</option>
       </select> 
        
       <hr />
        <div class="form-group">
            <button type="button" class="btn btn-default" id="rightsBtn" onclick="updateUser()">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Edit Rights </button> </div></div>
 </form>
 </div>
 

 <script>

window.onload = getUser();
 
function getUser(){

	doXHR("./getUser.php", function () {
     var $response = this.responseText;
     console.log($response);
     document.getElementById("user_span").innerHTML=$response;
     });

}

function updateUser(){
	console.log("click");
	var form = document.getElementById("user-rights");
	var data = $(form).serialize();
	var action = form.getAttribute("action");
	console.log(data);
	doXHR(action, function(){
		var $response = this.responseText;
		document.getElementById('errorMessage').innerHTML = "<p>"+ $response + "</p>";
		}, data);
}

 </script>
 