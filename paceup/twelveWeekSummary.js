function updateReminder(keepgoing){

	doXHR('./twelve_continue', function(){
		response=this.responseText;
		
	}, "carryon="+keepgoing);
	
	
}


function drawSummary(){
	   // get the data for the 12 weeks
	   // for each week, get the 
	   doXHR('./summaryTwelve.php', function(){
		   //var response= JSON.parse(this.responseText);
		   var carousel=[];
		   carousel.push('<div id="myCarousel" class="carousel slide" data-ride="carousel">');
		   carousel.push('<ol class="carousel-indicators">');
		   carousel.push('<li data-target="#myCarousel" data-slide-to="0" class="active"></li>');
		   carousel.push('<li data-target="#myCarousel" data-slide-to="1"></li>');
		   carousel.push('<li data-target="#myCarousel" data-slide-to="2"></li>');
		   carousel.push('<li data-target="#myCarousel" data-slide-to="3"></li>');
		   carousel.push('</ol>');
		   carousel.push('  <div class="carousel-inner" role="listbox">');
		   carousel.push('<div class="item active">');
		   carousel.push('<div class = "row"><div class = "col-md-1"> </div>');
		   carousel.push('<div class = "col-md-10"> <p id="total_steps_chart"></p>');
		   carousel.push('<span id="total_steps_text">Your steps should appear here</span></div>');
		   carousel.push('<div class = "col-md-1"> </div></div></div>');
	     carousel.push(getCarouselElement('avg_steps'));
		 carousel.push(getCarouselElement('walk'));
		 carousel.push(getCarouselElement('achieved_d'));
		 carousel.push('</div>');
		 
		 carousel.push(' <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">');
		 carousel.push('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>');
		 carousel.push('<span class="sr-only">Previous</span>');
		 carousel.push('</a>');
		carousel.push('<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">');
		carousel.push('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>');
		carousel.push('<span class="sr-only">Next</span>');
		carousel.push('</a>');
		  carousel.push('</div>');
		 
		 carousel_text= carousel.join("\n");
		 
		 console.log(carousel_text);
		 document.getElementById('carousel_text').innerHTML=carousel_text;

		   
		   var response=this.responseText;
		   var json= JSON.parse(response);
		   var weeks= json['n_weeks'];
		   var total_steps= [];
		   var avg_steps= [];
		   total_steps.push("<div class='well well-inverse'> <h4>In your baseline week (the week before you started to increase walking), you walked " + json['base_total'] +" steps in <b>total</b></h4>");
		   total_steps.push("<h4> Over the 12 weeks of PACE-UP, you recorded your walking on "+ json['total_days'] +" days and took " + json['total_steps'] +" steps</h4></br></br></div>");
		   total_steps_print= total_steps.join("\n");
		   document.getElementById('total_steps_text').innerHTML= total_steps_print;
		   drawChart(response, 'total_steps', "Total number of steps you walked each week", weeks, "total_steps_chart", 'Steps');
		   avg_steps.push("<div class='well well-inverse'><h4>In your baseline week (the week before you started to increase walking), you walked " + json[0]['mean_steps'] +" steps on <b>average</b></h4>");
		   avg_steps.push("<h4> Over the 12 weeks of PACE-UP, you recorded your walking on "+ json['total_days'] +" days and took an average of " + json['total_avg'] +" steps</h4></br></br></div>");
		   avg_steps_print= avg_steps.join("\n");
		   document.getElementById('avg_steps_text').innerHTML= avg_steps_print;
		   drawChart(response, 'mean_steps', "Average number of steps you walked each day", weeks, "avg_steps_chart", 'Steps');
		   //myWalk= drawStar(response, weeks);
		   walk_print= "<div class='well well-inverse'><h4>You added a walk in on "+ json['add_walk'] +" days altogether. Well done! </h4></br></br></div>"
		   document.getElementById('walk_text').innerHTML= walk_print;
		   drawChart(response, 'walk', "On how many days each week did you add a walk?", weeks, "walk_chart", 'Days');
		   //document.getElementById("walk_chart").innerHTML=myWalk;
		   achieved_print= "<div class='well well-inverse'><h4>You achieved your target on "+ json['achieved_d'] +" days and achieved your weekly target on "+ json['achieved_w'] +" weeks during the 12 weeks. Well done! </h4></br></br></div>";
		   document.getElementById('achieved_d_text').innerHTML= achieved_print;
		   drawChart(response, 'achieved_t', "On how many days did you hit your target?", weeks, "achieved_d_chart", 'Days');
		   
	   })
}

function drawStar(response, weeks){
	var summary=JSON.parse(response);	
	var x_data=[];
	var y_data=[];
	var mytext=[];
	mytext.push("<h4>How many times did you add a walk to your day?</h4>");
	for (x=1; x<=weeks; x++){
		console.log(x);
		x_data.push(summary[x]['date']);
		y_data.push(summary[x]['walk']);
		mytext.push("<div class = 'row'><div class = 'col-md-4'>");
	    mytext.push("<p> Week "+ x + ", "+ summary[x]['date'] +" </p></div>");
        mytext.push("<div class = 'col-md-8'>");
        var walk=(summary[x]['walk']);
        console.log(walk);
        if (walk>0){
        	mytext.push("<p>"+ walk + " walks</p>")
        }
     //  for (x=1; x<=walk; x++){
      //  	mytext.push("<span class='glyphicon glyphicon-star logo-small'>");
      //  }}
        mytext.push("</div></div>");

	}
	mystars=mytext.join("\n");
	return mystars;

}

function getCarouselElement(root_name){
	 myarray=[];
	 myarray.push('<div class="item">');
	 myarray.push('<div class = "row">');
	 myarray.push('<div class = "col-md-1"> </div>');
	 myarray.push('<div class = "col-md-10"> <p id="'+ root_name +'_chart"></p>');
	 myarray.push('<span id="'+root_name+'_text">Your steps should appear here</span></div>'); 
	 myarray.push('<div class = "col-md-1"></div></div></div>');
	return myarray.join("\n");
}

function drawChart(response, field, label, weeks, place, my_x){
	//summary is an array of data.
	// field is the field to look at
	// label is the label for the graph
	// weeks is the number of weeks to display
	// place is the place to print the graph
	console.log(response);
	var summary=JSON.parse(response);
	x_data=[];
	y_data=[];
	
	for (x=1; x<=weeks; x++){
		x_data.push(summary[x]['date']);
		y_data.push(summary[x][field]);
	}
	data=getChartdata(x_data, y_data);
	layout=getChartlayout(label, my_x);
    $myBarChart= Plotly.newPlot(place, data, layout);
	
	
}

function getChartdata(x_data, y_data){
	var data = [
		  {
		    x: x_data,
		    y: y_data,
		    type: 'bar',
		    marker: {color: 'rgb(85, 26, 139)'}
		  }
		  
		];
	return data;}

function getChartlayout(label, my_x) {	
	var layout = { 
			  title: label,
			  xaxis: {tickfont: {
			      size: 14,
			      color: 'rgb(107, 107, 107)',
			      exponentformat:'none'
			    }},
			  yaxis: {
			    title: my_x,
			    titlefont: {
			      size: 16,
			      color: 'rgb(107, 107, 107)'
			    },
				      exponentformat:'none',
			    tickfont: {
			      size: 14,
			      color: 'rgb(107, 107, 107)',
			      exponentformat:'none'
			    }
			  }
			 };

return layout;
}