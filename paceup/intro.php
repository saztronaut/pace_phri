<br><div class= "container">
<div class= "jumbotron">
<span id="thisHeader">Baseline introduction</span>
<span id="thisBlurb">Introduction to pace next steps</span>
</div></div>
<div class="container-fluid-extrapad"> 
<p id="thisAside"><span id="thisTable">Explanation of the study will appear her</span> </p>
<p> To get started recording steps for your first week, <a href="#" onclick='redirect("./steps2.php")'> click here</a> </p>

</div>


<script src="./drawHeader.js"></script>
<script>

baseline = drawHeader2("baseline", 0, "");

document.getElementById('thisHeader').innerHTML=baseline['thisHeader'];
document.getElementById('thisBlurb').innerHTML=baseline['blurb'];
document.getElementById('thisAside').innerHTML=baseline['thisAside'];

</script>