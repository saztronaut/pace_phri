function drawTable(weekdata, methods, finish) {
    "use strict";
    // var xhr = new XMLHttpRequest();
    ///create a string to parse to build the able
    var myString = "week=" + weekdata.week;
    myString += "&weekno=" + weekdata.weekno;
    myString += "&steps=" + weekdata.steps;
    myString += "&latest_t=" + weekdata.latest_t;
    myString += "&days=" + weekdata.days;
    myString += "&base=" + weekdata.baseline;
    if (finish === true) {
        myString += "&finish=" + weekdata.finish;
    }
    var mysteps = weekdata.steps; //target steps
    var week = weekdata.week; //name of the week
    var weekno = weekdata.weekno; // number of the week
    var days = weekdata.days; //days to reach target
    var myTable = "";
    if (week === "finished") {
        var post12message = drawNoContinue();
        var printThis = post12message.join("\n");
        document.getElementById("thisTable").innerHTML= printThis;
    } else {
        doXHR("./drawTable2.php", function () {
            var $drawTable = this.responseText;
            if ($drawTable === 0) { //you don't want to draw the table if there is no data
            } else {
                var tabledata = JSON.parse($drawTable);
                var n_show = tabledata.n_show; //number of tables to show
                var display13 = 1;
                if (n_show > 0) {
                    n_show = n_show - 1;
                } // 0 index
                var tableResults= tabledata.tableResults;
                var showrow = []; //create array to store the day-level data
                var ispast = [];
                var i = 0;
                for (i in tableResults) {
                    showrow.push(tableResults[i].showrow);
                    ispast[i] = tableResults[i].ispast;
                }
                var $drawMyTable = [];
                $drawMyTable.push("<h3> You can record your steps here </h3>");
                if (weekdata.week === "getweek1") {
                    //show select week button
                    var onew = setWeekOne(weekdata.latest_t, weekdata.baseline);
                    $drawMyTable.push(onew);
                } else if (weekdata.week === "delayweek1") {
                    var showDate = new Date(weekdata.latest_t);
                    $drawMyTable.push("<p>You will start to increase your steps from " + giveDay(showDate) + " ( " + forwardsDate(showDate) + ")</p>");
                } else if (weekdata.week === "finished") {
                // var post12message=drawNoContinue();
                // var printThis = post12message.join("\n");
                // document.getElementById("thisTable").innerHTML= printThis;
                }
                if (weekno >= 13) {
                    console.log(weekdata.summary);
                    if (weekdata.summary === 1) {
                        //display chart
                        twelveWeek();
                    } else if (weekdata.summary === 3) {
                        display13 = 0;
                        week = "finished";
                        weekno = 13;
                    }
                }
                if (display13 === 1) {
                    if (tabledata.bump === 1 && tabledata.ispast === 0) {
                        $drawMyTable.push(bumpTarget(weekno, tabledata.new_week));
                    }
                    var x = 0;
                    for (x = 0; x <= n_show; x++) {
                 // for each table to show, draw the table
                        myTable = drawMySteps(x, week, weekno, weekdata.baseline, days, weekdata.steps, showrow[x],  methods, mysteps, weekdata.days);
                        $drawMyTable.push(myTable.mytable);
                        if (myTable.showtargets === 1){
                 // if has target give feedback based on achievement
                            $drawMyTable.push(stepsFeedback(week, myTable.targetdays, myTable.totalsteps, myTable.totaldays, days, ispast[x], mysteps));
                        }
                    }
                 // if not week 0, give option to view data from previous weeks
                    $drawMyTable.push(goBack(week, weekdata.maxweekno, weekno));
                    var printThis = $drawMyTable.join("\n");
                    document.getElementById("thisTable").innerHTML = printThis;
                } else { //display the summary
                }
            }
        }, myString);
    }
}

