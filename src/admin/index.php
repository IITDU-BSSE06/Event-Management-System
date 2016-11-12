<?php
	include("../System/System.php");
	$system = new System();
	if($system->userTypeLoggedIn() != "admin"){
		$system->redirectToHomePage();
		die();
	}
	include("../headers/header.php");
	include("../headers/adminheader.php");
?>
