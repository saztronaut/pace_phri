<?php if (!isset($_SESSION['username'])){
	include "signin.php";
}
else {
	echo "<div class='jumbotron text-center'>";
    echo "<h1>PaceUP</h1>";
    echo "<p>A Pedometer Intervention to Increase Walking in Adults</p>";
    echo "<p> Record your steps online and track your progress</p> </div>";
}
?>

<div class="container-fluid text-center">
<div class="row">
  <div class="col-sm-4"><h3>What is PaceUP online?</h3>
  <p>Let's explain what PaceUP is all about. I don't know if you want to call it PaceUP online but it needs a suffix to distinguish it from the main trial</p></div>
  <div class="col-sm-4"><h3>Who can sign up?</h3>
  <p>Let's explain who can take part and why. Maybe list the practices and </p></div>
  <div class="col-sm-4"><h3>I'm looking for the trial site</h3>
  <p>Link to the trial website</p></div>
</div>
</div>
