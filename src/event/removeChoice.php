<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "guest"){
		$system->redirectToLogInPage();
		die();
	}
	if(!isset($_GET["url"])){
		$system->redirectToPage('http://localhost/mis/events/');
		die();
	}
	$url = $_GET["url"];
	$email = $_SESSION["email"];
	$email = $system->clean($email);
	$sql = "DELETE FROM $email WHERE url = '$url'";
	$system->executeNotificationQuery($sql);
	$system->redirectToPage("http://localhost/mis/event/?url=".$url);
?>