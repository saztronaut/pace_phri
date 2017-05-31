<?php include './template.php';?>
<br><div class= "container">
<div class= "jumbotron">
<h2>Your progress on PACE-UP Next Steps </h2>
</div></div>
<div class="container-fluid"> 
<div class = "row">
<div class = "col-lg-2"> </div>
<div class = "col-lg-8"> 
  <!-- Wrapper for slides -->
<div id="carousel_text"></div>
</div>

<div class = "col-lg-2"> </div>
</div></div>
<?php include './footer.php';?>
<script src="./twelveWeekSummary.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<script>
window.onload = function() {

drawSummary();
}

</script>