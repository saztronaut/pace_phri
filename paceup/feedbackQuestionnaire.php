<?php include './template.php';?>
<br><br><div class="container-fluid-extraextrapad">


<h2 class="form-signin-heading">Feedback for PACE-UP Next Steps</h2><hr />
<form class="form " method="POST" action="./addQuestions.php" id="questions">

 <p id="myquestionnaire"></p>
 
<span id="question_form"></span>



</form>

</div>
<?php include './footer.php';?>
<script>
window.onload = checkQuest();

function checkQuest() {
    doXHR('./checkQuest.php', function() {
        var response = this.responseText
        if (parseInt(response) === 1 ) {
            loadQuestionnaire();
        } else if (parseInt(response) ===2 ) {
        	loadQuestionnaire();
        	document.getElementById('myquestionnaire').innerHTML = "<p> Thank you for filling out our feedback survey!</p>";
            //window.location.assign("./steps2.php");
        } else if (parseInt(response) === 0) {
        	document.getElementById('myquestionnaire').innerHTML = "<p> You are not logged in, <a href= \"./main_index.php\">please sign in</a>";
        //window.location.assign("./main_index.php");
        } else if (parseInt(response) === 3) {
        	document.getElementById('myquestionnaire').innerHTML = "<p> You haven't finished the 12 weeks program yet, hold on!</a>";
            //window.location.assign("./main_index.php");
            }
    }, 0);
    
}

function loadQuestionnaire(){
    var quest = [];	
    quest.push("<div class = \"row text-left\"><div class = \"col-md-6\">");
    quest.push("<div class=\"form-group\" id = \"increase_pa_div\">");
    quest.push("<label for=\"increase_pa\">Do you think using the app/website helped increase your physical activity?:</label>");
    quest.push("<label class=\"radio\"><input type=\"radio\" value=\"1\" name=\"increase_pa\">Yes</label>");
    quest.push("<label class=\"radio\"><input type=\"radio\" value=\"0\" name=\"increase_pa\">No</label>");
    quest.push("<label class=\"radio\"><input type=\"radio\"  value=\"2\" name=\"increase_pa\">Not Sure</label>");
    quest.push("</div>");
    quest.push("<div class=\"form-group\" id = \"inc_pa_comment_div\">");
    quest.push("<label for=\"inc_pa_comment\"> Any other comments: </label>");
    quest.push("<input type=\"text\" class=\"form-control\" placeholder=\"Comment here\" id=\"inc_pa_comment\" >");
    quest.push("<span id= \"inc_pa_comment_span\"></span></div>");
    quest.push("<div class=\"form-group\" id = \"use_app_div\">");
    quest.push("<label for=\"app_used\">When using PACE-UP Next Steps online, did you:</label>");
    quest.push("<label class=\"radio\"><input type=\"radio\" value=\"M\" name=\"app_used\">Mostly use the mobile application</label>");
    quest.push("<label class=\"radio\"><input type=\"radio\" value=\"W\" name=\"app_used\">Mostly use the website</label>");
    quest.push("<label class=\"radio\"><input type=\"radio\"  value=\"MW\" name=\"app_used\">Use both the mobile and web application</label>");
    quest.push("</div>");
    quest.push("<div class=\"form-group\" id = \"use_app_comment_div\">");
    quest.push("<label for=\"use_app_comment\"> Please give any reasons you have for this choice: </label>");
    quest.push("<input type=\"text\" class=\"form-control\" placeholder=\"Comment here\" id=\"use_app_comment\" >");
    quest.push("<span id= \"use_app_comment_span\"></span>");
    quest.push("</div>");
    quest.push("<p><b>Please rate the following features of the app/ website out of 5 stars </b></p>");
    quest.push("<p><i>Where 5 stars is the best rating you could give and 0 stars is the worst</i></p>");
		

	var myQuestionnaire = fiveStars('look_and_feel', 'Look and Feel');
	var printThis = quest.join("\n");
	printThis += myQuestionnaire.join("\n");

	myQuestionnaire = fiveStars('userbility', 'User friendliness');
	printThis += myQuestionnaire.join("\n");
	
	myQuestionnaire = fiveStars('functionality', 'Functionality');
	printThis += myQuestionnaire.join("\n");

	myQuestionnaire = fiveStars('content', 'Content');
	printThis += myQuestionnaire.join("\n");
	myQuestionnaire = fiveStars('navigation', 'Navigation');
	printThis += myQuestionnaire.join("\n");

	var quest2 = [];
    quest2.push("</div>");
    quest2.push("<div class = \"col-md-6\">");
    quest2.push("<div class=\"form-group\" id = \"problems_div\">");
    quest2.push("<label for=\"problems\"> Whilst using the app, did you experience any of these problems? (select all that apply): </label>");
    quest2.push("<div class=\"checkbox\">");
    quest2.push("<label><input type=\"checkbox\" value=\"1\" id=\"download\">The app was difficult to download</label></div>");
    quest2.push("<div class=\"checkbox\">");
    quest2.push("<label><input type=\"checkbox\" value=\"1\" id=\"bugs\">I experienced bugs or technical difficulties</label></div>");
    quest2.push("<div class=\"checkbox\">");
    quest2.push("<label><input type=\"checkbox\" value=\"1\" id=\"confusing\">The app was confusing to use</label></div>");
    quest2.push("<div class=\"checkbox\">");
    quest2.push("<label><input type=\"checkbox\" value=\"1\" id=\"battery\">The app drained my battery</label></div>");
    quest2.push("<div class=\"checkbox\">");
    quest2.push("<label><input type=\"checkbox\" value=\"1\" id=\"slow_app\">The app was slow</label></div>");
    quest2.push("<div class=\"checkbox\">");
    quest2.push("<label><input type=\"checkbox\" value=\"1\" id=\"visual\">The app was not visually appealing</label></div>");
    quest2.push("<div class=\"checkbox\">");
    quest2.push("<label><input type=\"checkbox\" value=\"1\" id=\"missing\">The app had missing features</label></div>");
    quest2.push("</div>");
    quest2.push("<br>");
    quest2.push("<div class=\"form-group \" id = \"recommend_div\">");
    quest2.push("<label for=\"recommend\">Would you recommend this app to a friend? </label>");
    quest2.push("<label class=\"radio\"><input type=\"radio\" value=\"1\" name=\"recommend\">Yes</label>");
    quest2.push("<label class=\"radio\"><input type=\"radio\" value=\"0\" name=\"recommend\">No</label>");
    quest2.push("<label class=\"radio\"><input type=\"radio\"  value=\"2\" name=\"recommend\">Not Sure</label>");
    quest2.push("</div>  ");
    quest2.push("<div class=\"form-group\" id = \"improve_div\">");
    quest2.push("<label for=\"improvement\"> Any other comments: </label>");
    quest2.push("<input type=\"text\" class=\"form-control\" placeholder=\"Comment here\" id=\"improvement\" >");
    quest2.push("</div>");
    quest2.push("<div class=\"form-group\">");
    quest2.push("<button type=\"button\" class=\"btn btn-default\" onclick=\"submitQ()\"> Submit questionnaire </button></div>");
    quest2.push("</div></div>");
	printThis +=  quest2.join("\n");
	document.getElementById("myquestionnaire").innerHTML= printThis;

}