function drawMySteps(x, thisWeek, weekno, baseline, daysw, target, steparray, methods, targetstep, targetday) {
        var mytable = []; //this creates the html table to be displayed
        var walkmin = ""; //either 15 or 30 minutes to aim for
        var showtargets = ""; // show targets (i.e. not a baseline week)
        var totalsteps = 0; // total number of steps for week
        var totaldays = 0; //total number of days with reading for week
        var targetdays = 0; //total number of days achieved target for that week
        var showdays = daysw;
        var day = "";
        var stepdate = "";
        var date_set = "";
        var add_walk = "";
        var give_pref = "";
        var stepsread = "";

        if (showdays > 5) { showdays = "most";
        }
        //draw table header
        if (thisWeek === "baseline" || thisWeek === "getweek1" || thisWeek === "delayweek1" || thisWeek === "week0"){
            mytable.push("<div class='table'> <table class='table table-plain'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Device</th><th></th></tr></thead>");
            showtargets=0;
            } else {
            // number of minutes to show in text "did you add a walk of walkmin minutes or more ..."
            if (weekno > 0 && weekno < 5) {
                walkmin = 15;
            } else {
                walkmin=30;}
            mytable.push("<p> Your average daily steps at baseline were <b>"+ baseline +" steps</b>. This week your target is to to increase this to <b>"+ target +" steps on "+ showdays +" days per week</b></p>");
            mytable.push("<div class='table'> <table class='table table-plain'><thead><tr><th>Day</th><th>Date</th><th>Did you add </br>a walk of </br>"+ walkmin +" minutes </br>or more </br>today?</th><th>Steps</th><th>Device</th><th>Achieved </br>target</th><th></th></tr></thead>");
            showtargets=1;
        }
        //console.log(steparray);

        for (i in steparray) { //draw each day as a row of information about steps
            day = giveDay(steparray[i].date_set);
            stepdate = forwardsDate(steparray[i].date_set);
            date_set = steparray[i].date_set;
            add_walk = steparray[i].addwalk;
            give_pref = steparray[i].give_pref;
            stepsread = steparray[i].stepsread;
            // Show the day of the week and date
            mytable.push( "<tr><td data-title='Day'>"+ day+ "</td><td data-title='Date'>"+ stepdate+ " </td>");
            if (showtargets === 1) { //if you are showing targets, ask if the pt had a walk that day
                if (add_walk!== null) {//if there is already steps data, show a check or a blank
                    if (add_walk==1){ //show a check
                        mytable.push( "<td data-title='Did you add a walk in to your day?'  class='text-center'> <span id='walk"+ date_set +"' ><span  class='glyphicon glyphicon-ok logo-small'></span></span></td>");
                        } else {// show a blank
                            mytable.push( "<td data-title='Did you add a walk in to your day?'  class='text-center'> <span id='walk"+ date_set +"'> </span><br></td>");}
                        } else { //show a checkbox control
                            mytable.push( "<td data-title='Did you add a walk in to your day?' class='text-center'> <form class = 'form-inline form-inline-scale'> <div class='form-group'> ");
                            mytable.push( "<input type='checkbox' class='form-control' id='walk"+ date_set +"'> </div>");
                        mytable.push("</form></td>");
                    }
                }
                mytable.push("<td data-title='Steps'  class='text-center'>");
                if (stepsread!== null) { // if there is already a step count, add to total and display as text
                    totalsteps= totalsteps+ stepsread;
                    totaldays= totaldays+ 1;
                    mytable.push("<span id='steps"+ date_set +"' value ="+ stepsread + " >"+ stepsread +  "</span>");
                    mytable.push("</td><td data-title='Device'><form class = 'form-inline form-inline-scale'> <div class='form-group'><span id='methodspan"+ date_set+"'>");
                    mytable.push(selectMethods("method"+ date_set, give_pref, methods, false));
                    mytable.push("</span></div></form></td>");
                } else { // if no steps for this date, show a text control
                    mytable.push("<form class = 'form-inline form-inline-scale'> <div class='form-group'>");
                    mytable.push("<input type='integer' class='form-control' placeholder='Enter steps' id='steps"+ date_set +"' style='width: 7em;' ></div>");
                    mytable.push("</form>");
                    mytable.push("</td><td data-title='Device'><form class = 'form-inline form-inline-scale'> <div class='form-group'><span id ='methodspan"+ date_set+"' onfocusout='updateMethods(\"method" + date_set + "\")'>");
                    mytable.push(selectMethods("method"+ date_set, give_pref, methods));
                    mytable.push("</span></div></form></td>");
                }
                ///Get stars
                if (parseInt(showtargets) === 1){
                    if ((targetstep!=null)&&(parseInt(targetstep)<= parseInt(stepsread))){
                        mytable.push("<td  data-title='Achieved target' class='text-center' ><span class='glyphicon glyphicon-star logo-small'></span></td>");
                        targetdays= targetdays+1;
                    } else { mytable.push("<td  data-title='Achieved target'  class='text-center'><br></div> </td>");
                    }
                }
                if (stepsread!=null){ //If there is already a step count give option to edit else option to add new
                    mytable.push("<td><input type='button' class='btn btn-default' id='editBtn"+ date_set +"' value='Edit' onclick='editBtnCheck(\"editBtn"+ date_set +"\")'></div></form></td>");
                } else {
                    mytable.push("<td><input type='button' class='btn btn-default' id='saveBtn"+ date_set +"' value='Add' onclick='updateSteps(\"saveBtn"+ date_set +"\", false)';> </div></form></td>");
                }
                mytable.push("</tr>");
            }
        mytable.push("<table>");
        myTableString = mytable.join(" ");
        sendback=[];
        sendback.mytable = myTableString;
        sendback.totalsteps = totalsteps;
        sendback.totaldays = totaldays;
        sendback.targetdays = targetdays;
        sendback.showtargets = showtargets;
        return sendback;
}

