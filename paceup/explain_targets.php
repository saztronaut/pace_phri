<?php include './template.php';?>
<div class='jumbotron text-center'>
<div class="hidden-xs"><h1>PACE-UP</h1></div>
<h3> A twelve week programme to help you gradually increase your walking </h3></div>
<br><br><div class="container-fluid">
<div id="targets_text"></div>
</div>
<?php include './footer.php';?>
<script src= "./loadText.js"></script>
<script>
window.onload= loadText("targets_text", "./targets.txt");
</script>
