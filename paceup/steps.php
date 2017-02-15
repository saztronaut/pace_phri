<!-- -->
<?php //include './steps_process.php'; 
//getWeek(); 
?>
<br><div class= "container">
<div class= "jumbotron">
<?php  //drawHeader();?> 
<span id="thisHeader"></span>
<span id="thisBlurb"></span>
</div></div>
<div class="container-fluid"> <div class = "row">
<div class = "col-sm-8 col-md-7"> <h2>You can record your step counts here.</h2> <span id="thisTable">Your steps should appear here</span><?php  //drawTableContents();?> </div>
<div class = "col-sm-4 col-md-4"> <p id="thisAside"><span id="thisTable">Motivational message</span> </p></div>
<div class = "col-sm-0 col-md-1"> </div>
</div></div>
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
	      if ($response==0){}
	      else{
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
			
          drawHeader2(weekdata['week'], weekdata['weekno']);

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
	   xhr.send();  
	}
	
  $(window).click(function(event) {
	  var i_name= String(event.target.id);
	 // input = document.getElementById(i_name).value;
	   if (i_name.startsWith('onemonth')){
            updateTarget();
			}
	   else if(i_name.startsWith('saveBtn')){
		   updateSteps(i_name, false);
		}
	   else if(i_name.startsWith('editBtn')){
		   if (document.getElementById(i_name).value=="Edit"){
		   editSteps(i_name);}
		   else{updateSteps(i_name, true);}
		}
	   else if(i_name.startsWith('method')){
		   getMethods(i_name);
		}
		   });

//  window.onfocusout = function(event) {
//	  var i_name= String(event.target.id);
//	  input = document.getElementById(i_name).value;
//	   if (i_name.startsWith('steps') && input!=""){
//            updateSteps(input, i_name);
//			}
//		   }

  
  function drawHeader2(week, weekno){
		if (week=='baseline'||week=='getweek1'||week=='delayweek1'){
		document.getElementById("thisHeader").innerHTML= "<h2> Baseline week of your walking plan</h2>";
		 blurb="<p> Before you start to increase your walking it is important to know how much you are currently doing. The best way to do this is for you to wear the pedometer and record our step counts each day for a full week. There is often quite a difference between weekends and weekdays, so it is important to try and record for a full week. Don't try to increase your walking this week, just do what you normally do, or your targets will be too high and too hard for you to achieve</p>";
			document.getElementById("thisBlurb").innerHTML= blurb;
		 }
		else {
			$getweek=weekno;
			document.getElementById("thisHeader").innerHTML= "<h2> Week "+ $getweek +" of your walking plan</h2>";
			 blurb="<p> Alternative blurb</p>";
		document.getElementById("thisBlurb").innerHTML= blurb;
		}
				
	}
      	 
  function updateSteps(controlname, edit){
	  //Potential answers are to not show dates in the future as this would reset the date?
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
//	  if (isNaN(input)==0){
	  date_set.setDate(date_set.getDate()-nudge);
	
	  date_set = date_set.toISOString();
	  methodID = document.getElementById(method).value; 
	      //find out if there is a walk check box

      var walk_yn= 0;
      if (document.getElementById(walk_ck)){
          var walk_yn=document.getElementById(walk_ck).value;
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
  
  function editSteps(controlname){

	  //When looking at data AFTER baseline, this function doesn't work. You want to nudge from the latest target +6, which may or may not be the current date. 
	  //Potential answers are to not show dates in the future as this would reset the date?
	  // get number from string, which is the number from the current date
	  var nudge = controlname.slice(-1)
	  // get steps
	  inputname= "steps"+ nudge;
	  //change the steps span id into a control box
	  input = document.getElementById(inputname).textContent;	
	  str= "<form class = 'form-inline'> <div class='form-group'><input type='integer' class='form-control' id='new"+ inputname +"' style='width: 7em'/></div></form>"; 
	  document.getElementById(inputname).innerHTML = str
	  //change the walk span id into a control box
	  var walk_ck= 'walk'+nudge;
      if (document.getElementById(walk_ck)){
    	  if (document.getElementById(walk_ck).textContent!=""){
          chkstr= "<form class = 'form-inline'> <div class='form-group'> <input type='checkbox' class='form-control' id='new"+ walk_ck +"'/> </div></form>";
          document.getElementById('walk_ck').value='on';}
          else {
          chkstr= "<form class ='form-inline'><div class='form-group'> <input type='checkbox' class='form-control' id='new"+ walk_ck    +"'/> </div></form>";}
          document.getElementById(walk_ck).innerHTML=chkstr;
          }  
	  //change the label of the button to "Save"	  
	  document.getElementById(controlname).value = "Update";
	  //
  }
  
  function updateTarget(input){
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
  
  function getMethods(input){
     alert ("Using different devices to collect your steps data can give readings that differ. It is best to stick to the same device");	  
	  }
  </script>
