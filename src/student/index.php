<?php
	include("../System/System.php");
	$system = new System();
	if($system->userTypeLoggedIn() != "student"){
		$system->redirectToHomePage();
		die();
	}
	include("../headers/header.php");
	include("../headers/studentheader.php");
?>
