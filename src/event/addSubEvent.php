<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "guest"){
		$system->redirectToLogInPage();
		die();
	}
	if(!isset($_POST["name"]) || !isset($_POST["description"]) || !isset($_POST["start"]) || !isset($_POST["duration"]) || !isset($_SESSION["url"])){
		$system->redirectToPage("http://localhost/mis/events/");
		die();
	}
	$name = $_POST["name"];
	$description = $_POST["description"];
	$start = $_POST["start"];
	$duration = $_POST["duration"];
	$event = $_SESSION["url"];
	$sql = "SELECT * FROM $event WHERE name = '$name'";
	if($system->isDataexists($sql)){
		$system->showAlertMessage("Duplicate sub event name detected");
		$system->redirectToPage("http://localhost/mis/event?url=".$event);
		die();
	}
	$sql = "INSERT INTO $event (name, description, start, duration, notification) VALUES ('$name', '$description', '$start', '$duration', 0)";
	$system->executeQuery($sql);
	$system->redirectToPage("http://localhost/mis/event?url=".$event);
?>