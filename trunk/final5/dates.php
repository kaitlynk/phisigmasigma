<?php
	$id = $_GET['id'];
	
	for ($i = 1; $i < 28; $i++) {
		$str = $str.$i.",";
	}
	
	$str = $str."28";
	
	if ($id == '01' || $id == '03' || $id == '05' || $id == '07' || $id == '08' || $id == '10' || $id == '12') {
		$str = $str.",29,30,31";
	}
	
	else if ($id == '04' || $id == '06' || $id == '09' || $id == '11') {
		$str = $str.",29,30";
	}
	
	echo "new Array($str)";

?>