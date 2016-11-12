<?php
	include("../System/System.php");
	$system = new System();
	$name = $system->userTypeLoggedIn();
	echo $name;
?>