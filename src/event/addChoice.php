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
	if($userType == "admin"){
		include("../headers/adminheader.php");
	}
	else if($userType == "teacher"){
		include("../headers/teacherheader.php");
	}
	else if($userType == "student"){
		include("../headers/studentheader.php");
	}
	$url = $_GET["url"];
	$email = $_SESSION["email"];
	$email = $system->clean($email);
	$sql = "INSERT INTO $email (url) VALUES ('$url')";
	$system->executeNotificationQuery($sql);
	$system->redirectToPage("http://localhost/mis/event/?url=".$url);
?>