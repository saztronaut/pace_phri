<!-- This is the navigation bar. It will appear at the top of every page and is called by main_index -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">PACE-UP</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">HOME</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">MY STEPS <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><span id="recordsteps">RECORD STEP COUNT</span></a></li>
            <li><a href="#"><span id="reviewsteps">REVIEW STEP HISTORY</span></a></li>
          </ul>
        </li>
   <li class="dropdown">
   <a class="dropdown-toggle" data-toggle="dropdown" href="#">MY TARGETS <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><span id="currenttarget">CURRENT TARGET</span></a></li>
            <li><a href="#"><span id="prevtarget">PREVIOUS TARGETS</span></a></li>
          </ul>
        </li>
        <li><a href="#"><span id="materials">MATERIALS</span></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<?php include './loggedon.php';?>
	  <!--  check to see if logged in - if so then offer log out if not then offer sign up login -->
		</ul>
    </div>
  </div>
</nav>
<script>

var recordsteps = document.getElementById("recordsteps");
recordsteps.addEventListener("click", redirect("steps.php"));

function redirect(gothere){
	  var dataString='choose_form=' + gothere;
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", './redirect.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.onreadystatechange = function () {	  
	  if(xhr.readyState == 4 && xhr.status ==200){		 
	  }
	  }
	  xhr.send(dataString);  
	}
	
</script>