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
	if(!isset($_GET["url"])){
		$system->redirectToPage("http://localhost/mis/templates/");
		die();
	}
	$url = $_GET["url"];
	$sql = "SELECT * FROM template WHERE url = '$url'";
	$res = $system->executeQuery($sql);
	if($res->num_rows == 0){
		$system->redirectToPage("http://localhost/mis/templates/");
		die();
	}
	$row = $res->fetch_assoc();
	if(!isset($_GET["sub"])){
		if(isset($_GET["duration"])){
			$duration = $_GET["duration"];
			$sql = "UPDATE template SET duration='$duration' WHERE url='$url'";
			$system->executeQuery($sql);
		}
		if(isset($_GET["name"])){
			$name = $_GET["name"];
			$sql = "UPDATE template SET name='$name' WHERE url='$url'";
			$system->executeQuery($sql);
		}
	}
	else{
		$sub = $_GET["sub"];
		if(isset($_GET["name"])){
			$name = $_GET["name"];
			$sql = "UPDATE $url SET name='$name' WHERE name='$sub'";
			$system->executeQuery($sql);
		}
		if(isset($_GET["start"])){
			$start = $_GET["start"];
			$sql = "UPDATE $url SET start='$start' WHERE name='$sub'";
			$system->executeQuery($sql);
		}
		if(isset($_GET["duration"])){
			$duration = $_GET["duration"];
			$sql = "UPDATE $url SET duration='$duration' WHERE name='$sub'";
			$system->executeQuery($sql);
		}
	}
	$system->redirectToPage("http://localhost/mis/template?url=$url");
?>