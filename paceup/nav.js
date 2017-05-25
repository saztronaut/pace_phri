window.onload=getlogin();

function redirect(gothere){
	console.log(gothere);
	  var dataString='choose_form=' + gothere;
	  console.log(dataString);
	  doXHR('./redirect.php', function () {	
		  window.location.reload(true);	 
	  }, dataString);  
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
			print.push("<li><a href='#' onclick='javascript:redirect(\"./register_form.php\")'>");
			print.push("<span class='glyphicon glyphicon-user'> </span> Sign Up </a></li>");
			print.push("<li><a href='#' onclick='javascript:redirect(\"./landing_text.php\")'>");
			print.push("<span class='glyphicon glyphicon-log-in'></span> Login </a></li>");
			}
		else {
			userdata=JSON.parse(response);
			if (userdata['role']=="R"||userdata['role']=="S"){
				print.push("<li><a href='#' onclick='javascript:redirect(");
				print.push('"./admin.php"');
				print.push(")'><span class='glyphicon glyphicon-pencil'></span> Admin </a></li>");
	            }
			print.push("<li><a href='#'><span class='glyphicon glyphicon-user'></span> Welcome " + userdata['username'] +" </a></li>");
			print.push("<li><a href='./logout.php'><span class='glyphicon glyphicon-log-in' id='logout'></span> Log out</a></li>");}
	        login=print.join("\n");
	        document.getElementById('login_bar').innerHTML= login;
	    	        });
		  }