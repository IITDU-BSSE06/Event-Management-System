<?php
	include("../System/System.php");
    $system = new System();
    $date = date("Y-m-d", mktime(0, 0, 0, 2, 15, 2016));
	$nxt = $system->dateAfterDays($date, 20);
	echo $nxt;
?>
