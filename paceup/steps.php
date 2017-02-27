<!-- -->
<br><div class= "container">
<div class= "jumbotron">
<span id="thisHeader">Introduction to the week here</span>
<span id="thisBlurb">Explanation of the week here</span>
</div></div>
<div class="container-fluid"> <div class = "row">
<div class = "col-md-8"> <h2>You can record your step counts here.</h2> <span id="thisTable">Your steps should appear here</span> </div>
<div class = "col-md-4"> <p id="thisAside"><span id="thisTable">Message to motivate you should appear here</span> </p></div>
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
    	      if ($response==0){
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

//  window.onfocusout = function(event) {
//	  var i_name= String(event.target.id);
//	  input = document.getElementById(i_name).value;
//	   if (i_name.startsWith('steps') && input!=""){
//            updateSteps(input, i_name);
//			}
//		   }

  
  function drawHeader2(week, weekno){
		if (week=='baseline'||week=='getweek1'||week=='delayweek1' || week=='week0'){
			document.getElementById("thisHeader").innerHTML= "<h2> Baseline week of your walking plan</h2>";
			 blurb="<p> Before you start to increase your walking it is important to know how much you are currently doing. \
				 The best way to do this is for you to wear the pedometer and record our step counts each day for a full week. \
				  There is often quite a difference between weekends and weekdays, so it is important to try and record for a full week. \
				   Don't try to increase your walking this week, just do what you normally do, or your targets will be too high and too hard for you to achieve</p>";
				document.getElementById("thisBlurb").innerHTML= blurb;
		         thisAside="<h2> Frequently asked questions on the PACE-UP trial </h2> \
		        		<ul type='circle'> \
		     	    <li> What day of the week should I start recording? </li> \
		     	    <p><i> You can start whenever you want </i></p> \
		     	    <li> What if I miss a week through holiday, or illness, or injury? </li> \
		     	    <p><i> Just start with the next week, when you are able to</i></p> \
		     	    <li> How do I know what my target should be? </li> \
				     	    <p><i> You need to wear the pedometer and record your step count for 7 days \
				     	    to find out what your baseline average should is. This is referred to as your <b>baseline steps</b></i></p>";
			if (weekno=="0"){
				 thisAside+= "<p><b> Please note, any changes you now make will not alter your baseline steps</b></p>";}
				document.getElementById("thisAside").innerHTML= thisAside;
			 }
			else {
				$getweek=weekno;
				document.getElementById("thisHeader").innerHTML= "<h2> Week "+ $getweek +" of your walking plan</h2>";
				console.log("Get week " +$getweek);
	switch ($getweek){	
    case "1":
	case 1:					
				          blurb="<p> Your aim for week 1 is to add in an extra 1500 steps on three or more days this \
	week to your baseline steps. One good way to do this is to add in a 15 minute walk.<p>";
					  thisAside = "<h2> Tips and motivators </h2> <br> \
	<p> Remember walking should be brisk, but not uncomfortable. Fast enough to make \
	 you warm and aware of your breathing, but you should still be able to walk and talk. \
	One way to tell if you are walking at moderate intensity is if you can still talk, but \
	you can&#8217;t sing the words to a song!  <br>\
	Make walking part of your daily routine, in order to keep up the changes: <br> \
	Can I fit in an <b>extra</b> walk? <br> \
	Can I <b>increase</b> what I do already? \
	E.g. Get off the bus, tube or train a couple of stops earlier; take a longer route to the \
	shops or library; go for a walk during your lunch break.  <br> \
	If you prefer to, you can get your extra 1500 steps or your extra 15 minutes of \
	moderate intensity physical activity on some days by doing more of other activities \
	you enjoy, such as dancing, playing in the park with your children or grandchildren, \
	or playing badminton or tennis, cycling, or mowing the lawn!</p> <br> <br> \
	<br><p><i>Walking is man&#8217;s best medicine. ~ Hippocrates</i></p> <br> \
	<p><i>Make your feet your friend. ~J.M. Barrie</i></p>";
					  break;
	case "2":
	case 2:					
				          blurb="<p> Your aim for week 2 is to add in an extra 1500 steps on three or more days this \
	week to your baseline steps. One good way to do this is to add in a 15 minute walk.<p>";
					  thisAside = "<h2>Tips and motivators</h2> \
	<p>Make walking part of your daily routine:<p> <br> \
	<ul type='circle'> \
	    <li>Take the stairs when possible, rather than using a lift or escalator </li> \
	    <li>If you are going somewhere by car, try parking it a bit further away, so that you have to walk a little further </li></ul> \
	 <p> Remember your personal benefits from increasing walking (see page 3 of PACE-UP handbook) </p>\
	<p> What things are important to you in your life that might be improved through increasing your activity and fitness levels?  For example:  health benefits, weight loss, increased energy, improved mood, how you feel about your appearance? </p> <br> \
	<p> What might be the impact and gains of these changes for you?  For example:  </p> \
	<ul type='circle'> \
	  <li> I would be able to get back to playing sport with my friends </li> \
	  <li> It would feel great to be able to wear some new outfits </li> \
	  <li> I could do more with my time </li> \
	  <li> I could keep playing actively with my children or grandchildren </li></ul> \
	<p>If you are falling behind your targets</p> \
	<ul type='circle'> \
	  <li>Don&#8217;t give up </li> \
	  <li>If necessary &#8217;tread water&#8217; , that is, do the same for one week, rather than give up completely </li> \
	  <li>Turn to week 5 of your walking plan for some tips on overcoming obstacles </li></ul> \
	  <br><p> <i>Walking:  the most ancient exercise and still the best modern exercise.  ~Carrie Latet</i></p>";
				          break;					
	case "3":		
	case 3:		
				          blurb="<p> Your aim for week 3 is to add in an extra 1500 steps on five or more days this \
	week to your baseline steps. One good way to do this is to add in a 15 minute walk.<p>";
				          thisAside = "<h2>Keep it up!</h2> \
	<p>Remember to praise and reward yourself for any success that you have achieved so far, no matter how small it seems!  This will help motivate you to keep going.  </p>\
	<p>Examples:</p> \
	<ul type='circle'> \
	  <li>Spend time noticing any changes in your fitness or appearance</li> \
	  <li>Plan something you enjoy such as meeting a friend or watching a football match</li> \
	  <li>Give yourself some time to relax such as having a bath, a cup of tea or read a paper </li> \
	  <li>Wear those clothes you have been waiting to get in to </li></ul> \
	<p><b>Walking with others makes the activity more enjoyable</b>, so you may be more likely to go for the walk and to keep going. </p> \
	<p> Could you: </p> \
	<ul type='circle'> \
	  <li>Plan some walks with friends and family?  </li> \
	  <li>Plan a walk to an activity you enjoy?</li> \
	  <li>Join a walking group to meet like-minded walkers and make some new friends at the same time? </li> \
	  <li>Walk the dog or a neighbour&#8217;s dog? </li></ul> \
			  <br><p> <i>People say that losing weight is no walk in the park.  When I hear that I think, yes, that is the problem.  ~Chris Adams	</i></p>";
					  break;				
	case "4":	
	case 4:	
				          blurb="<p> Your aim for week 4 is to add in an extra 1500 steps on five or more days this \
	week to your baseline steps. One good way to do this is to add in a 15 minute walk.<p>";
					  thisAside = "<h2> Keep motivated!</h2> \
	<p>Well done so far!  Are you remembering to give yourself praise and small rewards for any progress that you make?  </p> \
	<p> Please remember to record your daily step counts.  Seeing the progress you are making in black and white can really help to keep you going. </p> \
	<p>Asking for support and encouragement from family and friends can also be very helpful for keeping up the changes. </p> \
	<p>Notice the changes and benefits. What do I notice and what do others see? Pay attention to any compliments! </p> \
			<br><p> <i>The best remedy for a short temper is a long walk.  ~Jacqueline Schiff</i></p>";
					  break;
	case 5:	
	case "5":				
				          blurb="<p> Your aim for week 5 is to add in an extra 3000 steps on three or more days this \
	week to your baseline steps.</p> \
	<p>One good way to do this is to add in a 30 minute walk.<p>";
					  thisAside = "<h2>Now we are moving!</h2> \
	<p>Often increasing your walking means planning ahead and overcoming obstacles </p> \
	<p>Think about some of the obstacles that make you less likely to walk and how you could overcome them: </p> \
	<p><b>Obstacle:</b>  &#8217I don&#8217t have the time to do a 30 minute walk. I am so pushed for time already &#8217  </p> \
	<p><b>Solution:</b>  You don&#8217t have to do your 30 minute walk in one go, you can break it up into walks of 10 or 15 minutes, spread throughout the day. </p> \
	<p><b>Obstacle:</b> &#8217It&#8217s raining and I&#8217ll be soaked when I arrive for the meeting&#8217 </p> \
	<p><b>Solution:</b> Dress for the weather or plan the walk on a different day or in a different place like an indoor shopping centre </p> \
	<p>What are the barriers that make you less likely to walk?   These might include:</p> \
	<ul type='circle'> \
	<li>Places that make it more difficult to be active, e.g. at work in an office </li> \
	<li>Other activities that might get in the way </li> \
	<li>People who make it more difficult to keep up your walking  </li> \
	<li>Thoughts and feelings, e.g. feeling fed up, tired or lethargic </li> \
	<li>Physical symptoms and reactions e.g. back pain or a physical health problem </li> </ul> \
	<p>Think about how you might overcome these obstacles.  List a range of possible solutions and be prepared to experiment to find out what works best. </p> \
	<br><p><i> Motivation is what gets you started. Habit is what keeps you going. Anonymous</i> </p>";
					  break;					
	case 6:	
	case "6":				
				          blurb="<p> Your aim for week 6 is to add in an extra 3000 steps on three or more days this \
	week to your baseline steps.</p> \
	<p>One good way to do this is to add in a 30 minute walk.<p>";
					  thisAside = "<h2> How to make these changes a permanent part of your life</h2> \
	<p><b>Interest: </b> Are there new walks you could try?  Where might you enjoy walking in your local area?  </p> \
	<ul type='circle'> \
	<li>The local park </li> \
	<li>Countryside or woodlands </li> \
	<li>River Thames or Wandle </li> \
	<li>Tourist attractions in central London </li> \
	<li>Look at the suggested websites GET LINK </li></ul> \
	<p><b>Time/means:</b> What can you not do in order to make time for your walks and make it a priority?</p> \
	<p><b>Gains:  What changes have you noticed so far?</b></p> \
	<p>Take a moment to think about what you have achieved so far.  </p> \
	<p>Has there been any change in your walking pattern and step-count since starting this programme?  Do you feel any different?  Are there changes in your weight, waist size, mood or energy levels?  </p> \
	<p><b>If so, well done!  Give yourself a pat on the back.</b>  Keeping these changes going can lead to real benefits that last over time.</p> \
	<br><p> <i>I have two doctors, my left leg and my right.  ~G.M. Trevelyan</i></p>";
					  break;
					case 7:					
				          blurb="<p> Alternative blurb</p>";
					  thisAside = "<p> This motivational message</p>";
				          break;					
					case 8:					
				          blurb="<p> Alternative blurb</p>";
				          thisAside = "<p> This motivational message</p>";
					  break;				
					case 9:					
				          blurb="<p> Alternative blurb</p>";
					  thisAside = "<p> This motivational message</p>";
					  break;
					case 10:					
				          blurb="<p> Alternative blurb</p>";
					  thisAside = "<p> This motivational message</p>";
					  break;
					case 11:					
				          blurb="<p> Alternative blurb</p>";
				          thisAside = "<p> This motivational message</p>";
					  break;				
					case 12:					
				          blurb="<p> Alternative blurb</p>";
					  thisAside = "<p> This motivational message</p>";
					  break;
					case 13:					
				          blurb="<p> Alternative blurb</p>";
					  thisAside = "<p> This motivational message</p>";
					  break;					
					    }
			document.getElementById("thisBlurb").innerHTML= blurb;
			document.getElementById("thisAside").innerHTML= thisAside;
			}
				
	}
      	 
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
//	  if (isNaN(input)==0){
//	  date_set.setDate(date_set.getDate()-nudge);
      date_set = nudge;	
//	  date_set = date_set.toISOString();
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
     alert ("Using different devices to collect your steps data can give readings that differ. It is best to stick to the same device");	  
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
		        	  console.log(key);
	        	    	weekdata[key]=value;
	        	  }
	        	  else if (key=="fail"){
	        	    	console.log("could not get week");	
	        	    	weekdata['week']="unknown";  
	        	  }      	  
	          });
			
          drawHeader2(weekdata['week'], viewWeek);

      	  var xhr2 = new XMLHttpRequest();
      	  ///create a string to parse to build the table
      	  myString="week=" + weekdata['week'];
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
