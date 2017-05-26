<?php include './template.php';?>
<br><br><div class="container-fluid-extraextrapad">


<h2 class="form-signin-heading">Feedback for PACE-UP Next Steps</h2><hr />
<form class="form " method="POST" action="./addQuestions.php" id="questions">
<div class = "row text-left"><div class = "col-md-6">
 <div class="form-group" id = "increase_pa_div">
 <label for="increase_pa">Do you think using the app/website helped increase your physical activity?:</label>
  <label class="radio"><input type="radio" value="1" name="increase_pa">Yes</label>
 <label class="radio"><input type="radio" value="0" name="increase_pa">No</label>
 <label class="radio"><input type="radio"  value="2" name="increase_pa">Not Sure</label>
  </div>  
      <div class="form-group" id = "inc_pa_comment_div">
      <label for="inc_pa_comment"> Any other comments: </label>
        <input type="text" class="form-control" placeholder="Comment here" id="inc_pa_comment" >
        <span id= "inc_pa_comment_span"></span>
        </div>

<p><b>Please rate the following features of the app/ website out of 5 stars </b></p>
<p><i>Where 5 stars is the best rating you could give and 0 stars is the worst</i></p>

  <p id="myquestionnaire"></p>
  </div>
  <div class = "col-md-6">
   <div class="form-group" id = "problems_div">
      <label for="problems"> Whilst using the app, did you experience any of these problems?: </label>
  <div class="checkbox">
  <label><input type="checkbox" value="1" id="download">The app was difficult to download</label></div>
  <div class="checkbox">
  <label><input type="checkbox" value="1" id="bugs">I experienced bugs or technical difficulties</label></div>
    <div class="checkbox">
  <label><input type="checkbox" value="1" id="confusing">The app was confusing to use</label></div>
    <div class="checkbox">
  <label><input type="checkbox" value="1" id="battery">The app drained my battery</label></div>
    <div class="checkbox">
  <label><input type="checkbox" value="1" id="slow_app">The app was slow</label></div>
    <div class="checkbox">
  <label><input type="checkbox" value="1" id="visual">The app was not visually appealing</label></div>
    <div class="checkbox">
  <label><input type="checkbox" value="1" id="missing">The app had missing features</label></div>
  </div>
<br>
 <div class="form-group " id = "recommend_div">
 <label for="recommend">Would you recommend this app to a friend? </label>
  <label class="radio"><input type="radio" value="1" name="recommend">Yes</label>
 <label class="radio"><input type="radio" value="0" name="recommend">No</label>
 <label class="radio"><input type="radio"  value="2" name="recommend">Not Sure</label>
  </div>  
  <div class="form-group" id = "improve_div">
      <label for="improve"> Any other comments: </label>
        <input type="text" class="form-control" placeholder="Comment here" id="improve" >
        </div>
<div class="form-group">
<button type="button" class="btn btn-default" onclick="submitQ()"> Submit questionnaire </button></div>
</div>
<span id="question_form"></span>
</div>


</form>

</div>
<?php include './footer.php';?>
<script>
window.onload = loadQuestionnaire();

function loadQuestionnaire(){

	var myQuestionnaire= fiveStars('look_and_feel', 'Look and Feel');
	printThis= myQuestionnaire.join("\n");

	myQuestionnaire= fiveStars('usability', 'User friendliness');
	printThis+= myQuestionnaire.join("\n");
	
	myQuestionnaire= fiveStars('functionality', 'Functionality');
	printThis+= myQuestionnaire.join("\n");

	myQuestionnaire= fiveStars('contect', 'Content');
	printThis+= myQuestionnaire.join("\n");
	myQuestionnaire= fiveStars('navigation', 'Navigation');
	printThis+= myQuestionnaire.join("\n");
	
	document.getElementById("myquestionnaire").innerHTML= printThis
}

function submitQ(){


	
}

function fiveStars(ctrlname, label){
	
    myQuestion=[];
    myQuestion.push("<div class='form-group row' id = '"+ ctrlname +"_div'><div class='col-xs-4'>");
    myQuestion.push("<label for='look_and_feel'>"+ label +":</label></div>");
   myQuestion.push("<div class='col-xs-8'><label class='radio-inline'><input type='radio' value='0' name='"+ ctrlname +"'>0</label>");
    myQuestion.push("<label class='radio-inline'><input type='radio' value='1' name='"+ ctrlname +"'>1</label>");
	myQuestion.push("<label class='radio-inline'><input type='radio'  value='2' name='"+ ctrlname +"'>2</label>");
	myQuestion.push(" <label class='radio-inline'><input type='radio' value='3' name='"+ ctrlname +"'>3</label>");
	myQuestion.push(" <label class='radio-inline'><input type='radio'  value='4' name='"+ ctrlname +"'>4</label>");
	myQuestion.push("<label class='radio-inline'><input type='radio'  value='5' name='"+ ctrlname +"'>5</label>");
	myQuestion.push(" </div></div> ");
	return myQuestion; 
	
}

</script>