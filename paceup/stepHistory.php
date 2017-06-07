<?php include './template.php';?>

<br><div class= "container">
<div class= "jumbotron">
<h2>Your progress on PACE-UP Next Steps </h2>
</div></div>
<div class="container-fluid-extrapad">
<h4 id='pleaseWait'>Please wait while your step data is retrieved..</h4>
<p id="showSummary"></p>
 
<p id="showAllData"></p>

</div>
<script src="./dateFunctions.js"></script>
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
window.onload = function() {
    doXHR('show_all_steps2.php', function () {
        var $response = this.responseText;
        console.log($response);
        if ($response == "0") {
            document.getElementById("showAllData").innerHTML= "<h4> Whoops, either you are not logged in or you need to finish your first week. Redirecting you...</h4>";
            setTimeout(function() {
            redirect('./landing_text.php');
            },2500);
        } else {
        drawTables($response);
        }
    });
}

function drawTables ($response) {
    var json = JSON.parse($response);
    //console.log(json);
	targets=json.targets;

	var $print="";
	var showAllData="";
    var allLabels=[];
    var allAvg=[];
    var allTargets=[];
    var allBase=[];
    var stepsNum= targets.length;
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

	    if (i == 0) {
            var base_steps = targets[i].steps;
            var label = "Baseline";
            var message = "You walked on average " + target_steps + " steps each day this week" ;
            var tablehead = "<div class='table'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Device</th><th></th></tr></thead>";
        } else { 
            var label= "Week " + targets[i].week;
            var message= "Your target was to walk "+ target_steps + " steps on " + days + " days during week " + targets[i].week; 
            var tablehead = "<div class='table'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Device</th><th>Achieved<br> target</th><th></th></tr></thead>";	
        } 
	    
        $print = "<h3>" + label + "</h3>";
	    $print += "<p>" + message + "</p>";
	    $print += tablehead;
	    
		for (j in steps){	
            var date_set_read = new Date(steps[j].date_set);
            var date_read = new Date(steps[j].date);
            var datediff = (date_read.getTime()-date_set_read.getTime())/(60*60*1000);
		    
		    if (Date(steps[j].date_set) == Date(targets[i].date_set)) {
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
                    $print += "<td>" + steps[j].method + "</td>";
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
        }
    } //end individual step

    if (parseInt(targets[i].totaldays)> 0) {
        var avg = Math.round(parseInt(targets[i].totalsteps)/parseInt(targets[i].totaldays));
        var showAvg = "<h3>Average step count: <br> <b>" + avg + "</b></h3>"   		 
        allLabels.push(label);
        allAvg.push(avg);
        allTargets.push(parseInt(targets[i].steps));
        allBase.push(base_steps);       
    
        var data=getChartdata(daysdta, stepsdta, basedta, 'Steps', targetsdta);	 
        var layout=getChartlayout(label, 'Steps', 7);   	
        $print += "</table></div>";
        if (hitTarget >= parseInt(targets[i].days) && parseInt(i) !== 0) {
            showAvg += "<br> <td class='text-center'><span class='glyphicon glyphicon-thumbs-up logo'></span></td><br>"
            showAvg += "<h4>Good work, you hit your weekly target!</h4>"; 
        } else if (parseInt(i) === 0) {
            showAvg += "<br> <td class='text-center'><span class='glyphicon glyphicon-road logo center-block'></span></td><br>"
            showAvg += "<h4>A great start, you finished your baseline week</h4>";
            var data = getChartdata(daysdta, stepsdta, basedta, 'Steps');
        }
		$myBarChart= Plotly.newPlot('thisAside_'+ (i) +'', data, layout);
		document.getElementById('thisTable_'+ (i) +'').innerHTML= $print;
		document.getElementById('thisAvg_'+ (i) + '').innerHTML= showAvg;
	    } else {
            showAvg = "<h3> " + label + "</h3><p> No step counts recorded on week beginning " + forwardsDate(date_set) + "</p>";
            document.getElementById('thisTable_'+ (i) +'').innerHTML = showAvg;
            allLabels.push(label);			  
            allAvg.push(0);
            allTargets.push(parseInt(targets[i].steps));
            allBase.push(base_steps); 	
        }
	}
    var data = getChartdata(allLabels, allAvg, allBase, 'Average steps', allTargets);
    var layout = getChartlayout("Your progress", 'Average Steps', stepsNum);
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

function getChartlayout(label, ylabel, linelength) {
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
        }
    };
return layout;
}
</script>
