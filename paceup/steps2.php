<!-- -->
<?php include './template.php';?>
<div class= "container">
<div class= "jumbotron">
<h2 id="thisHeader">Record your steps here</h2>
<span id="thisBlurb"></span>
</div></div>
<div class="container-fluid-extrapad"> <div class = "row">
<div class = "col-md-7"><span id="thisTable">Please wait while your steps data is being retrieved</span> </div>
<div class = "col-md-5"> <p id="thisAside"><span id="thisTable"></span> </p></div>
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
<?php include './footer.php';?>
<script src="./drawHeader.js"></script>
<script src="./drawMethodsSelect.js"></script>
<script src="./drawStepsTable.js"></script>
<script src="./dateFunctions.js"></script>
<script src="./twelveWeekSummary.js"></script>
  <script> 
window.onload = showWeek(false, null);

function showWeek(past, viewWeek){
    // default show current week. past true/false indicates viewing a week which is not the current week. 
    // view Week is the week to display (if past)
   doXHR("./getMethods.php", function getThisArray() {
        var methods = JSON.parse(this.responseText); //methods just contains the potential methods that the user could draw from
        var weekdata= [];   //data about the current week (week name, week num, target steps, target days, comments for that week, current week num)  
        doXHR("./getWeek.php", function getWeek() {	  	 
           var $response = this.responseText;	
           //console.log($response);  
           if ($response == "0") {
				document.getElementById("thisTable").innerHTML= "<h4> Whoops, you need to be logged in to record your steps! Redirecting you</h4>";
				setTimeout(function() {redirect('./landing_text.php');},2500);
				
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

		      if (past==true){
		    	  weekdata['week']="week" + viewWeek;
		      	  weekdata['weekno']= viewWeek;
		        //  var header= drawHeader2("week"+viewWeek, viewWeek, weekdata['comment']);
		      	  //drawTable(weekdata, methods, true);
		      	  }
		      //else {
			      
			     // }
		      var header = drawHeader2(weekdata['week'], weekdata['weekno'], weekdata['comment']);
		      document.getElementById("thisHeader").innerHTML = header['thisHeader'];
	          document.getElementById("thisAside").innerHTML = header['thisAside'];
	          document.getElementById("thisBlurb").innerHTML = header['blurb'];  
	          drawTable(weekdata, methods, past); //send the week data to the draw Table function to extract steps and draw the steps table
		  }
		  }, "viewWeek="+viewWeek);// get week 
		  }); //get methods
	 }
	

function editBtnCheck(i_name, target){
    if (document.getElementById(i_name).value == "Edit") {
        editSteps(i_name, target);
    } else {
    updateSteps(i_name, true, target);
    }
}

function updateSteps (controlname, edit, target) {
    var nudge = controlname.slice(-(controlname.length-7));
    // get steps
    if (edit == true){
        var inputname= "newsteps" + nudge;
        var walk_ck= 'newwalk' + nudge;
    } else {
        var inputname= "steps" + nudge;
        var walk_ck= 'walk' + nudge;
	}
	input = document.getElementById(inputname).value;
	var carryOn = checkSteps(input);
	var message = "";
	var button = 0;
	if (carryOn === 1) {
        updateStepsTable(controlname, edit, target, nudge, input , inputname , walk_ck);
	} else if (carryOn === 2) {
		message = "Please enter a number";
    } else if (carryOn === 3 || carryOn === 4) {
		message = "<p class= 'text-center'>Are you sure you walked " + input + " steps on this day?</p>";
		message += "<p class= 'text-center'><button type= 'button' class='btn btn-default' onclick='updateStepsTable(\"" + controlname + "\", " + edit + "," + target + ",\"" + nudge +  "\"," + input +  ",\"" + inputname + "\",\"" + walk_ck + "\")'> Yes  </button>";
		message += "<button type= 'button' class='btn btn-default' onclick='hideModal()'> No  </button></p>";		
	    document.getElementById('getModalHeader').innerHTML = "Checking your daily steps";
		document.getElementById('method_message').innerHTML = message;
    $('#methodModal').modal('show');
    }
	
	
	
}

