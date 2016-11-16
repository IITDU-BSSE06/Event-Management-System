<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "guest"){
		$system->redirectToLogInPage();
		die();
	}
	if($userType != "admin"){
		$system->redirectToPage("http://localhost/mis/templates/");
		die();
	}
	if(!$_GET["url"] || !$_GET["sub"]){
		$system->redirectToPage("http://localhost/mis/templates/");
		die();
	}
	$url = $_GET["url"];
	$sub = $_GET["sub"];
	$sql = "DELETE FROM $url WHERE name = '$sub'";
	$system->executeQuery($sql);
	$system->redirectToPage("http://localhost/mis/template/?url=".$url);
?>