<?php
function array_to_csv_download($array, $filename= "export.csv", $delimiter=",") {

	$return_this=[];
	$columns= mysqli_fetch_fields($array);
	$csv_header='';
	
	foreach ($columns as $i){
		$csv_header .=''. $i->name . ',';
	}
	$csv_header.="\n ";
	$csv_row='';
	
	while ($row = mysqli_fetch_array($array)) {
		foreach ($columns as $i){
			$col= $i->name;
			$value=$row[$col];
			$csv_row .=''.$value . ',';
		}
		$csv_row .="\n ";
	}
	
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename='.$filename);
header('Pragma: no-cache');
header('Expires: 0');

//$return_this['main']= $csv_row;
//$return_this['cols']= $csv_header;
//$return_this['filename']= $filename;
return json_encode($return_this);
	// open the output stream
	//
	//$buffer= 'php://output';
	//$f = fopen($buffer,'w');

	//foreach($array as $line){
	//	fputcsv($f, $line, $delimiter);
	//}
	//fclose($f);
	//header('Content-Length: '. filesize($buffer));
}


?>