<?php
	include("System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "admin"){
		include("headers/adminheader.php");
	}
	else if($userType == "teacher"){
		include("headers/teacherheader.php");
	}
	else if($userType == "student"){
		include("headers/studentheader.php");
	}
	else{
		include("headers/menubarwithoutlogin.php");
	}
?>
