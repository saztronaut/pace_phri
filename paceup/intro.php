<br><div class= "container">
<div class= "jumbotron">
<span id="thisHeader">Introduction to the week here</span>
<span id="thisBlurb">Explanation of the week here</span>
</div></div>
<div class="container-fluid-extrapad">  <p id="thisAside"><span id="thisTable">Message to motivate you should appear here</span> </p></div>


<script src="./drawHeader.js"></script>
<script>

baseline = drawHeader2("baseline", 0, "");

document.getElementById('thisHeader').innerHTML=baseline['thisHeader'];
document.getElementById('thisBlurb').innerHTML=baseline['blurb'];
document.getElementById('thisAside').innerHTML=baseline['thisAside'];

</script>