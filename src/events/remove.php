<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "guest"){
		$system->redirectToLogInPage();
		die();
	}
	$url = $_GET["url"];
	$sql = "DELETE FROM event WHERE url = '$url'";
	$system->executeQuery($sql);
	$sql = "DROP TABLE $url";
	$system->executeQuery($sql);
	$system->redirectToPage("http://localhost/mis/events/");
?>