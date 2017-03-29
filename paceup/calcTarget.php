<?php
function calcTarget($n_t, $getsteps){

	if ($n_t==1||$n_t==3){
		$days=3;
		$steptarget=$getsteps+1500;
	}
	elseif ($n_t==2||$n_t==4){
		$days=5;
		$steptarget=$getsteps;
	}
	elseif ($n_t>=5){
		$days=6;
		$steptarget=$getsteps;
	}
	$results=[];
	$results['days']=$days;
	$results['steptarget']=$steptarget;
	return $results;
    

}
?>