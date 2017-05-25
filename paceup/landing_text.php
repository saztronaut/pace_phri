<?php include './template.php';?>

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
  <p>A twelve week guide to help <b>you </b> increase <b>your</b> walking</p>
  <p><a href="./explain_targets.php">Click here to see a brief overview</a></div>
  <div class="col-sm-4"><h3>Who can sign up?</h3>
  <p>Currently, patients at participating GP surgeries, who wish to increase their walking, can take part. </p></div>
  <div class="col-sm-4"><h3>What was the PACE-UP trial?</h3>
  <p>PACE-UP was a physical activity intervention run from even general practices in South West London. </p>
  <p>It successfully encouraged people aged 45-75 years old to increase their walking.</p>
  <p>Participants showed sustained increases in their walking at both 12 months and 3 years after the intervention.</p>
  <p> Findings are reported on <a href="http://www.paceup.sgul.ac.uk"> the PACE-UP website</a>
  and in <a href="http://www.journals.plos.org/plosmedicine">PLOS Medicine</a>
  </p></div>
</div>
<h3><i> Walking regularly can add years to life, and life to years</i></h3>
<p class="text-center"><img src="images/walking.png" class="img-small"  alt="stretch"></p>
</div>
<?php include './footer.php';?>