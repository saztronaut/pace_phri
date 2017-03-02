<?php if (!isset($_SESSION['username'])){
	include "signin.php";
}
else {
	echo "<div class='jumbotron text-center'>";
    echo "<h1>PACE-UP</h1>";
    echo "<p>A Pedometer Intervention to Increase Walking in Adults</p>";
    echo "<p> Record your steps online and track your progress</p> </div>";
}
?>

<div class="container-fluid text-center">
<div class="row">
  <div class="col-sm-4"><h3>What is PACE-UP Next Steps?</h3>
  <p>A twelve week guide to help <b>you </b> increase <b>your</b> walking</p></div>
  <div class="col-sm-4"><h3>Who can sign up?</h3>
  <p>Currently, patients at participating GP surgeries, who wish to increase their walking, can take part. </p></div>
  <div class="col-sm-4"><h3>I'm looking for the trial site</h3>
  <p>Information about the PACE-UP Trial can be found at <a href="www.paceup.sgul.ac.uk">www.paceup.sgul.ac.uk</a></p></div>
</div>
<i><h3> Walking regularly can add years to life, and life to years</h3></i>
<p class="text-center"><img src="images/walking.png" class="img-small"  alt="stretch"></p>
</div>
