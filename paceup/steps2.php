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
        <h4 class="modal-title" id="getModalHeader"></h4>
      </div>
      <div class="modal-body">
        <p id="method_message"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script src="./drawHeader.js"></script>
<script src="./drawMethodsSelect.js"></script>
<script src="./drawStepsTable.js"></script>
<script src="./dateFunctions.js"></script>
<script src="./twelveWeekSummary.js"></script>
  <script> 
  window.onload = showWeek(false);

 function showWeek(past=false, viewWeek=null){
	 // default show current week. past true/false indicates viewing a week which is not the current week. 
	 // view Week is the week to display (if past)
	 doXHR("./getMethods.php", function getThisArray(){
		  var methods = JSON.parse(this.responseText); //methods just contains the potential methods that the user could draw from
		  var weekdata= [];   //data about the current week (week name, week num, target steps, target days, comments for that week, current week num)
		   
	     doXHR("./getWeek.php", function getWeek(){	  	 
		   var $response = this.responseText;	
		   console.log($response);  
		      if ($response=="0"){
			      redirect('./landing_text.php'); //if you couldn't get any data on the individual, send them to the landing page
			      }
		      else {
		        var json = JSON.parse($response, function(key, value) {
		        if (key!="fail"){
		        	weekdata[key]=value; // all week info to go in week array
		          }
		         else if (key=="fail"){
		        	console.log("could not get week");	
		        	weekdata['week']="unknown";  
		           }
		        });
		    if (weekdata['week']=='baseline'){
			       weekdata['weekno']=0;}
			if (weekdata['refresh']=='yes'){
				window.location.reload(true); //if changes are made to the target during the running of getWeek, the data returned should be refreshed
			}

		      if (past==true){
		    	  weekdata['week']="week" + viewWeek;
		      	  weekdata['weekno']= viewWeek;
		        //  var header= drawHeader2("week"+viewWeek, viewWeek, weekdata['comment']);
		      	  //drawTable(weekdata, methods, true);
		      	  }
		      //else {
			      
			     // }
		      var header = drawHeader2(weekdata['week'], weekdata['weekno'], weekdata['comment']);
		      document.getElementById("thisHeader").innerHTML= header['thisHeader'];
	          document.getElementById("thisAside").innerHTML= header['thisAside'];
	          document.getElementById("thisBlurb").innerHTML= header['blurb'];  
	          drawTable(weekdata, methods, past); //send the week data to the draw Table function to extract steps and draw the steps table
		  }
		  }, "viewWeek="+viewWeek);// get week 
		  }); //get methods
	 }
	
  $(window).click(function(event) {
	  //Something got clicked..
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
		   showWeek(true, document.getElementById('viewSteps').value);
		}
	   });
  $(window).focusout(function(event) {
	  var i_name= String(event.target.id);
	  //If a date has been set for a new target then add this
        if(i_name.startsWith('method')){
		   updateMethods(i_name);
		}
	   });

  
 
  function updateSteps(controlname, edit){
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
	  input = document.getElementById(inputname).value;	  
      var date_set = nudge;	
	  methodID = document.getElementById(method).value; 
	      //find out if there is a walk check box
      var walk_yn= '';
      if (document.getElementById(walk_ck)){
          walk_yn=document.getElementById(walk_ck).checked;
          }  
	  //use input, date set and series data to update the step values and store in the database
	  data= "date_set=" + date_set + "&steps=" + input + "&walk=" + walk_yn + "&method="+methodID;
	  console.log(data);
	  doXHR('./updateSteps.php', function(){
		  var $response = this.responseText;	  
	     window.location.reload(true);  	
	  }, data);
  }

  function recordComment(weekno){ //record a comment from the comments box
	  comment= JSON.stringify(document.getElementById('comment'+weekno).value);
	  if (comment!=''){// check there is something in the comment
	  data="weekno="+ weekno +"&comment=" + comment; //create data string
	  doXHR('addComment.php', function(){
		  var $response = this.responseText;
		  if ($response==1){
		  document.getElementById('form'+weekno).className= "form-group has-success";	//show green border if successful
		  
	  }	   else {
	  document.getElementById('form'+weekno).className= "form-group has-danger";	//show red border if not successful	}
	  }}, data);
	  }
  }
  
  
  function editSteps(controlname){//When has steps entry, and edit button clicked, enable edit of steps
	  // get number from string, which is the date of the control
	  var nudge = controlname.slice(-(controlname.length-7))
	  // get steps
	  inputname= "steps"+ nudge;
	  //change the steps span id into a control box
	  input = document.getElementById(inputname).textContent;
	  myval = document.getElementById(inputname).innerText; 	
	  str= "<form class = 'form-inline'> <div class='form-group'><input type='integer' class='form-control' placeholder="+ myval +" id='new"+ inputname +"' style='width: 7em'/></div></form>"; 
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
	  var method_ck = 'method'+ nudge;
	  doXHR("./getMethods.php", function getThisArray(){
			  var methods = JSON.parse(this.responseText); //methods just contains the potential methods that the user could draw from
			  var mymethod = document.getElementById(method_ck).innerText; 
			  var methodID = "PED";
			  for (i in methods){
				  if (methods[i]== mymethod){
					  methodID=i;}
				  }
              var methodspan='methodspan'+nudge;
			  document.getElementById(methodspan).innerHTML=selectMethods(method_ck, methodID, methods, true);
      });
	  
	  document.getElementById(controlname).value = "Update";
	  
	  //
  }
  
  function updateTarget(){
	  input = document.getElementById('setTarget');
	  thisdate = input.options[input.selectedIndex].value;
	  incTarget(thisdate);
	  
	  //data="date_set=" + thisdate;
	  //doXHR('updateTarget.php',function(){
		//  window.location.reload(true);}, data);
	  
  }

  
  function incTarget(newtarget){
	  data="date_set=" + newtarget;
	  console.log(data);
	  doXHR("updateTarget.php", function(){
		  window.location.reload(true);}, data);
  }
  
  
  function updateMethods(input){
	  var nudge = input.slice(-(input.length-6));
	  document.getElementById('method_message').innerHTML= "Using different devices to collect your steps data can give readings that differ. It is best to stick to the same device";
	  var editname="editBtn"+nudge;
	  document.getElementById('getModalHeader').innerHTML= "Changing method of step recording";
	  if (document.getElementById(editname)){
		  if (document.getElementById(editname).value=="Edit"){}else{
        $('#methodModal').modal('show');}}
		  else{
		   $('#methodModal').modal('show');}
	  }
  
  function viewPast(viewWeek){
	  //This allows users to view a week that is not current. 
	  //Argument called by viewStepsBtn. view Week is an integer representing number of weeks since baseline, 0 indexed
      	  showWeek(true, viewWeek);//}  
	  }
  
  </script>