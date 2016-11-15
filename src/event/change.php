<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "guest"){
		$system->redirectToLogInPage();
		die();
	}
	if(!isset($_GET["url"])){
		$system->redirectToPage("http://localhost/mis/events/");
		die();
	}
	$url = $_GET["url"];
	$sql = "SELECT * FROM event WHERE url = '$url'";
	$res = $system->executeQuery($sql);
	if($res->num_rows == 0){
		$system->redirectToPage("http://localhost/mis/events/");
		die();
	}
	$row = $res->fetch_assoc();
	$creator = $row["creator"];
	if($creator != $_SESSION["email"]){
		$system->redirectToPage("http://localhost/mis/events/");
		die();
	}
	if(isset($_GET["description"])){
		$description = $_GET["description"];
		$sql = "UPDATE event SET description='$description' WHERE url='$url'";
		$system->executeQuery($sql);
		$system->redirectToPage("http://localhost/mis/event?url=$url");
	}
?>