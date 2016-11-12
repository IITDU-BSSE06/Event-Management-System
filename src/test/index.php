<?php
	include("../System/System.php");
	$system = new System();
	$res = $system->isEmailExists("d@b.com");
	echo $res;
?>