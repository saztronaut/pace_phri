<?php include './template.php';?>
<div class='jumbotron text-center'>
<h1>Set New Target</h1>
</div>
<br><br><div class="container-fluid">
<div id="targets_text"></div>


<form class="form-signin" method="POST" id="target-form">

		<p id="targetNote"></p><br>
		<div class="form-group form-inline" id = "date_div">
		<label for="date_set">Date target begins: </label>
        <input type="text" class="form-control" name="date_set" id="date_set" disabled>
        <span id= "date_set_span"></span>
        </div>
        <div class="form-group form-inline" id = "days_div">
       		<label for="days">Number of days to reach steps target on: </label>
        <button type="button" class = "btn btn-default" onclick="changeTarget('days', '1', 'false', '1', '7')"><span class="glyphicon glyphicon-minus"></span></button>
        <input type="number" class="form-control" placeholder="Days" name="days" id="days" >
        <button type="button" class = "btn btn-default" onclick="changeTarget('days', '1', 'true', '1', '7')"><span class="glyphicon glyphicon-plus"></span></button>
        <span id= "days_span"></span>
        </div>
        <div class="form-group form-inline" id = "steps_div">
        <label for="days">Number steps to walk in a day: </label>
        <button type="button" class = "btn btn-default" onclick="changeTarget('steps', '50', 'false', '50', '30000')"><span class="glyphicon glyphicon-minus"></span></button>
        <input type="number" class="form-control" placeholder="Steps" name="steps" id="steps" >
        <button type="button" class = "btn btn-default" onclick="changeTarget('steps', '50', 'true', '50', '30000')"><span class="glyphicon glyphicon-plus"></span></button>  
        <span id= "steps_span"></span>
        </div>
        <div class="form-group form-inline" id = "go_div">
        <button type="button" class="btn btn-default" onclick='setTarget()'>Set new target</button>
        </div>
        </form>
        </div>
<script src="./dateFunctions.js"></script>
<?php include './footer.php';?>



window.onload= function(){
	getTargetData();
}

// Retrieve next target date
// Retrieve current target steps
// Retrieve current target days
// select control for number of steps
// select control for number of days (1 to 7)

function getTargetData(){
	
	doXHR("./returnWeek.php", function (){
	var response = JSON.parse(this.responseText);
	//console.log(response);	
	//latest_t
	//days
	//steps
	if (response=="0"){
		window.location.assign('./landing_text.php');
	}
	else {
    var days= response["days"];
	var steps= response["steps"];

	var latest_t= new Date(response["latest_t"]);
	var today= new Date();

	document.getElementById("days").value=days;
	document.getElementById("steps").value=steps;
    // earliest target date should be the one on the targetWeekday prior to Date()
    // start from latest_t, count forwards 7 days until > today
    var target_date= new Date();
    // if the latest target was before today
    days_since_target= (today.getTime() - latest_t.getTime())/(24*60*60*1000);
    if (days_since_target>0){
        var days_til_next_target= days_since_target % 7;
        target_date= new Date(today.getTime() + (days_til_next_target *24*60*60*1000));
    }
    else{
        target_date= latest_t;
    // if the latest target was set for today or further in the future, replace it
    }
    var note= "<h3>Set yourself a target beginning on "+ giveDay(target_date) +" "+ forwardsDate(target_date) + "</h3>";
	document.getElementById('targetNote').innerHTML=note;
	document.getElementById('date_set').value=valDate(target_date);   
	
	}}, "username=thisUser");
}

function changeTarget(ctrlID, unit, inc, min, max){
    //ctrlID = controlID, unit = number of units to increase or dec by
    // inc true or false increase or decrease
    // min minimum number to decrease to
    // max maximum number to increase to
	var original = document.getElementById(ctrlID).value;
	var newvar=0;
	if (inc=='true'){
		newvar=parseInt(original)+ parseInt(unit);
		}
	else {
		newvar=parseInt(original)-unit;}
	if (newvar< min || newvar>max){
		document.getElementById(ctrlID).value= original;
		} else{
			document.getElementById(ctrlID).value= newvar;}
	
}

function setTarget(){
	
    var date_set= document.getElementById('date_set').value;
    var days= document.getElementById('days').value;
    var steptarget= document.getElementById('steps').value;	
    data= "date_set="+ date_set + "&days="+ days + "&steptarget="+ steptarget +"&post12=1"; 
    console.log(data);
	doXHR("./updateTarget.php", function (){
    console.log (this.responseText);		
	}, data)
	
}


</script>
