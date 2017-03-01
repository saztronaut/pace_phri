<?php
function array_to_csv_download($array, $filename= "export.csv", $delimiter=",") {

	header('Content-Type: application/csv; charset=UTF-8');
	header('Content-Disposition: attachment; filename="'. $filename .'"');

	// open the output stream
	//
	$f = fopen('php://output','w');

	foreach($array as $line){
		fputcsv($f, $line, $delimiter);
	}

	//fclose($f);
	readfile('php://output');

}
?>