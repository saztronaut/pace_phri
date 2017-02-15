<!-- This is the navigation bar. It will appear at the top of every page and is called by main_index -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">PACE-UP</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">HOME</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">MY STEPS <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="firststeps.php">RECORD STEP COUNT</a></li>
            <li><a href="#">REVIEW STEP HISTORY</a></li>
          </ul>
        </li>
   <li class="dropdown">
   <a class="dropdown-toggle" data-toggle="dropdown" href="#">MY TARGETS <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">CURRENT TARGET</a></li>
            <li><a href="#">PREVIOUS TARGETS</a></li>
          </ul>
        </li>
        <li><a href="#">MATERIALS</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<?php include './loggedon.php';?>
	  <!--  check to see if logged in - if so then offer log out if not then offer sign up login -->
		</ul>
    </div>
  </div>
</nav>
