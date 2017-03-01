<div class="container-fluid text-center">

<form class="form-signin" method="POST" action="./download.php" id="downland">

<h2 class="form-signin-heading">Download study data</h2><hr />

<p id="errorMessage"></p>
<div class="form-group" id="practice_div">
        <div class="form-group" id="n_div">
        <select name='n_codes' id='n_codes' class='form-control' >
	     <option value='' disabled selected> Which file do you want to download?</option>
         <option value='U'> Users</option> 
         <option value='S'> Steps</option> 		
         <option value='P'> Practices</option> 
         <option value='T'> Targets</option> 
         <option value='M'> Methods</option>
         <option value='R'> Registration codes</option>
        </select>        
        <span id= "n_span"></span>
        </div>
       <hr />
        <div class="form-group">
            <button type="button" class="btn btn-default" id="downloadBtn">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Download </button> </div>
 </form>
 </div>