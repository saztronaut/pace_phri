<!-- -->
<br><div class= "container">
<div class= "jumbotron">
<span id="thisHeader">Introduction to the week here</span>
<span id="thisBlurb">Explanation of the week here</span>
</div></div>
<div class="container-fluid-extrapad"> <div class = "row">
<div class = "col-md-7"> <h3>You can record your step counts here.</h3> <span id="thisTable">Your steps should appear here</span> </div>
<div class = "col-md-5"> <p id="thisAside"><span id="thisTable">Message to motivate you should appear here</span> </p></div>
</div></div>
<!-- Modal -->
<div id="methodModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Changing step methods</h4>
      </div>
      <div class="modal-body">
        <p id="method_message">
	</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script src="./drawHeader.js"></script>
  <script> 
  window.onload = function() {
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", 'getWeek.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  var weekdata= [];
	  xhr.onreadystatechange = function () {	  
	  if(xhr.readyState == 4 && xhr.status ==200){		 
		  var $response = xhr.responseText;	  
	      console.log($response);
	      if ($response=="0"){
		      redirect('./landing_text.php');
		      }
	      else {
	         var json = JSON.parse($response, function(key, value) {
	        	  if (key!="fail"){
		  
	        	    	weekdata[key]=value;
	        	  }
	        	  else if (key=="fail"){
	        	    	console.log("could not get week");	
	        	    	weekdata['week']="unknown";  
	        	  }
	        	  
	          });
	          	if (weekdata['week']=='baseline'){
		       weekdata['weekno']=0;}
			if (weekdata['refresh']=='yes'){
			window.location.reload(true);
			}

          var header = drawHeader2(weekdata['week'], weekdata['weekno'], weekdata['comment']);
          //console.log(header);
          document.getElementById("thisHeader").innerHTML= header['thisHeader'];
          document.getElementById("thisAside").innerHTML= header['thisAside'];
          document.getElementById("thisBlurb").innerHTML= header['blurb'];
          
      	  var xhr2 = new XMLHttpRequest();
      	  ///create a string to parse to build the able
      	  myString="week=" + weekdata['week'];
      	  myString+="&weekno=" + weekdata['weekno'];
      	  myString+="&steps=" + weekdata['steps'];     	  
      	  myString+="&latest_t=" + weekdata['latest_t'];
      	  myString+="&days=" + weekdata['days'];
      	  myString+="&base=" + weekdata['baseline'];
      	  
       	  xhr2.open("POST", 'drawTable.php', true);
    	  xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	  xhr2.onreadystatechange = function () {	  
    	  if(xhr2.readyState == 4 && xhr2.status ==200){		 
    		  var $drawTable = xhr2.responseText;	  
    	      if ($drawTable==0){
        	      }
    	      else{
    	    	  document.getElementById("thisTable").innerHTML= $drawTable;
        	      }
              }
          }
    	  xhr2.send(myString);
	  }
	  }
	  }
	   xhr.send();  
	}
	
  $(window).click(function(event) {
	  var i_name= String(event.target.id);
	  //If a date has been set for a new target then add this
	   if (i_name.startsWith('onemonth')){
            updateTarget();
			}
		// Save a new step count
	   else if(i_name.startsWith('saveBtn')){
		   updateSteps(i_name, false);
		}
		// Edit a step count
	   else if(i_name.startsWith('editBtn')){
		   if (document.getElementById(i_name).value=="Edit"){
		   editSteps(i_name);}
		   else{updateSteps(i_name, true);}
		}
	   else if(i_name.startsWith('method')){
		   getMethods(i_name);
		}
	   else if(i_name.startsWith('viewPast')){		   
		   viewPast(document.getElementById('viewSteps').value);
		}
	   else if(i_name.startsWith('walk') || i_name.startsWith('newwalk')){		   
       console.log(i_name);
       console.log(document.getElementById(i_name).value);
		   //if (document.getElementById(i_name).value=='on'){
			//   document.getElementById(i_name).value='0';}
			 //  else { document.getElementById(i_name).value='on';}
		}
	   });
  $(window).focusout(function(event) {
	  var i_name= String(event.target.id);
	  //If a date has been set for a new target then add this
        if(i_name.startsWith('method')){
		   updateMethods(i_name);
		}
	   });
