
<!-- -->
<br><div class= "container">
<div class= "jumbotron">
<h2>Your progress on PACE-UP Next Steps </h2>
</div></div>
<div class="container-fluid-extrapad"> 
<div class = "row">
<div class = "col-md-2"> <p id="thisAvg_0"></p></div>
<div class = "col-md-6"> <span id="thisTable_0">Your steps should appear here</span> </div>

<div class = "col-md-4"> <p id="thisAside_0"></p></div>
</div>
 <div class = "row">
 <div class = "col-md-2"> <p id="thisAvg_1"></p></div>
<div class = "col-md-6"><span id="thisTable_1"></span> </div>

<div class = "col-md-4"> <p id="thisAside_1"></p></div>
</div>
 <div class = "row">
 <div class = "col-md-2"> <p id="thisAvg_2"></p></div>
<div class = "col-md-6"> <span id="thisTable_2"></span> </div>

<div class = "col-md-4"> <p id="thisAside_2"></p></div>
</div>
 <div class = "row">
 <div class = "col-md-2"> <p id="thisAvg_3"></p></div>
<div class = "col-md-6"> <span id="thisTable_3"></span> </div>
<div class = "col-md-4"> <p id="thisAside_3"></p></div>
</div>
 <div class = "row">
 <div class = "col-md-2"> <p id="thisAvg_4"></p></div>
<div class = "col-md-6"> <span id="thisTable_4"></span> </div>
<div class = "col-md-4"> <p id="thisAside_4"></p></div>
</div>
 <div class = "row">
 <div class = "col-md-2"> <p id="thisAvg_5"></p></div>
<div class = "col-md-6"> <span id="thisTable_5"></span> </div>
<div class = "col-md-4"> <p id="thisAside_5"></p></div>
</div>
 <div class = "row">
 <div class = "col-md-2"> <p id="thisAvg_6"></p></div>
<div class = "col-md-6"> <span id="thisTable_6"></span> </div>
<div class = "col-md-4"> <p id="thisAside_6"></p></div>
</div>
 <div class = "row">
<div class = "col-md-7"> <span id="thisTable_7"></span> </div>
<div class = "col-md-5"> <p id="thisAside_7"></p></div>
</div>
 <div class = "row">
<div class = "col-md-7"> <span id="thisTable_8"></span> </div>
<div class = "col-md-5"> <p id="thisAside_8"></p></div>
</div>
 <div class = "row">
<div class = "col-md-7"> <span id="thisTable_9"></span> </div>
<div class = "col-md-5"> <p id="thisAside_9"></p></div>
</div>
 <div class = "row">
<div class = "col-md-7"> <span id="thisTable_10"></span> </div>
<div class = "col-md-5"> <p id="thisAside_10"></p></div>
</div>
 <div class = "row">
<div class = "col-md-7"> <span id="thisTable_11"></span> </div>
<div class = "col-md-5"> <p id="thisAside_11"></p></div>
</div>
 <div class = "row">
<div class = "col-md-7"> <span id="thisTable_12"></span> </div>
<div class = "col-md-5"> <p id="thisAside_12"></p></div>
</div>
</div>
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
window.onload = function() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", 'show_all_steps.php', true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var targets= [];
	var steps= [];
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status ==200){
			var $response = xhr.responseText;
			//console.log($response);
			if ($response=="0"){
				redirect('./steps.php');
			}
			else {
	
				var json = JSON.parse($response)
						targets=json.targets;

						$print="";
						
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
							var tablehead = "<div class='table'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Collection Method</th><th></th></tr></thead>";

							}
							else { 
								var label= "Week "+ ((2 * i)-1);
								var message= "Your target was to walk "+ target_steps + " steps on " + days + " days on these weeks" ; 
								var tablehead = "<div class='table'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Collection Method</th><th>Achieved target</th><th></th></tr></thead>";	
							    } 
						    
                            $print= "<h3>"  + label +"</h3>";
						    $print+= "<p>"  + message +"</p>";
						    $print+= tablehead;
						    
						    
						    } else if (isfirst==true && i!=0 && (((date_read.getTime()-date_set_read.getTime())/(60*60*1000*24))>=7)) {
							    //print out the previous week and start again
							var avg= getAvg(stepsdta);
                            var showAvg= "<h3>Average step count: <br> <b>"+ avg +"</b></h3>";
                            
								$print+= "</table></div>";
								var data=getChartdata(daysdta, stepsdta);
								var layout=getChartlayout(label, base_steps, target_steps);


							$myBarChart= Plotly.newPlot('thisAside_'+ ((2*i) -1)  +'', data, layout);
							document.getElementById('thisTable_'+ ((2*i) -1) +'').innerHTML= $print;
							document.getElementById('thisAvg_'+ ((2*i)-1) + '').innerHTML= showAvg;
							// start again
						    	var label= "Week "+ ((2 * i));
								var message= "Your target was to walk "+ target_steps + " steps on " + days + " days on these weeks" ; 
								var tablehead = "<div class='table'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Collection Method</th><th>Achieved target</th><th></th></tr></thead>";	
	                            $print= "<h3>"  + label +"</h3>";
							    $print+= "<p>"  + message +"</p>";
							    $print+= tablehead;
							    isfirst=false; 
							    var stepsdta= []; 
								var daysdta= [];
							    }
						    
                               if (Date(steps[j].date_set)==Date(targets[i].date_set)){
                                	
                                		
                                //print day of week
									$print+="<tr> <td>"+ daystxt[date_read.getDay()] +"</td>";
									daysdta.push(daystxt[date_read.getDay()]) ;
									// print date
									$print+="<td>"+ date_read.getDate() +" - "+ (date_read.getMonth()+1) +" - " + date_read.getFullYear() +"</td>";
									// print steps
									$print+="<td>"+ steps[j].steps +"</td>";
									stepsdta.push(steps[j].steps);
									// print collection method
									$print+="<td>"+ steps[j].method +"</td>";
									// print achieved target
								     if (i==0){              
									$print+="<td></td>";}
								     else{
									     if (steps[j].steps>= target_steps){
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

                            var showAvg= "<h3>Average step count: <br> <b>"+ avg +"</b></h3>";

							data=getChartdata(daysdta, stepsdta);
							layout=getChartlayout(label, base_steps, target_steps);


						$myBarChart= Plotly.newPlot('thisAside_'+ 2*i +'', data, layout);
						document.getElementById('thisAvg_'+ 2*i +'').innerHTML= showAvg;
						document.getElementById('thisTable_'+ 2*i +'').innerHTML= $print;
						
						}}
	                                   }}
	xhr.send();
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

	var sum = array.reduce(function(a, b) { return Math.round(a) + Math.round(b); });
    var avg = Math.round(sum / array.length);
    return avg;
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
</script>
