<br><br><div class="container-fluid text-center">


<h2 class="form-signin-heading">Feedback for PACE-UP Next Steps</h2><hr />
<form class="form " method="POST" action="./addQuestions.php" id="questions">
 <div class="form-group" id = "increase_pa_div">
 <label for="increase_pa">Do you think using the app/website helped increase your physical activity?:</label>
        <select name="inc_pa_select" class="form-control" name="increase_pa" id="increase_pa">
        <option value='1'> Yes </option>
        <option value='0'> No </option>
        <option value='2'> Don't Know </option>
        </select>
  </div>
      <div class="form-group" id = inc_pa_comment_div">
      <label for="inc_pa_comment"> Any other comments: </label>
        <input type="text" class="form-control" placeholder="Comment here" id="inc_pa_comment" >
        <span id= "inc_pa_comment_span"></span>
        </div>
 <div class="form-group" id = "look_and_feel_div">
 <label for="look_and_feel">Do you think using the app/website helped increase your physical activity?:</label>
        <select name="look_and_feel_select" class="form-control" name="look_and_feel" id="look_and_feel">
        <option value='0'> no stars </option>
        <option value='1'> <p><span class='glyphicon glyphicon-star logo-small'></span></p> </option>
        <option value='2'> <p><span class='glyphicon glyphicon-star logo-small'></span> <span class='glyphicon glyphicon-star logo-small'> </span></p></option>
        <option value='3'> <p><span class='glyphicon glyphicon-star logo-small'> </span> <span class='glyphicon glyphicon-star logo-small'></span> <span class='glyphicon glyphicon-star logo-small'></span><p></option>
        <option value='4'> <p><span class='glyphicon glyphicon-star logo-small'> </span> <span class='glyphicon glyphicon-star logo-small'> </span> <span class='glyphicon glyphicon-star logo-small'> </span><span class='glyphicon glyphicon-star logo-small'></span></p></option>
        <option value='5'> <p><span class='glyphicon glyphicon-star logo-small'> </span> <span class='glyphicon glyphicon-star logo-small'> </span> <span class='glyphicon glyphicon-star logo-small'> </span><span class='glyphicon glyphicon-star logo-small'> </span><span class='glyphicon glyphicon-star logo-small'></span></p></option>
        </select>
  </div>  

 <a href=\"ratebuyer.php?item=" . $item_id . "&star=1\" ><span class='glyphicon glyphicon-star logo-small' hover=\"this.class='glyphicon glyphicon-star logo-small'\" onmouseout=\"this.src='glyphicon glyphicon-star-empty logo-small'\"  /></a>
 <a href=\"ratebuyer.php?item=" . $item_id . "&star=2\" ><span class='glyphicon glyphicon-star-empty logo-small' hover=\"this.class='glyphicon glyphicon-star logo-small'\" onmouseout=\"this.src='glyphicon glyphicon-star-empty logo-small'\"  /></a>
<a href=\"ratebuyer.php?item=" . $item_id . "&star=3\" ><span class='glyphicon glyphicon-star-empty logo-small' hover=\"this.class='glyphicon glyphicon-star logo-small'\" onmouseout=\"this.src='glyphicon glyphicon-star-empty logo-small'\"  /></a>
<a href=\"ratebuyer.php?item=" . $item_id . "&star=4\" ><span class='glyphicon glyphicon-star-empty logo-small' hover=\"this.class='glyphicon glyphicon-star logo-small'\" onmouseout=\"this.src='glyphicon glyphicon-star-empty logo-small'\"  /></a>
<a href=\"ratebuyer.php?item=" . $item_id . "&star=5\" ><span class='glyphicon glyphicon-star-empty logo-small' hover=\"this.class='glyphicon glyphicon-star logo-small'\" onmouseout=\"this.src='glyphicon glyphicon-star-empty logo-small'\"  /></a>
					 	

<span id="question_form"></span>
</form>

</div>