//  window.onfocusout = function(event) {
//	  var i_name= String(event.target.id);
//	  input = document.getElementById(i_name).value;
//	   if (i_name.startsWith('steps') && input!=""){
//            updateSteps(input, i_name);
//			}
//		   }
  
 
  function updateSteps(controlname, edit){
	  //Potential answers are to not show dates in the future as this would reset the date?
	  console.log(controlname);
	  var date_set = new Date();
	  // get number from string, which is the number from the current date
	  var nudge = controlname.slice(-(controlname.length-7));
	  // get steps
	  if (edit==true){
		  var inputname= "newsteps"+ nudge;
		  var walk_ck= 'newwalk'+nudge;
	  }
	  else{
	    var inputname= "steps"+ nudge;
		var walk_ck= 'walk'+nudge;
	    }
	  var method= 'method'+nudge;	  
	  console.log(inputname);
	  input = document.getElementById(inputname).value;	  
	  console.log(input);
      date_set = nudge;	
	  methodID = document.getElementById(method).value; 
	      //find out if there is a walk check box
      var walk_yn= '';
      if (document.getElementById(walk_ck)){
          walk_yn=document.getElementById(walk_ck).checked;
          console.log("Echo walk value" +walk_yn);
          }  
	  //use input, date set and series data to update the step values and store in the database
	  data= "date_set=" + date_set + "&steps=" + input + "&walk=" + walk_yn + "&method="+methodID;
	  console.log(data);
	  var xhrUS = new XMLHttpRequest();
	  xhrUS.open("POST", './updateSteps.php', true);
	  xhrUS.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhrUS.onreadystatechange = function () {
	  	  if (xhrUS.readyState == 4 && xhrUS.status ==200){
		  var $response = xhrUS.responseText;	  
	     window.location.reload(true);
	  }	  
	  	else{
			  console.log("readyState: ", xhrUS.readyState);
			  console.log("status: ", xhrUS.status);
			  console.log("statustext: ", xhrUS.statusText); } 	
		 
	  }
      xhrUS.send(data);//}
  }

  function recordComment(weekno){
	  comment= JSON.stringify(document.getElementById('comment'+weekno).value);
	  if (comment!=''){
	  data="weekno="+ weekno +"&comment=" + comment;
	  console.log(data);
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", 'addComment.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.send(data);	
	  xhr.onreadystatechange=function(){
	  if(xhr.readyState == 4 && xhr.status ==200){
		  var $response = xhr.responseText;
		  console.log($response);
		  if ($response==1){
		  document.getElementById('form'+weekno).className= "form-group has-success";	
		  
	  }	   else {
	  document.getElementById('form'+weekno).className= "form-group";	}
	  }
	  }
	  }
  }
  
  
  function editSteps(controlname){
	  console.log(controlname);
	  //When looking at data AFTER baseline, this function doesn't work. You want to nudge from the latest target +6, which may or may not be the current date. 
	  //Potential answers are to not show dates in the future as this would reset the date?
	  // get number from string, which is the number from the current date
	  var nudge = controlname.slice(-(controlname.length-7))
	  // get steps
	  inputname= "steps"+ nudge;
	  console.log(inputname);
	  //change the steps span id into a control box
	  input = document.getElementById(inputname).textContent;	
	  str= "<form class = 'form-inline'> <div class='form-group'><input type='integer' class='form-control' id='new"+ inputname +"' style='width: 7em'/></div></form>"; 
      console.log(str);
      document.getElementById(inputname).innerHTML = str
	  //change the walk span id into a control box
	  var walk_ck= 'walk'+nudge;
      if (document.getElementById(walk_ck)){
    	  if (document.getElementById(walk_ck).textContent!=""){
          chkstr= "<form class = 'form-inline'> <div class='form-group'> <input type='checkbox' class='form-control' id='new"+ walk_ck +"' checked='on'/> </div></form>";
          }
          else {
          chkstr= "<form class ='form-inline'><div class='form-group'> <input type='checkbox' class='form-control' id='new"+ walk_ck +"'/> </div></form>";}
          document.getElementById(walk_ck).innerHTML=chkstr;
          }  
	  //change the label of the button to "Save"	  
	  var method_ck = 'method'+nudge;
	  document.getElementById(controlname).value = "Update";
	  //
  }
  
  function updateTarget(){
	  input = document.getElementById('setTarget');
	  thisdate = input.options[input.selectedIndex].value;
	  data="date_set=" + thisdate;
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", 'updateTarget.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.send(data);	
	  xhr.onreadystatechange=function(){
	  if(xhr.readyState == 4 && xhr.status ==200){
		  window.location.reload(true);
	  }	   
	  }
  }
  
  function incTarget(newtarget){
	  data="date_set=" + newtarget;
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", 'updateTarget.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.send(data);	
	  xhr.onreadystatechange=function(){
	  if(xhr.readyState == 4 && xhr.status ==200){
		  window.location.reload(true);
	  }	   
	  }
  }
   
  function getMethods(input){
	  var nudge = input.slice(-(input.length-6));
	  var editname="editBtn"+nudge;
	  if (document.getElementById(editname)){
		  if (document.getElementById(editname).value=="Edit"){
			  document.getElementById('method_message').innerHTML= "If you want to update the method used to collect your step count, click 'Edit'";
			  $('#methodModal').modal('show');
                	
			  }
	  }
	  }
  
  function updateMethods(input){
	  var nudge = input.slice(-(input.length-6));
	  document.getElementById('method_message').innerHTML= "Using different devices to collect your steps data can give readings that differ. It is best to stick to the same device";
	  var editname="editBtn"+nudge;
	  if (document.getElementById(editname)){
		  if (document.getElementById(editname).value=="Edit"){}else{
        $('#methodModal').modal('show');}}
		  else{
		        $('#methodModal').modal('show');}
	  }
  
  function viewPast(viewWeek){
	  //This allows users to view a week that is not current. 
	  //Argument called by viewStepsBtn. view Week is an integer representing number of weeks since baseline, 0 indexed
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", 'viewSteps.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  var weekdata= [];
	  xhr.onreadystatechange = function () {	  
	  if(xhr.readyState == 4 && xhr.status ==200){		 
		  var $response = xhr.responseText;	  
	      if ($response==0){}
	      else{
	         var json = JSON.parse($response, function(key, value) {
	        	  if (key!="fail"){
		        	  //console.log(key);
	        	    	weekdata[key]=value;
	        	  }
	        	  else if (key=="fail"){
	        	    	//console.log("could not get week");	
	        	    	weekdata['week']="unknown";  
	        	  }      	  
	          });
			
          var header= drawHeader2("week"+viewWeek, viewWeek, weekdata['comment']);
          document.getElementById("thisHeader").innerHTML= header['thisHeader'];
          document.getElementById("thisAside").innerHTML= header['thisAside'];
          document.getElementById("thisBlurb").innerHTML= header['blurb'];
          
      	  var xhr2 = new XMLHttpRequest();
      	  ///create a string to parse to build the table
      	  myString="week=week" + viewWeek;
      	  myString+="&weekno=" + viewWeek;
      	  myString+="&steps=" + weekdata['steps'];     	  
      	  myString+="&latest_t=" + weekdata['latest_t'];
      	  myString+="&days=" + weekdata['days'];
      	  myString+="&base=" + weekdata['baseline'];
      	  myString+="&finish=" + weekdata['finish'];
      	  console.log(myString);
       	  xhr2.open("POST", 'drawTable.php', true);
    	  xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	  xhr2.onreadystatechange = function () {	  
    	  if(xhr2.readyState == 4 && xhr2.status ==200){		 
    		  var $drawTable = xhr2.responseText;	  
    	      if ($response==0){}
    	      else{
    	    	  document.getElementById("thisTable").innerHTML= $drawTable;
        	      }
              }
          }
    	  xhr2.send(myString);
	  }
	  }
	  }
	   xhr.send("weekno="+ viewWeek);  
	  }
  
  </script>