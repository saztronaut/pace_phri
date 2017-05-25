function checkPrivilege(min_account){
///check to see if user has sufficient privileges for page
data="roleID="+min_account;
doXHR('./checkRights.php, function(){
var response=this.responseText;
if (response=="0"){
 window.location.assign('./landing_text.php');
			}
  else {}
  return response;
}, data);

}