<?php include './template.php';?>

	<div class='jumbotron text-center'>
    <h1>PACE-UP</h1>
<p> Administrative tools for PACE-UP</p> </div>
<div class="container-fluid text-center">
<div class="row">
  <div class="col-sm-2"><h3>Generate Registration Codes</h3><br>
  <a href= "./getCodes.php"><span class='glyphicon glyphicon-pencil logo' ></span></a>
  </div>
  <div class="col-sm-2"><h3>Add New Practice</h3><br>
  <a href="./addPractice.php"><span class='glyphicon glyphicon-thumbs-up logo' ></span></a></div>
  <div class="col-sm-2"><h3>Download data</h3><br>
    <a href="./downloadData.php"><span class='glyphicon glyphicon-briefcase logo' ></span></a></div>
  
    <div class="col-sm-2"><h3>User privileges</h3><br>
     <a href="./userRights.php" ><span class='glyphicon glyphicon-user logo'></span></a></div>

    <div class="col-sm-2"><h3>Update Consent</h3><br>
   <a href="./updateConsent.php">  <span class='glyphicon glyphicon-ok logo' ></span></a></div>

    <div class="col-sm-2"><h3>Edit User</h3><br>
   <a href="./editUser.php">  <span class='glyphicon glyphicon-eye-open logo' ></span></a></div>  
  </div>
</div>
<?php include './footer.php';?>
<script> 
window.onload = checkPrivilege('R');

function checkPrivilege(min_account){
	///check to see if user has sufficient privileges for page
	data="min_account="+min_account;
	doXHR('./checkRights.php', function(){
	var response=this.responseText;
	if (response=="0"){
	 window.location.assign('./landing_text.php');
				}
	  else {}
	  return response;
	}, data);

	}
</script>