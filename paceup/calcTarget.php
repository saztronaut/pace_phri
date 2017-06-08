<?php
if (function_exists('calcTarget') === false){
function calcTarget($n_t, $getsteps){
    
	$days = 0;
	$steptarget = 0;
	// if the number of targets is 1 or 3, that means this is the target for week 1 or week 5, which involve an increased target on 3 days
	if ((int)$n_t===1||(int)$n_t===3){
		$days=3;
		$steptarget=$getsteps+1500;
	}
	// if the number of targets is 2 or 4, that means this is the target for week 3 or week 7, which involve an increased target on 3 days
	elseif ((int)$n_t===2||(int)$n_t===4){
		$days=5;
		$steptarget=$getsteps;
	}
	elseif ((int)$n_t>=5){
		$days=6;
		$steptarget=$getsteps;
	}
	$results=[];
	$results['days']=$days;
	$results['steptarget']=$steptarget;
	return $results;
}

}
?>