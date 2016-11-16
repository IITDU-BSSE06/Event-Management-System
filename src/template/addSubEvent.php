<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType != "admin"){
		$system->redirectToLogInPage();
		die();
	}
	if(!isset($_POST["name"]) || !isset($_POST["start"]) || !isset($_POST["duration"]) || !isset($_SESSION["url"])){
		$system->redirectToPage("http://localhost/mis/template?url=".$event);
		die();
	}
	$name = $_POST["name"];
	$start = $_POST["start"];
	$duration = $_POST["duration"];
	$event = $_SESSION["url"];
	$sql = "SELECT * FROM $event WHERE name = '$name'";
	if($system->isDataexists($sql)){
		$system->showAlertMessage("Duplicate sub event name detected");
		$system->redirectToPage("http://localhost/mis/template?url=".$event);
		die();
	}
	$sql = "INSERT INTO $event (name, start, duration) VALUES ('$name','$start', '$duration')";
	$system->executeQuery($sql);
	$system->redirectToPage("http://localhost/mis/template?url=".$event);
?>