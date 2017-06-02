<!-- This is the navigation bar. It will appear at the top of every page and is called by main_index -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> MENU </button>    
      <a class="navbar-brand" href="./main_index.html"><img src="images/puns_tiny.png" class="img-responsive"></a>
    <span class="sr-only">Toggle navigation</span>
    </div>

    <div class="collapse navbar-collapse" id="myNavbar">
    
      <ul class="nav navbar-nav">
        <li><a href="./AddNewTarget.php">HOME</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">MY STEPS <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="./steps2.php"><span id="recordsteps">RECORD STEP COUNT</span></a></li>
            <li><a href="./stepHistory.php"><span id="reviewsteps">REVIEW STEP HISTORY</span></a></li>
          </ul>
        </li>
   <li class="dropdown">
   <a class="dropdown-toggle" data-toggle="dropdown" href="#">TARGETS <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="./explain_targets.php"><span id="currenttarget">TARGETS EXPLAINED</span></a></li>
          </ul>
        </li>
         <li class="dropdown">
       <a class="dropdown-toggle" data-toggle="dropdown" href="#">MATERIALS<span class="caret"></span></a>
       <ul class="dropdown-menu">
             <li><a href="./links.php"><span id="links">LINKS</span></a></li>
             <li><a href="./handbook.php"><span id="handbook">HANDBOOK</span></a></li>
             <li><a href="./diary.php"><span id="diary">DIARY</span></a></li>
            <li><a href="./information_sheet.php"><span id="informationsht">INFORMATION SHEET</span></a></li>       
          </ul>
        </li>
       </ul>
      <ul class="nav navbar-nav navbar-right" id="login_bar">
	  <!--  check to see if logged in - if so then offer log out if not then offer sign up login -->
		</ul>
    </div>
  </div>
</nav>
<script>
window.onload=getlogin();

function redirect(gothere){
	  window.location.assign(gothere);	 
	}
	


function doXHR(url, callback, data=null){
	  var xhr = new XMLHttpRequest();
	  xhr.open ("POST", url, true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  
	  xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4	&& xhr.status ==200) {
	      // defensive check

	      if (typeof callback == "function") {
	        // apply() sets the meaning of "this" in the callback
	        console.log("callback "+xhr.responseText);
	        callback.apply(xhr);
	      }
	    }
	  }
	  // send the request *after* the event handler is defined 
	  if (data!=null){
		  xhr.send(data);}
	  else {
	  xhr.send();}
	}

function getlogin(){
	
	doXHR('./loggedon.php', function(){
		response= this.responseText;
		console.log(response);
		print=[];
		if (response==0){
			print.push("<li><a href='./register_form.php'>");
			print.push("<span class='glyphicon glyphicon-user'> </span> Sign Up </a></li>");
			print.push("<li><a href='./landing_text.php'>");
			print.push("<span class='glyphicon glyphicon-log-in'></span> Login </a></li>");
			}
		else {
			userdata=JSON.parse(response);
			if (userdata['role']=="R"||userdata['role']=="S"){
				print.push("<li><a href='./admin.php'><span class='glyphicon glyphicon-pencil'></span> Admin </a></li>");
	            }
			print.push("<li><a href='#'><span class='glyphicon glyphicon-user'></span> Welcome " + userdata['username'] +" </a></li>");
			print.push("<li><a href='#' onclick='logout()'><span class='glyphicon glyphicon-log-in' id='logout'></span> Log out</a></li>");}
	        login=print.join("\n");
	        document.getElementById('login_bar').innerHTML= login;
	    	        });
		  }

function logout(){
	doXHR('./logout.php', function(){
		window.location.assign('./landing_text.php');
	},)
	
}
</script>