function submitQ(){
    var form = document.getElementById("questions");
    var data = $(form).serialize();
    var data = data + "&inc_pa_comment=" + document.getElementById("inc_pa_comment").value;
    var data = data + "&use_app_comment=" + document.getElementById("use_app_comment").value;
    var data = data + "&improvement=" + document.getElementById("improvement").value;console.log(data);
    doXHR('./addQuestionnaire.php', function(){
        var response = this.responseText
        if (parseInt(response) === 1 ) {
            document.getElementById('myquestionnaire').innerHTML = "<p> Thank you for filling out our feedback survey!</p>";
        }
    },  data);
}

function fiveStars(ctrlname, label){
	
    var myQuestion = [];
    myQuestion.push("<div class='form-group row' id = '" + ctrlname + "_div'><div class='col-xs-4'>");
    myQuestion.push("<label for='look_and_feel'>" + label + ":</label></div>");
    myQuestion.push("<div class='col-xs-8'><label class='radio-inline'><input type='radio' value='0' name='" + ctrlname + "'>0</label>");
    myQuestion.push("<label class='radio-inline'><input type='radio' value='1' name='" + ctrlname + "'>1</label>");
	myQuestion.push("<label class='radio-inline'><input type='radio'  value='2' name='" + ctrlname + "'>2</label>");
	myQuestion.push(" <label class='radio-inline'><input type='radio' value='3' name='" + ctrlname + "'>3</label>");
	myQuestion.push(" <label class='radio-inline'><input type='radio'  value='4' name='" + ctrlname + "'>4</label>");
	myQuestion.push("<label class='radio-inline'><input type='radio'  value='5' name='" + ctrlname + "'>5</label>");
	myQuestion.push(" </div></div> ");
	return myQuestion; 
	
}

</script>