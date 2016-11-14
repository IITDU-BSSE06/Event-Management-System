<?php
	include("../System/System.php");
	$system = new System();
	$table = "admin";
	$sql = "SHOW TABLES LIKE '$table'";
	$val = $system->executeQuery($sql);
	if($val->num_rows == 0) echo "Not Exists";
	else echo "Exists";
?>