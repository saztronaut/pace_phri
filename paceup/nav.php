<!-- This is the navigation bar. It will appear at the top of every page and is called by main_index -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class='glyphicon glyphicon-menu-hamburger'> </span> </button>    
      <a class="navbar-brand" href="./feedbackQuestionnaire.php"><img src="images/puns_tiny.png" class="img-responsive"></a>
    <span class="sr-only">Toggle navigation</span>
    </div>

    <div class="collapse navbar-collapse" id="myNavbar">
    
      <ul class="nav navbar-nav">
        <li><a href="./main_index.php">HOME</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">MY STEPS <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="./steps2.php"><span id="recordsteps">RECORD STEP COUNT</span></a></li>
            <li><a href="./stepHistory.php"><span id="reviewsteps">REVIEW STEP HISTORY</span></a></li>
          </ul>
        </li>
   <li class="dropdown">
   <a class="dropdown-toggle" data-toggle="dropdown" href="#">TARGETS <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="./explain_targets.php"><span id="currenttarget">TARGETS EXPLAINED</span></a></li>
          </ul>
        </li>
         <li class="dropdown">
       <a class="dropdown-toggle" data-toggle="dropdown" href="#">MATERIALS<span class="caret"></span></a>
       <ul class="dropdown-menu">
             <li><a href="./links.php"><span id="links">LINKS</span></a></li>
             <li><a href="./handbook.php"><span id="handbook">HANDBOOK</span></a></li>
             <li><a href="./diary.php"><span id="diary">DIARY</span></a></li>
            <li><a href="./information_sheet.php"><span id="informationsht">INFORMATION SHEET</span></a></li>       
          </ul>
        </li>
       </ul>
      <ul class="nav navbar-nav navbar-right" id="login_bar">
	  <!--  check to see if logged in - if so then offer log out if not then offer sign up login -->
		</ul>
    </div>
  </div>
</nav>
  <script src="navFunctions.js"></script>
<script>
window.onload=getlogin();


</script>