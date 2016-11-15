<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "guest"){
		$system->redirectToLogInPage();
		die();
	}
	if($userType != "admin"){
		$system->showAlertMessage("You are not allowed to delete this template.");
		$system->redirectToPage("http://localhost/mis/templates/");
	}
	$url = $_GET["url"];
	$sql = "DELETE FROM template WHERE url = '$url'";
	$system->executeQuery($sql);
	$sql = "DROP TABLE $url";
	$system->executeQuery($sql);
	$system->redirectToPage("http://localhost/mis/templates/");
?>