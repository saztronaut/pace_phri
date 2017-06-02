<?php include './template.php';?>
<div class= "container text-center ">
<div class= "jumbotron">
<h1> PACE-UP - Next Steps</h1>
<p>Your Twelve Week Diary</p>
</div> <!-- jumbotron -->
</div> <!-- container -->
<div class="container-fluid-extrapad">
<div class="row">
<div class="col-sm-5" id="sidebar" class="well sidebar-nav">
<span id="pills"></span>
</div> <!-- well -->
<div class="col-sm-7">
<span id="text"></span>

</div> <!-- main text -->
</div> <!-- row -->
</div>  <!-- container -->
<?php include './footer.php';?>
<script src="./drawHeader.js"></script>
<script>
window.onload = function() {

drawDiary();
}

function showText(week, weekno, comment){
	if (weekno==0){ 
		week="baseline"; 
		comment="";
		console.log(week, weekno, comment)}
	var header = drawHeader2(week, weekno, comment);
	document.getElementById('text').innerHTML= header['thisAside'];
    document.getElementById('link'+weekno).className= "active";
    for (x=0; x<14; x++){
    if (x!=weekno){
        document.getElementById('link'+x).className= "default";
        }
    }
	
	
}

function recordComment(weekno){
	  comment= JSON.stringify(document.getElementById('comment'+weekno).value);
	  if (comment!=''){
	  data="weekno="+ weekno +"&comment=" + comment;
	  console.log(data);
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", 'addComment.php', true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.send(data);	
	  xhr.onreadystatechange=function(){
	  if(xhr.readyState == 4 && xhr.status ==200){
		  var $response = xhr.responseText;
		  console.log($response);
		  if ($response==1){
		  document.getElementById('form'+weekno).className= "form-group has-success";	
		  
	  }	   else {
	  document.getElementById('form'+weekno).className= "form-group";	}
	  }
	  }
	  }
}


function drawDiary (){
//get array from server with all the comments. Array should be 0-13, with comments if exist
	var xhr = new XMLHttpRequest();
	xhr.open("POST", 'get_comments.php', true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var comments= [];
	xhr.onreadystatechange = function () {
		if(xhr.readyState == 4 && xhr.status ==200){
			var $response = xhr.responseText;
			console.log($response);
			if ($response=="0"){
				document.getElementById("pills").innerHTML= "<h4> Whoops, you need to be logged in to look at your diary! Redirecting you</h4>";
				setTimeout(function() {redirect('./landing_text.php');},2500);
			}
			else {
	// for each value in the array loop through and draw the respective html code
				var comments = JSON.parse($response)
				console.log(comments);
				pills='<ul class="nav nav-pills nav-stacked">';
				text="";
				for (i in comments){
						var week= "week"+i;
						var weekno=i;
						var comment = comments[i]
						if (comment==null){comment="";}
						
				        var header = drawHeader2(week, weekno, comment);
				        if (i==0){document.getElementById('text').innerHTML= header['thisAside'];
				        pills += '<li class="active" id="link0"> <a href="#" onclick=\'showText("'+ week +'",'+ weekno+',"' + comment +'")\'><b> Week '+i +' - ' + header['thisTitle']+'</b> </a></li>';
				        }	
				        else{
				        pills += '<li  id="link'+ weekno +'"> <a href="#" onclick=\'showText("'+ week +'",'+ weekno+',"' + comment +'")\'><b> Week '+i +' - ' + header['thisTitle']+'</b> </a></li>';
				        }    					

					}
				pills+= "</ul>";
				document.getElementById("pills").innerHTML= pills;

			}
		}
	}
	xhr.send();

	 
 }
</script>



