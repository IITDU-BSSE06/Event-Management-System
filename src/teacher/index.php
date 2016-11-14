<?php
	include("../System/System.php");
	$system = new System();
	if($system->userTypeLoggedIn() != "teacher"){
		$system->redirectToHomePage();
		die();
	}
	include("../headers/header.php");
	include("../headers/teacherheader.php");
?>
