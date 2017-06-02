<?php include './template.php';?>

<br><div class= "container">
<div class= "jumbotron">
<h2>Your progress on PACE-UP Next Steps </h2>
</div></div>
<div class="container-fluid-extrapad"> 
<p id="showAllData"></p>

</div>
<script src="./dateFunctions.js"></script>
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
window.onload = function() {

	doXHR('show_all_steps2.php', function () {
			var $response = this.responseText;
			console.log($response);
			if ($response=="0"){
				document.getElementById("showAllData").innerHTML= "<h4> Whoops, either you are not logged in or you need to finish your first week. Redirecting you...</h4>";
				setTimeout(function() {redirect('./landing_text.php');},2500);
			}
			else {
				drawTables($response);
	
}
	                                   });
}

function drawTables ($response){				
	var json = JSON.parse($response)
	console.log(json);
	targets=json.targets;

	var $print="";
	var showAllData=""

		var stepsNum= targets.length
		//var stepsNum = 6

		for (x=stepsNum; x>=0; x--){

		showAllData+='<div class = "row"> \
		<div class = "col-md-2"> <p id="thisAvg_'+ 2*x +'"></p></div>\
		<div class = "col-md-6"> <span id="thisTable_'+ 2*x +'"></span> </div>\
		<div class = "col-md-4"> <p id="thisAside_'+ 2*x +'"></p></div>\
		</div>';
		if (x>0){

		showAllData+='<div class = "row"> \
		<div class = "col-md-2"> <p id="thisAvg_'+ ((2*x) -1) +'"></p></div>\
		<div class = "col-md-6"> <span id="thisTable_'+ ((2*x) -1) +'"></span> </div>\
		<div class = "col-md-4"> <p id="thisAside_'+ ((2*x) -1) +'"></p></div>\
		</div>';
		}		
		}

		document.getElementById("showAllData").innerHTML=showAllData;	    	
	for (i in targets) {

				
		var isfirst=true;
		var title=false;
	    steps=json.steps[i];
		var date_set= new Date(targets[i].date_set);
		var target_steps= targets[i].steps;
		var days= targets[i].days;
		
		var daystxt = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
		var stepsdta= []; 
		var daysdta= [];


		for (j in steps){	
		var date_set_read = new Date(steps[j].date_set);
		var date_read= new Date(steps[j].date);
		var datediff = (date_read.getTime()-date_set_read.getTime())/(60*60*1000);
	    
		
		if (j==0){
			
		if (i==0){
			var base_steps= targets[i].steps;
			var label="Baseline";
		var message= "You walked on average "+ target_steps + " steps each day this week" ;
		tablehead=drawTableHeader(i);

		}
		else { 
			var label= "Week "+ ((2 * i)-1);
			var message= "Your target was to walk "+ target_steps + " steps on " + days + " days on these weeks" ; 
			tablehead=drawTableHeader(i);
		    } 
	    
        $print= "<h3>"  + label +"</h3>";
	    $print+= "<p>"  + message +"</p>";
	    $print+= tablehead;
	    
	    
	    } else if (isfirst==true && i!=0 && (((date_read.getTime()-date_set_read.getTime())/(60*60*1000*24))>=7)) {
		    //print out the previous week and start again
		var avg= getAvg(stepsdta);
        var showAvg= avg;
        
			$print+= "</table></div>";
			tablehead=drawTableHeader(i);
			var data=getChartdata(daysdta, stepsdta);
			var layout=getChartlayout(label, base_steps, target_steps);


		$myBarChart= Plotly.newPlot('thisAside_'+ ((2*i) -1)  +'', data, layout);
		document.getElementById('thisTable_'+ ((2*i) -1) +'').innerHTML= $print;
		document.getElementById('thisAvg_'+ ((2*i)-1) + '').innerHTML= showAvg;
		// start again
	    	var label= "Week "+ ((2 * i));
			var message= "Your target was to walk "+ target_steps + " steps on " + days + " days on these weeks" ; 
            $print= "<h3>"  + label +"</h3>";
		    $print+= "<p>"  + message +"</p>";
		    $print+= tablehead;
		    isfirst=false; 
		    var stepsdta= []; 
			var daysdta= [];
		    }
	    
           if (Date(steps[j].date_set)==Date(targets[i].date_set)){
            	
            		
            //print day of week
				$print+="<tr> <td>"+ giveDay(date_read) +"</td>";
				daysdta.push(giveDay(date_read)) ;
				// print date
				$print+="<td>"+ forwardsDate(date_read) +"</td>";
				// print steps
				$print+="<td>"+ steps[j].steps +"</td>";
				stepsdta.push(steps[j].steps);
				// print collection method
				$print+="<td>"+ steps[j].method +"</td>";
				// print achieved target
			     if (i==0){              
				$print+="<td></td>";}
			     else{
				     if (parseInt(steps[j].steps)>= parseInt(targets[i].steps)){
					     $print+= "<td><span class='glyphicon glyphicon-star logo-small'></span></td>";} 
				     else{
				$print+="<td></td>";}
            	
                }
                $print+="</tr>"
       
			    }
		     }
		$print+= "</table></div>";
		//get avg
		var avg= getAvg(stepsdta);

        var showAvg= avg;

		data=getChartdata(daysdta, stepsdta);
		layout=getChartlayout(label, base_steps, target_steps);

	$myBarChart= Plotly.newPlot('thisAside_'+ 2*i +'', data, layout);
	document.getElementById('thisAvg_'+ 2*i +'').innerHTML= showAvg;
	document.getElementById('thisTable_'+ 2*i +'').innerHTML= $print;
	
	}
	}

function getChartdata(daysdta, stepsdta){
	var data = [
		  {
		    x: daysdta,
		    y: stepsdta,
		    type: 'bar',
		    marker: {color: 'rgb(85, 26, 139)'}
		  }
		  
		];
	return data;}

function getAvg(array){

	 if (array.length>0){
	var sum = array.reduce(function(a, b) { return Math.round(a) + Math.round(b); });
    var avg = Math.round(sum / array.length);
    var mean= "<h3>Average step count: <br> <b>"+ avg +"</b></h3>"}
	    
	 else { var mean="<h3> No step counts recorded this week</h3>";}
    return mean;
}

function getChartlayout(label, base_steps, target_steps) {	
	var layout = { 
			  title: label,
			  xaxis: {tickfont: {
			      size: 14,
			      color: 'rgb(107, 107, 107)'
			    }},
			  yaxis: {
			    title: 'Steps',
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
			  shapes: [{
		            'type': 'line',
		            'x0': -0.5,
		            'y0': base_steps,
		            'x1': 6.5,
		            'y1': base_steps,
		            'line': {
		                'color': 'rgb(208, 171, 242',
		                'width': 1,
		                'dash': 'dot',
		            }
			        }, {
				  
		            'type': 'line',
		            'x0': -0.50,
		            'y0': target_steps,
		            'x1': 6.5,
		            'y1': target_steps,
		            'line': {
		                'color': 'rgb(0, 0, 0)',
		                'width': 1,
		                'dash': 'dot',
		            }
		        }]
			 };

return layout;
}

function drawTableHeader(i){
	if (i==0){
	var tablehead = "<div class='table'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Collection Method</th><th></th></tr></thead>";}
	else{ var tablehead = "<div class='table'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Collection Method</th><th>Achieved target</th><th></th></tr></thead>";	}
	
}

</script>
