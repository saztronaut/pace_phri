<br><br><div class="container-fluid text-center">


<h2 class="form-signin-heading">Update consent data</h2><hr />
<form class="form form-inline" method="POST" action="./updateQuestions.php" id="questions">

<span id="question_form"></span>
</form>

</div>
<script>

// look up the questions table
// for each field, display editing row. 

  window.onload = getQuestions();

  function getQuestions(){

	  doXHR('./getQuestions.php', function(){
	   var mytable=[];
	   mytable.push("<div class='table'> <table class='table table-plain'><thead><tr><th>Field name</th><th> Question</th><th>Show this?</th><th>Show at finish?</th><th></th></thead></tr>");
       var response= this.responseText;
       if (response==0){
           // there are no values in the questions table
           }
       else {
        var json= JSON.parse(response);
        for (i in json){
            //field, question, show this, finish
            mytable.push("<tr><td><span id='field_"+ json['field']+ "'>"+ json['field']+ "</span></td>");
            mytable.push("<td><span id='question_"+ json['field']+ "'>"+ json['question']+ "</span></td>");
            mytable.push("<td><span id='show_this_"+ json['field']+ "'>"+ json['show_this']+ "</span></td>");
            mytable.push("<td><span id='finish_"+ json['field']+ "'>"+ json['finish']+ "</span></td>");
            mytable.push("<td><input type='button' class='btn btn-default' id='editBtn"+ json['field'] +"' value='Edit'></div></td></tr>");
            }
           }
	   mytable.push("<tr><form class = 'form-inline'> ");
	   mytable.push("<td><div class='form-group'><input type='text' class='form-control' placeholder='Field' id='field_new' style='width: 15em' ></div></td>");
	   mytable.push("<td><div class='form-group'><input type='text' class='form-control' placeholder='Question' id='question_new' style='width: 35em' ></div></td>");  
	   mytable.push("<td><div class='form-group'><input type='checkbox' class='form-control' id='show_this_new' style='width: 7em' ></div></td>");  
	   mytable.push("<td><div class='form-group'><input type='checkbox' class='form-control' id='finish_new' style='width: 7em' ></div></td>");  
       mytable.push("<td><input type='button' class='btn btn-default' id='addBtn_new' value='Add'></div></td></tr></form></table></div>");
       show_table=mytable.join("\n");
       document.getElementById('question_form').innerHTML= show_table;

  	  })
			  }

</script>