
<!-- -->
<br><div class= "container">
<div class= "jumbotron">
<span id="thisHeader">Your progress on PACE-UP Next Steps </span>
<span id="thisBlurb">Something about the aim of the study from the booklet</span>
</div></div>
<div class="container-fluid"> <div class = "row">
<div class = "col-md-8"> <h2></h2> <span id="thisTable">Your steps should appear here</span> </div>
<div class = "col-md-4"> <p id="thisAside">Message to motivate you should appear here</p></div>
</div></div>
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
			console.log($response);
			if ($response=="0"){
				redirect('./steps.php');
			}
			else {
	
				var json = JSON.parse($response)
						targets=json.targets;

						$print="";
						for (i in targets) {
						    steps=json.steps[i];
							var date_set= new Date(targets[i].date_set);
							var target_steps= targets[i].steps;
							var days= targets[i].days;
							$print+= date_set;
							var isfirst=true;
							
							if (i==0){
								var label="Baseline";
							var message= "You walked on average "+ target_steps + " steps each day this week" ;
									}
							else{ 
								var label= "Week "+ ((2 * i)-1) + " and Week "+ ((2 * i));
								var message= "Your target was to walk "+ target_steps + " steps on " + days + " days on these weeks" ; 
							    }
						    $print+= "<h3>"  + label +"</h3>";
						    $print+= "<p>"  + message +"</p>";
							for (j in steps){	
							var date_set_read = new Date(steps[j].date_set);
                               if (Date(steps[j].date_set)==Date(targets[i].date_set)){
                                var date_read= new Date(steps[j].date);			
										
								                   
                                	$print+= date_read;
                                	
                                    }
                           
								}
							}
						document.getElementById('thisTable').innerHTML= $print;
						
					}

	           
		                                         }
	                                   }
	xhr.send();
}
</script>