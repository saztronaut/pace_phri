<?php include './template.php';?>
<div class= "container">
<div class= "jumbotron">
<h2>Your progress on PACE-UP Next Steps </h2>
</div></div>
<div class="container-fluid">
<br>
<p id="viewPast"></p>
<h4 id='pleaseWait'>Please wait while your step data is retrieved..</h4>
<p id="showSummary"></p>
 
<p id="showAllData"></p>

</div>
<?php include "./footer.php";?>
<script src="./dateFunctions.js"></script>
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>


function getStepData(days){
	console.log("Showing days " + days);
    doXHR('show_all_steps2.php', function () {
        var $response = this.responseText;
        //console.log($response);
        if ($response == "0") {
            document.getElementById("showAllData").innerHTML= "<h4> Whoops, either you are not logged in or you need to finish your first week. Redirecting you...</h4>";
            setTimeout(function() {
            redirect('./landing_text.php');
            },2500);
        } else {
        drawTables($response);
        }
    }, "show_days=" + days);
}

window.onload = function() {

	getStepData(90);
}

function viewPast(startDate, show_days){
    var initial = new Date(startDate);
    var today = new Date();
    var datediff = (today.getTime() - initial.getTime())/(30*24*60*60*1000);
    var months =  Math.ceil(datediff/3);
    var mySelect = [];
    //console.log('3 Months: ' + months);
    //console.log('datediff: ' + datediff);
    //console.log('initial: ' + initial); 

    mySelect.push("<form class = 'form-inline'> <div class='form-group-inline text-center'>");
    mySelect.push("<label for=\"viewSteps\">Showing steps summary for past "+ Math.round(show_days/30) + " months </label>");
    mySelect.push("<select class='form-control' placeholder='View a different time frame' id='viewSteps' name='viewSteps'>");
    for (x = 1; x <= months; x++) {
        //console.log(x);
        mySelect.push( "<option value ='" + (parseInt(x) * 90) + "'>");
        mySelect.push("Show last " + (parseInt(x) * 3) + " months") ;
        mySelect.push("</option>");
    }
    mySelect.push("</select> ");   
    mySelect.push( "<button type='button' class='btn btn-default' id='viewPastBtn' onclick='showSteps()'><span class='glyphicon glyphicon-stats'></span> Show step summary </button></div>");
    printThis = mySelect.join("\n");
    return printThis;
       
}

function showSteps(){
    var show_days = document.getElementById('viewSteps').value
    getStepData(show_days);
	
}

