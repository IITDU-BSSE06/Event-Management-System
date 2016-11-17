<?php
	include("../System/System.php");
	$system = new System();
	$date1 = "2013-03-15";
	$date2 = "2012-12-12";
	$diff = $system->dateDiff($date1, $date2);
	//$diff = date("Y-m-d");
	echo $diff;

?>