function updateStepsTable(controlname, edit, target, nudge, input , inputname , walk_ck){
    hideModal();
    var method= 'method' + nudge;
//	input = document.getElementById(inputname).value;
	console.log("inputname"+ inputname);  
    var date_set = nudge;
    methodID = document.getElementById(method).value;
	      //find out if there is a walk check box
    var walk_yn = '';
    if (document.getElementById(walk_ck)){
        walk_yn = document.getElementById(walk_ck).checked;       
    }  
	  //use input, date set and series data to update the step values and store in the database
    data = "date_set=" + date_set + "&steps=" + input + "&walk=" + walk_yn + "&method="+methodID;
    console.log(data);
    doXHR('./updateSteps.php', function() {
        var $response = this.responseText;
        console.log($response);	
        if ($response === "Refresh") { 
            window.location.reload(true);
        } else {
            if (edit == true){
                document.getElementById(inputname).innerHTML = "";
            }
                document.getElementById("divsteps" + nudge).innerHTML = "<span id='steps"+ nudge +"' value ="+ input + " >" + input +  "</span>";
               	document.getElementById("methodspan" + nudge).innerHTML = "<span id='method"+ nudge +"' value ="+ methodID + " >" + methodID +  "</span>";
              //  } else {
              // console.log( "input name: " + inputname);
              //  document.getElementById(inputname).innerHTML = "";
                document.getElementById("divsteps" + nudge).innerHTML = "<span id='steps"+ nudge +"' value ="+ input + " >" + input +  "</span>";
            	document.getElementById("methodspan" + nudge).innerHTML = "<span id='method"+ nudge +"' value ="+ methodID + " >" + methodID +  "</span>";
               // }
            if (document.getElementById(walk_ck)){           	
            	    console.log ("divwalk" + nudge);
        		    document.getElementById("divwalk" + nudge).innerHTML = "<br>";       		    
                } 
        	if (walk_yn == true) {
            	document.getElementById("divwalk" + nudge).innerHTML = "<span  class='glyphicon glyphicon-ok logo-small'></span>";
            	}
        	console.log(target);
        	if (target !== 0 && target !== null && target !== false && target <= input) {
            	document.getElementById("achieved" + nudge).className= "glyphicon glyphicon-star logo-small";
            	}
        	else if (document.getElementById("achieved" + nudge)) {
            	document.getElementById("achieved" + nudge).className= "";
        	    }
            document.getElementById("changeBtn" + nudge).innerHTML = "<input type='button' class='btn btn-default' id='editBtn"+ nudge +"' value='Edit' onclick='editBtnCheck(\"editBtn"+ nudge + "\"," + parseInt(target) + ")'></div></form></span>";
            }	
        }, data);
}

function checkSteps(steps){
	
    var response = 0;
    if (isNaN(steps)) {
        response = 2; // Not a number 
    } else if (steps < 1000){
        response = 3; // suspiciously low
    } else if (steps > 50000) {
        response = 4; // suspiciously high
    } else {
        response = 1;
    }

    return response;
	
}

function recordComment(weekno) { //record a comment from the comments box
    comment= JSON.stringify(document.getElementById('comment'+weekno).value);
    if (comment!=''){ // check there is something in the comment
        data="weekno=" + weekno + "&comment=" + comment; //create data string
        doXHR('addComment.php', function(){
           var $response = this.responseText;
           if ($response == 1) {
               document.getElementById('form'+weekno).className = "form-group has-success";	//show green border if successful	  
           } else {
               document.getElementById('form'+weekno).className = "form-group has-danger";	//show red border if not successful	
           }
        }, data);
    }
}
  
  
function editSteps(controlname, target) {//When has steps entry, and edit button clicked, enable edit of steps
    // get number from string, which is the date of the control
    var nudge = controlname.slice(-(controlname.length-7))
    // get steps
    inputname= "steps" + nudge;
    //change the steps span id into a control box
    input = document.getElementById(inputname).textContent;
    myval = document.getElementById(inputname).innerText; 	
    str= "<form class = 'form-inline'> <div class='form-group-" + inputname +"'><input type='integer' class='form-control' placeholder=" + myval + " id='new" + inputname + "' style='width: 7em'/></div></form>"; 

    document.getElementById(inputname).innerHTML = str;
    document.getElementById("new" + inputname).value = myval;
    //change the walk span id into a control box
    var walk_ck = 'walk' + nudge;
    if (document.getElementById(walk_ck)) {
        console.log(document.getElementById(walk_ck).textContent);
        if (document.getElementById(walk_ck).textContent!=="" || document.getElementById(walk_ck).textContent!== null) {
            chkstr = "<span id='divwalk"+ nudge +"'><form class = 'form-inline'> <div class='form-group'> <input type='checkbox' class='form-control' id='new" + walk_ck + "> </div></form></span>";
        } else {
            chkstr = "<span id='divwalk"+ nudge +"'><form class ='form-inline'><div class='form-group'> <input type='checkbox' class='form-control' id='new" + walk_ck + "'> </div></form></span>";
        }
        document.getElementById(walk_ck).innerHTML=chkstr;
    }  
	  //change the label of the button to "Save"	  
    var method_ck = 'method' + nudge;
    doXHR("./getMethods.php", function getThisArray() {
        var methods = JSON.parse(this.responseText); //methods just contains the potential methods that the user could draw from
        var mymethod = document.getElementById(method_ck).innerText; 
        var methodID = "PED";
        for (i in methods) {
            if (methods[i] == mymethod) {
                methodID = i;
            }
        }
        var methodspan = 'methodspan'+nudge;
        document.getElementById(methodspan).innerHTML=selectMethods(method_ck, methodID, methods, true);
    });
    document.getElementById(controlname).value = "Update";
}
  
function updateTarget(){
    input = document.getElementById('setTarget');
    thisdate = input.options[input.selectedIndex].value;
    incTarget(thisdate);
	  
}

  
function incTarget(newtarget) {
    data="date_set=" + newtarget;
    console.log(data);
    doXHR("updateTarget.php", function(){
        window.location.reload(true);
    }, data);
}
  
  
function updateMethods(input) {
    var nudge = input.slice( - (input.length - 6));
    document.getElementById('method_message').innerHTML= "Using different devices to collect your steps data can give readings that differ. It is best to stick to the same device";
    var editname="editBtn" + nudge;
    document.getElementById('getModalHeader').innerHTML= "Changing method of step recording";
    if (document.getElementById(editname)){
        if (document.getElementById(editname).value !== "Edit") {
            $('#methodModal').modal('show');
        }
    } else {
        $('#methodModal').modal('show');
    }
}
  
function hideModal () {
	 $('#methodModal').modal('hide');
}
  </script>