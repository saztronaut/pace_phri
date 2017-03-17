<!-- This is the navigation bar. It will appear at the top of every page and is called by main_index -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="images/puns_tiny.png"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="#">HOME</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">MY STEPS <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"  onclick='redirect("./steps2.php")'><span id="recordsteps">RECORD STEP COUNT</span></a></li>
            <li><a href="#" onclick='redirect("./stepHistory.php")'><span id="reviewsteps">REVIEW STEP HISTORY</span></a></li>
          </ul>
        </li>
   <li class="dropdown">
   <a class="dropdown-toggle" data-toggle="dropdown" href="#">TARGETS <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick='redirect("./explain_targets.php")'><span id="currenttarget">TARGETS EXPLAINED</span></a></li>
          </ul>
        </li>
         <li class="dropdown">
       <a class="dropdown-toggle" data-toggle="dropdown" href="#">MATERIALS<span class="caret"></span></a>
       <ul class="dropdown-menu">
             <li><a href="#" onclick='redirect("./links.php")'><span id="links">LINKS</span></a></li>
             <li><a href="#" onclick='redirect("./handbook.php")'><span id="handbook">HANDBOOK</span></a></li>
             <li><a href="#" onclick='redirect("./diary.php")'><span id="diary">DIARY</span></a></li>
            <li><a href="#" onclick='redirect("./information_sheet.php")'><span id="informationsht">INFORMATION SHEET</span></a></li>       
          </ul>
        </li>
       </ul>
      <ul class="nav navbar-nav navbar-right">
		<?php include './loggedon.php';?>
	  <!--  check to see if logged in - if so then offer log out if not then offer sign up login -->
		</ul>
    </div>
  </div>
</nav>
<script>

function redirect(gothere){
	console.log(gothere);
	  var dataString='choose_form=' + gothere;
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", './redirect.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.onreadystatechange = function () {	  
	  if(xhr.readyState == 4 && xhr.status ==200){	
		  window.location.reload(true);	 
	  }
	  }
	  xhr.send(dataString);  
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
	  xhr.send(data);
	}
</script>