function stepsFeedback(week, targetdays, totalsteps, totaldays, daysw, ispast, steps) {
        //targetdays - number of days achieved target
        //total steps - total number of steps
        // total days - total number of days that have readings
        // daysw - number of days in target
        //ispast - this week is not the current week
        // steps - target
        var print=[];
       // print.push("<h3>You can record your step counts here.</h3>");
            if (week === "baseline" || week === "week0" || week === "getweekone"){
                if (steps > 0) {	
                    print.push("<p><b>Your average daily step count ="+ steps +"</b>. This number is your <b>baseline steps</b><br></p><br>");
                    print.push("<p>You will use this number to work out your target in the 12 week programme. In weeks 1-4 you will add 1500 steps to this number and gradually increase the number of days that you do this on. In weeks 5-12 you will add 3000 to this number and again gradually increase the number of days that you do this on.</p>");
                }
            } else {
                //IF not in baseline, give feedback on targets
                    if (targetdays>daysw) {
                       //If they achieved over their target
                        print.push("<p> You have achieved your target on "+ targetdays +" days this week. You were aiming for "+ daysw +" days, well done!");
                    } else if (targetdays === daysw) {	
                        //If they achieved their target
                        print.push("<p> You have achieved your target on "+ targetdays +" days this week, well done!");
                    } else if (targetdays>0 && targetdays<daysw) {
                        //Did not achieve target
                        if (totaldays<(7- daysw + targetdays)){
                        //If did not achieve target yet, but week still has enough time to achieve target
                            if (targetdays > 1) {
                                print.push( "<p> You have achieved your target on "+ targetdays +" days so far this week, well done. See if you can do this on "+ daysw +" days this week");
                            } else { 
                                if (ispast===1) {
                                    //if in the past (shouldn't occur..)
                                    print.push("<p> You achieved your target once on this week, well done.");
                                } else {
                                    //If did not achieve target yet, but week still has enough time to achieve target
                                    print.push("<p> You have achieved your target once so far this week, well done. See if you can do this on "+ daysw +" days this week");
                                }
                            }
                         } else {
                        if (targetdays > 1) {
                            if (ispast === 1) {
                                //If they achieved their target on fewer days than specified and in past
                                    print.push("<p> You achieved your target on "+ targetdays +" days this week, well done.");
                            } else {
                            //If they achieved their target on fewer days than specified and they do not have enough days this week to reach this
                            print.push("<p> You have achieved your target on "+ targetdays +" days this week, well done. See if you can do this on "+ daysw +" days next week");
                            }
                        } else {
                            //If did not achieve target yet, encouragement to achieve it next week
                            print.push("<p> You have achieved your target once this week, well done. See if you can do this on "+ daysw +" days next week");
                        }
                    }
                } else {
                    if (ispast !== 1) {
                        print.push("<p> See if you can achieve your target of "+ steps + " on "+ daysw +" days next week");
                }
            }
        }
    printThis = print.join("\n");
    return printThis;
}
function goBack(week, maxweek, showweek){
    ////This gives the option to view previous weeks (if they have any)
    var print=[];
    if ((week == 'baseline' || week == 'getweek1'|| week == 'delayweek1') == 0){
        print.push("<br><p><b>View your step counts from previous weeks </b></p>");
        print.push(" <form class = 'form-inline'> <div class='form-group'>");
        print.push("<select class='form-control' placeholder='View previous step counts' id='viewSteps' name='viewSteps'>");
        var topshow=parseInt(showweek)+6;
        console.log("topshow " + topshow + showweek);
        if (topshow>maxweek){ 
            topshow=maxweek;
        }
        var baseshow= showweek - 6;
        if (baseshow<0){ 
            baseshow = 0;
        }
        for (x = topshow; x >= baseshow; x--) {
            // if the week is odd, start date is the target date
            // if the week is even, the start date is the target date + 7
            print.push( "<option value ='"+ x +"'>");
            print.push("Week "+ x ) ;
            print.push("</option>");
        }
        print.push("</select></div> <div class='form-group'>");
        print.push( "<button type='button' class='btn btn-default' id='viewPastBtn' onclick='showWeek(true, document.getElementById(\"viewSteps\").value)'> View Steps </button> </div></form>");
    }
    printThis = print.join("\n");
    return printThis;
}
	
