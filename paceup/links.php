<?php include './template.php';?>
<div class='jumbotron text-center'>
<h1>PACE-UP</h1>
<p> Useful websites</p> </div>
<div class="container-fluid text-center">
<div id="links_text"></div>
</div>
<?php include './footer.php';?>
<script src= "./loadText.js"></script>
<script>
window.onload= loadText("links_text", "./links.txt");
</script>