function drawTables ($response) {
    var json = JSON.parse($response);
    //console.log(json);
	targets = json.targets;

	var $print = "";
	var showAllData = "";
    var allLabels = [];
    var allAvg = [];
    var allTargets = [];
    var allBase = [];
    var stepsNum = targets.length;
    var initial = json.initial;
    var show_days = json.show_days;
    var past = viewPast(initial.target, show_days);
    document.getElementById('viewPast').innerHTML = past;
    //var stepsNum = 6

    for (x = stepsNum; x >= 0; x--) {
        showAllData += "<div class = 'row'>";
        showAllData += "<div class = 'col-md-2'> <p id='thisAvg_"+ x +"'></p></div>";
        showAllData += "<div class = 'col-md-5'> <span id='thisTable_"+ x +"'></span> </div>";
        showAllData += "<div class = 'col-md-5'> <p id='thisAside_"+ x +"'></p></div>";
        showAllData += "</div>";
		}

    document.getElementById("showAllData").innerHTML=showAllData;	    	
    for (i in targets) {				
        var isfirst = true;
        var title = false;
        steps = json.steps[i];
        var date_set = new Date(targets[i].date_set);
		var target_steps = targets[i].steps;
		var days = targets[i].days;
	    var daystxt = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	    var stepsdta = []; 
	    var daysdta = [];
	    var basedta = [];
	    var targetsdta = [];
	    var hitTarget = 0;

	    if (targets[i].week == 0) {
            var base_steps = targets[i].steps;
		    if (base_steps === 0){
                var label = "Baseline";
                var message = "Keep recording steps this week to get your baseline";
            } else {
                var label = "Baseline";
                var message = "You walked on average "+ target_steps + " steps each day this week" ;
            }
            var tablehead = "<div class='table'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th class=\"hidden-xs\">Device</th><th></th></tr></thead>";
           
        } else { 
            var label= "Week " + targets[i].week;
            var message= "Your target was to walk "+ target_steps + " steps on " + days + " days during week " + targets[i].week; 
            var tablehead = "<div class='table'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th class=\"hidden-xs\">Device</th><th>Achieved<br> target</th><th></th></tr></thead>";	
        } 
	    
        $print = "<h3>" + label + "</h3>";
	    $print += "<p>" + message + "</p>";
	    $print += tablehead;
	    
		for (j in steps){
           // var date_set_read = new Date(steps[j].date_set);
            var date_read = new Date(steps[j].date);
           // var datediff = (date_read.getTime()-date_set_read.getTime())/(60*60*1000);
		    
		   // if (Date(steps[j].date_set) == Date(targets[i].date_set)) {
                //print day of week
                $print += "<tr> <td>" + giveDay(date_read) + "</td>";
                // print date
                $print += "<td>" + forwardsDate(date_read) + "</td>";
                // print steps
                if (steps[j].steps !== undefined) {
                    $print += "<td>" + steps[j].steps + "</td>";
                    stepsdta.push(steps[j].steps);
                    daysdta.push(giveDay(date_read)) ;				
				     // print collection method				
                    $print += "<td class=\"hidden-xs\">" + steps[j].method + "</td>";
                    // print achieved target
                    if (parseInt(i) === 0){            
                        $print += "<td></td>";
                    } else {
                        if (parseInt(steps[j].steps) >= parseInt(targets[i].steps)) {
                            $print += "<td class='text-center'><span class='glyphicon glyphicon-star logo-small'></span></td>";
                            hitTarget += 1;
					    } else {
                            $print += "<td></td>";
                        }
                    }
            } else {
                stepsdta.push(0);
                daysdta.push(giveDay(date_read)) ;
                $print += "<td colspan='3'><i> Nothing recorded</i></td>" 
            }
            $print += "</tr>";
            basedta.push(base_steps);
            targetsdta.push(parseInt(targets[i].steps));
       // }
    } //end individual step

    if (parseInt(targets[i].totaldays)> 0) {
        var avg = Math.round(parseInt(targets[i].totalsteps)/parseInt(targets[i].totaldays));
        var showAvg = "<h3>Average step count: <br> <b>" + avg + "</b></h3>"   		 
        var tickLabel = label.replace("Week", "Wk");
        tickLabel = tickLabel.replace("Attempt #", "#");
        allLabels.push(tickLabel);
        allAvg.push(avg);
        allTargets.push(parseInt(targets[i].steps));
        allBase.push(base_steps);       
    
        var data=getChartdata(daysdta, stepsdta, basedta, 'Steps', targetsdta);	 
        var layout=getChartlayout(label, 'Steps', 7, 'thisAside_'+ (i) +'');   	
        $print += "</table></div>";
        if (hitTarget >= parseInt(targets[i].days) && (parseInt(i) !== 0 || label!== "Baseline")) {
            showAvg += "<br> <td class='text-center'><span class='glyphicon glyphicon-thumbs-up logo'></span></td><br>"
            showAvg += "<h4>Good work, you hit your weekly target!</h4>"; 
        } else if (parseInt(i) === 0 && (parseInt(targets[i].days)=== 0 || targets[i].days=== null)) {
            showAvg += "<br> <td class='text-center'><span class='glyphicon glyphicon-road logo center-block'></span></td><br>"
            if (parseInt(base_steps) === 0){
                showAvg += "<h4>Good work, you started your baseline week</h4>";
            } else {
                showAvg += "<h4>A great start, you finished your baseline week</h4>";  
            }              
            var data = getChartdata(daysdta, stepsdta, basedta, 'Steps');
        }
		$myBarChart= Plotly.newPlot('thisAside_'+ (i) +'', data, layout);
		document.getElementById('thisTable_'+ (i) +'').innerHTML= $print;
		document.getElementById('thisAvg_'+ (i) + '').innerHTML= showAvg;
	    } else {
            showAvg = "<h3> " + label + "</h3><p> No step counts recorded on week beginning " + forwardsDate(date_set) + "</p>";
            document.getElementById('thisTable_'+ (i) +'').innerHTML = showAvg;
            var tickLabel = label.replace("Week", "Wk");
            tickLabel = tickLabel.replace("Attempt #", "#");
            allLabels.push(tickLabel);			  
            allAvg.push(0);
            allTargets.push(parseInt(targets[i].steps));
            allBase.push(base_steps); 	
        }
	}
    var data = getChartdata(allLabels, allAvg, allBase, 'Average steps', allTargets);
    var layout = getChartlayout("Your progress", 'Average Steps', stepsNum, 'showSummary');
    $myBarChart = Plotly.newPlot('showSummary', data, layout);
    document.getElementById('pleaseWait').innerHTML = "";
}

function getChartdata(daysdta, stepsdta, base_steps, label, allTargets) {
    var data=[];
    var trace1 = {
        x: daysdta,
        y: stepsdta,
        type: 'bar',
        marker: {color: 'rgba(114, 63, 151,1)'},
        name: label 
    };
    var trace3 = {
        x: daysdta,
        y: base_steps,
        type: 'line',
        marker: {color: 'rgba(114, 192, 73,1)',
            dash:'dot'},
        name: 'Baseline Steps'
    };
    if (allTargets !== null && allTargets !== undefined) {
	    var trace2 = {
	        x: daysdta,
	        y: allTargets,
	        type: 'line',
	        marker: {color: 'rgb(165, 133, 188, 1)'},
	        name: 'Daily Steps Target'
        };
        data= [trace1, trace2, trace3];
    } else {
        var data=[trace1, trace3];
    }
    return data;
}

function getChartlayout(label, ylabel, linelength, myElement) {
    // find the width of the container
    var elementWidth = document.getElementById(myElement).offsetWidth;
    var myWidth = elementWidth;
    var legend = "";
    var margin = "";
    if (myWidth < 500){
        legend = {
        		bgcolor: "rgba(255, 255, 255, 0.1)",
                x: 1,
                y: -0.3,
                "orientation": "h"
        };
        margin = {
                l: 70,
                r: 10,
                b: 100
                };
    } else {
        legend = {
        bgcolor: "rgba(255, 255, 255, 0.1)",
        };
        margin = {
                l: 70,
                r: 10,
                };
    }
    
	var layout = {
        title: label,
        xaxis: {tickfont: 
            {
	            size: 14,
                color: 'rgb(107, 107, 107)'
            }
        },
        yaxis: {
            title: ylabel,
            titlefont: {
                size: 16,
                color: 'rgb(107, 107, 107)'
            },
            exponentformat:  'none',
            tickfont: {
                size: 14,
                color: 'rgb(107, 107, 107)'
            }
        },
        showlegend: true,
        margin: margin,
        width: myWidth,
        autosize: false,
        
        legend: legend
            
    };
return layout;
}


</script>