function bumpTarget(weekno, newweek) { // allows user to move to next target even if they didn't hit it
    var printThis = "";
    printThis += "<div class='form-group'><p><b>You have been given an extra week to hit the target from week " + weekno + " ";
    printThis += "<button type='button' class='btn btn-default' id='increaseT' onclick=\"javascript:incTarget('"+ newweek +"')\">Click here to move onto the next target</button></div></form></b></p>";
    return printThis;
}
	
function setWeekOne (latest_t, baseline) {
    var print=[];
    console.log(latest_t, baseline);
    print.push("<p>Congratulations, you completed the baseline week. You walked an average of "+ baseline +" steps per day </p>");
    print.push("<p>You should start to increase your steps. Please select a day to begin </p>");		
    print.push("<form class = 'form-inline'> <div class='form-group'>");
    print.push("<select class='form-control' placeholder='Select a date to start' id='setTarget' name='setOneweek'>");
    //date of target should be minimum latest_t+7
    var daystxt = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    var baseline= new Date(latest_t);
    var today = new Date();
    console.log(today);
    var days= Math.floor((today.getTime()-baseline.getTime())/(24*60*60*1000));
    console.log(days);
    for (i = days; i >= 0; i--){
        var thisday=new Date(today.getTime() + ((7-i)*24*60*60*1000));			
        var print_date= forwardsDate(thisday);
        var val_date= valDate(thisday);
        if (i==7){
            print.push("<option selected='selected' value= '"+ val_date +"'> Today");
        } else {
            print.push("<option value= '"+ val_date +"'>"+ daystxt[thisday.getDay()] + " " + print_date );
        }	
        print.push("</option>");
    }
    print.push("</select></div><div class='form-group'> ");
    print.push("<button type ='button' class='btn btn-default' id='onemonthBtn' onclick='updateTarget();'> Set Date</button></div></form>");	
    return print.join("\n");    
}
	
function twelveWeek(){
	
    document.getElementById('getModalHeader').innerHTML= "<h4> Well done! You have completed the PACE-UP Programme </h4>";
    var showMessage=[];
    showMessage.push("<div class = 'row'> <div class = 'col-md-8'>");
    showMessage.push("<p> How did it go? You can click below to see how your walking changed over the past 3 months </p></div>");
    showMessage.push("<div class = 'col-md-4'> <form><div class='form-group'> <button type ='button' class='btn btn-default' id='summaryBtn' onclick='redirect(\"./summary.php\")'>View your progress</button></div></form><br></div></div>");	   
    showMessage.push("<hr><div class = 'row'> <div class = 'col-md-8'> ");
    showMessage.push("<p> If you'd like to carry on, you can continue to use PACE-UP to record your steps and set your own targets </p></div>");
    showMessage.push("<div class = 'col-md-4'><form><div class='form-group'> <button type ='button' class='btn btn-default' id='docont12Btn' onclick='carryOn(true)'> Keep going </button></div></form>");
    showMessage.push("<div class='form-group'> <button type ='button' class='btn btn-default' id='dontcont12Btn' onclick='carryOn(false)' > I'm finished </button></div></form></div><br></div>");
    showMessage.push("<hr><div class = 'row'> <div class = 'col-md-8'> ");
    showMessage.push("<p> Hearing about how the programme may have helped you or how it could do improve helps us to provide a better service </p>");
    showMessage.push("<p> Please fill out our feedback form </p></div>");
    showMessage.push("<div class = 'col-md-4'><form><div class='form-group'> <button type ='button' class='btn btn-default' id='feedbackBtn' onclick='redirect(\"./feedback.php\")'>Give Feedback</button></div></form><br></div></div>");
    var message=showMessage.join("\n");
    //console.log("Message:" + showMessage);
    document.getElementById('method_message').innerHTML= message;
    $('#methodModal').modal('show');
 
}

function drawNoContinue(){
    var myMessage=[];
    myMessage.push("<h3>Now you have finished the twelve weeks of PACE-UP Next Steps</h3>");
    myMessage.push("<p>We've put together a summary of your progress over the PACE-UP Next Steps programme, if you've like to see it, click the button below</p><br>");
    myMessage.push("<form><div class='form-group'> <button type ='button' class='btn btn-default' id='summaryBtn' onclick='redirect(\"./summary.php\")'>View your progress</button></div></form><br>");	   
    myMessage.push("<p> Hearing about how the programme may have helped you or how it could do improve helps us to provide a better service </p>");
    myMessage.push("<p> Please fill out our feedback form </p><br>");
    myMessage.push("<form><div class='form-group'> <button type ='button' class='btn btn-default' id='feedbackBtn' onclick='redirect(\"./feedback.php\")'>Give Feedback</button></div></form><br>");	   
    return myMessage;
}
	
function carryOn(keepgoing){
    data="carryon="+keepgoing;
    console.log(data);
    doXHR('./twelve_continue.php', function(){
        var response=this.responseText;
    }, data);
}