<?php include './template.php';?>
<div class='jumbotron text-center'>
<h1>PACE-UP</h1>
<p> A twelve week programme to help you gradually increase your walking</p> </div>
<br><br><div class="container-fluid">
<div id="targets_text"></div>
</div>
<?php include './footer.php';?>
<script src= "./loadText.js"></script>
<script>
window.onload= loadText("targets_text", "./targets.txt");
</script>
