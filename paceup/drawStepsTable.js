
	function drawTable(weekdata, methods, finish=false){
    	  var xhr = new XMLHttpRequest();
      	  ///create a string to parse to build the able
      	  myString="week=" + weekdata['week'];
      	  myString+="&weekno=" + weekdata['weekno'];
      	  myString+="&steps=" + weekdata['steps'];     	  
      	  myString+="&latest_t=" + weekdata['latest_t'];
      	  myString+="&days=" + weekdata['days'];
      	  myString+="&base=" + weekdata['baseline'];
      	  if (finish==true){
      	  myString+="&finish=" + weekdata['finish'];}
       	  //xhr.open("POST", 'drawTable2.php', true);
    	  //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	  //xhr.onreadystatechange = function () 
    	  	  
    	  doXHR("./drawTable2.php", function (){		 
    		  var $drawTable = this.responseText;	    		    
    	      if ($drawTable==0){
        	      }
    	      else {       	      
    	         var tabledata = JSON.parse($drawTable);
                 var n_show= tabledata.n_show;
                 if (n_show>0){n_show=n_show-1;}
                 var tableResults= tabledata.tableResults;
                 var showrow= [];
                 var ispast=[];
                 for (i in tableResults){
                     showrow.push(tableResults[i].showrow);
                     ispast[i] = tableResults[i].ispast;
                     }
         		  mysteps=weekdata['steps'];
                  week=weekdata['week'];
                  weekno=weekdata['weekno'];
                  days=weekdata['days'];
                 $drawMyTable=[];
                 if (tabledata.bump==1 && tabledata.ispast==0){
                	 $drawMyTable.push(bumpTarget(weekno, tableResults.newweek));
                 }
                 for (x = 0; x <=n_show; x++) {   
                 
                 myTable=drawMySteps(x, week, weekno, weekdata['baseline'], days, weekdata['steps'], showrow[x],  methods, mysteps, weekdata['days']);
                 $drawMyTable.push(myTable['mytable']);
                 if (myTable['showtargets']==1){
                 $drawMyTable.push(stepsFeedback(week, myTable['targetdays'], myTable['totalsteps'], myTable['totaldays'], days, ispast[x], mysteps));}
                     }
                 $drawMyTable.push(goBack(week, weekdata['maxweekno']));
         		printThis = $drawMyTable.join('\n');
    	    	  document.getElementById("thisTable").innerHTML= printThis;
        	     
              }
          }, myString);
    	  //xhr.send(myString);
		}

	function drawMySteps(x, thisWeek, weekno, baseline="", daysw="", target="", steparray=[], methods, targetstep, targetday){
		var mytable=[]; //this creates the html table to be displayed
		var walkmin=""; //either 15 or 30 minutes to aim for
		var showtargets=""; // show targets (i.e. not a baseline week)
	    var totalsteps=0; // total number of steps for week
		var totaldays=0; //total number of days with reading for week
		var targetdays=0; //total number of days achieved target for that week	 

		if (thisWeek=='baseline'||thisWeek=='getweek1'||thisWeek=='delayweek1'||thisWeek=='week0'){
		mytable.push("<div class='table'> <table class='table table-plain'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Device</th><th></th></tr></thead>");
			showtargets=0;
			}
		else {
			if(weekno>0 && weekno<5 ){
				walkmin=15;
			}else{
				walkmin=30;}
	    mytable.push("<p> Your average daily steps at baseline were <b>"+ baseline +" steps</b>. This week your target is to to increase this to <b>"+ target +" steps on "+ daysw +" days per week</b></p>");
	    mytable.push("<div class='table'> <table class='table table-plain'><thead><tr><th>Day</th><th>Date</th><th>Did you add </br>a walk of </br>"+ walkmin +" minutes </br>or more </br>today?</th><th>Steps</th><th>Device</th><th>Achieved </br>target</th><th></th></tr></thead>");
			showtargets=1;
			}
		console.log(steparray);

		for (i in steparray){ //draw each day as a row of information about steps
			var day = steparray[i].day;
			var stepdate = steparray[i].stepdate;
			var date_set = steparray[i].date_set;
			var add_walk = steparray[i].addwalk;
			var give_pref = steparray[i].give_pref;
			var stepsread = steparray[i].stepsread;
			
			// Show the day of the week and date
		    mytable.push( "<tr><td data-title='Day'>"+ day+ "</td><td data-title='Date'>"+ stepdate+ " </td>");
			if (showtargets==1){ //if you are showing targets, ask if the pt had a walk that day
			if (add_walk!=null){
				if (add_walk==1){
					mytable.push( "<td data-title='Did you add a walk in today?' align='center'> <span id='walk"+ date_set +"' ><span  class='glyphicon glyphicon-ok logo-small'></span></span></td>");}
				else {
					mytable.push( "<td data-title='Did you add a walk in today?' align='center'> <span id='walk"+ date_set +"'></span></td>");}
			}
			else {
				mytable.push( "<td data-title='Did you add a walk in today?' align='center'> <form class = 'form-inline'> <div class='form-group'> ");
					mytable.push( "<input type='checkbox' class='form-control' id='walk"+ date_set +"'> </div>");
	        mytable.push("</form></td>");
			  }
		     
			mytable.push("<td data-title='Steps'>");
		    }
			if (stepsread!=null){
				totalsteps= totalsteps+ stepsread;
				totaldays= totaldays+ 1;
				mytable.push("<span id='steps"+ date_set +"' value ="+ stepsread + " >"+ stepsread +  "</span>");
			}
			else {
				mytable.push("<form class = 'form-inline'> <div class='form-group'>");
				mytable.push("<input type='integer' class='form-control' placeholder='Enter steps' id='steps"+ date_set +"' style='width: 7em' ></div>");
				mytable.push("</form>");
			}
			mytable.push("</td><td data-title='Device'><span id ='methodspan"+ date_set+"'>");
			mytable.push(selectMethods("method"+ date_set, give_pref, methods));
			mytable.push("</span></td>");
			///Get stars
			if (showtargets==1){
				if ((targetstep!=null)&&(targetstep<= stepsread)){
					mytable.push("<td  data-title='Achieved target'  align='center'><span class='glyphicon glyphicon-star logo-small'></span></td>");
					targetdays= targetdays+1;
				}
				else { mytable.push("<td  data-title='Achieved target' align='center'></td>");}
							}
			if (stepsread!=null){ //If there is already a step count give option to edit else option to add new
				mytable.push("<td><input type='button' class='btn btn-default' id='editBtn"+ date_set +"' value='Edit'></div></form></td>");}
			else {
			    mytable.push("<td><input type='button' class='btn btn-default' id='saveBtn"+ date_set +"' value='Add'> </div></form></td>");
			}
			 mytable.push("</tr>");
			
			}
		mytable.push("<table>");
		myTableString = mytable.join(" ");
	    sendback=[]
	    sendback['mytable']=myTableString;
	    sendback['totalsteps']=totalsteps;
	    sendback['totaldays']=totaldays;
	    sendback['targetdays']=targetdays;
	    sendback['showtargets']=showtargets;
		return sendback;
			
		};
	
	function stepsFeedback(week, targetdays, totalsteps, totaldays, daysw, ispast, steps){
//targetdays - number of days achieved target
//total steps - total number of steps
// total days - total number of days that have readings
// daysw - number of days in target
//ispast - this week is not the current week
// steps - target
        var print=[];
		if (week=="baseline" ||week=="week0" || week=="getweekone"){
			if (steps>0) {	
				print.push("<p><b>Your average daily step count ="+ steps +"</b>. This number is your <b>baseline steps</b><br></p><br>");
				print.push("<p>You will use this number to work out your target in the 12 week programme. In weeks 1-4 you will add 1500 steps to this number and gradually increase the number of days that you do this on. In weeks 5-12 you will add 3000 to this number and again gradually increase the number of days that you do this on.</p>");}
			}
		else{
//			//IF not in baseline, give feedback on targets
      
		if (targetdays>daysw) {
			//If they achieved over their target
		print.push("<p> You have achieved your target on "+ targetdays +" days this week. You were aiming for "+ daysw +" days, well done!");}
		else if (targetdays==daysw){	
			//If they achieved their target
			print.push("<p> You have achieved your target on "+ targetdays +" days this week, well done!");
	         }
	else if (targetdays>0 && targetdays<daysw){
		//Did not achieve target
		if (totaldays<(7- daysw + targetdays)){
			//If did not achieve target yet, but week still has enough time to achieve target
			if (targetdays>1){
	    print.push( "<p> You have achieved your target on "+ targetdays +" days so far this week, well done. See if you can do this on "+ daysw +" days this week");}
				else
				{ if(ispast==1){
					//if in the past (shouldn't occur..)
					print.push("<p> You achieved your target once on this week, well done.");
				} else {
					//If did not achieve target yet, but week still has enough time to achieve target
		print.push("<p> You have achieved your target once so far this week, well done. See if you can do this on "+ daysw +" days this week");}
				}
	}
	 else {
	 	if (targetdays>1){
	 		if(ispast==1){
	 			//If they achieved their target on fewer days than specified and in past
	 			print.push("<p> You achieved your target on "+ targetdays +" days this week, well done.");
	 		} else{
	 			//If they achieved their target on fewer days than specified and they do not have enough days this week to reach this
	 	print.push("<p> You have achieved your target on "+ targetdays +" days this week, well done. See if you can do this on "+ daysw +" days next week");}}
	 	else 
	 	//If did not achieve target yet, encouragement to achieve it next week
	 	{ print.push("<p> You have achieved your target once this week, well done. See if you can do this on "+ daysw +" days next week");
	 }}}
	else {if (ispast==1){} else{
		print.push("<p> See if you can achieve your target of "+ steps + " on "+ daysw +" days next week");}}}
		printThis = print.join('\n');
		return printThis;
	}
	function goBack(week, maxweek){
	////This gives the option to view previous weeks (if they have any)
       var print=[];
	   if ((week=='baseline'||week=='getweek1'||week=='delayweek1')==0){
	     print.push("<br><p><b>View your step counts from previous weeks </b></p>");
		 print.push(" <form class = 'form-inline'> <div class='form-group'>");
		 print.push("<select class='form-control' placeholder='View previous step counts' id='viewSteps' name='viewSteps'>");
		for (x = maxweek; x >=0; x--) {
				// if the week is odd, start date is the target date
				// if the week is even, the start date is the target date + 7
			print.push( "<option value ='"+ x +"'>");
			print.push("Week "+ x ) ;
			print.push("</option>");
		}
		print.push("</select></div> <div class='form-group'>");
		print.push( "<button type='button' class='btn btn-default' id='viewPastBtn'> View Steps </button> </div></form>");
		}
		printThis = print.join('\n');
		return printThis;
		}
	
	function bumpTarget(weekno, newweek){ // allows user to move to next target even if they didn't hit it
		var print="";
		print+="<div class='form-group'><p><b>You have been given an extra week to hit the target from week " + weekno + " ";
		print+="<button type='button' class='btn btn-default' id='increaseT' onclick=\"javascript:incTarget('"+$new_week+"')\">Click here to move onto the next target</button></div></form></b></p>";

		return print
	}
	