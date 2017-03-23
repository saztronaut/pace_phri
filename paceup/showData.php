<br><div class= "container">
<div class= "jumbotron">
<br><h2>Your details </h2>
</div></div>
<div class="container-fluid-extrapad"> 
<div class = "row">
<div class = "col-md-1 col-sm-1"> </div>
<div class = "col-md-7 col-sm-8"><p id="firstCol"></p></div>
<div class = "col-md-3 col-sm-2"> <span id="secondCol"></span> </div>
<div class = "col-md-1 col-sm-1"> <p id="thirdCol"></p></div>
</div>
</div>

<script>
window.onload = function() {
	doXHR('get_my_data.php', function () {
			var $response = this.responseText;
			console.log($response);
			if ($response=="0"){
				redirect('./landing_text.php');
			}
			else {
	
				var jsonp = JSON.parse($response);
				var json= jsonp[0];
				
				if (json==0){}
				else{//print data
					print=[];
					print.push("<table>");
					print.push("<tr><td><p><b>First name:</b></p></td><td><span id='forename'> "+ json['forename']+ "</span></td><td>"); 
					print.push("<div class='form-group'>");
					print.push("<button type='button' class='btn btn-default' id='forenameBtn' onclick='edit(\"forename\", \""+json['forename']+"\")'> Edit </button> </div></form></td></tr>");
					print.push( "<tr><td><p><b>Last name: </b></p></td><td><p>"+ json['lastname']+ "</p></td><td>");
					print.push("<div class='form-group'>");
					print.push("<button type='button' class='btn btn-default' id='lastnameBtn' onclick='edit(\"lastname\", \""+json['lastname']+"\")'> Edit </button> </div></form></td></tr>");
					print.push("<tr><td><p><b>Email: </b></p></td><td><p>"+ json['email']+ "</p></td><td>");
					print.push("<div class='form-group'>");
					print.push("<button type='button' class='btn btn-default' id='emailBtn' onclick='edit(\"email\", \""+json['email']+"\")'> Edit </button> </div></form></td></tr>");				
					print.push("<tr><td><p><b>Practice Name: </b></p></td><td><p>"+ json['practice_name']+ "</p></td><td>");
					print.push("<tr><td><p><b>Start date: </b></p></td><td><p>"+ json['start_date']+ "</p></td><td></td></tr>");
					if (json['method_name']=="Other"){
						print.push("<tr><td><p><b>Preferred step counter: </b></p></td><td><p> "+ json['other_method']+ "</p></td><td></td></tr>");
						}
					else{
						print.push("<tr><td><p><b>Preferred step counter: </b></p></td><td><p> "+ json['method_name']+ "</p></td><td></td></tr>");						
						}
					print.push("<tr><td><p><b>Gender: </b></p></td><td><p> "+ json['gender']+ "</p></td><td></td></tr>");
					print.push("<tr><td><p><b>Ethnicity: </b></p></td><td><p> "+ json['ethnicity']+ "</p></td><td></td></tr>");
					print.push("<tr><td><p><b>Age: </b></p></td><td><p>"+ json['age']+ "</p></td><td></td></tr></table>");
					getprint=print.join("");

					document.getElementById('firstCol').innerHTML= getprint;
					//document.getElementById('secondCol').innerHTML= print2;
						
						}}
	                    });
}

function edit(control, input){

     var editData="<form class = 'form-inline'> <div class='form-group'><input type='text' class='form-control' id='new"+ control +"' style='width: 12em' placeholder="+ input +"></input</div></form>";
     document.getElementById('forename').innerHTML= editData;
	
}
</script>
