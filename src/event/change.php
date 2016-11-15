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
	if(!isset($_GET["sub"])){
		if(isset($_GET["description"])){
			$description = $_GET["description"];
			$sql = "UPDATE event SET description='$description' WHERE url='$url'";
			$system->executeQuery($sql);
		}
		if(isset($_GET["start"])){
			$start = $_GET["start"];
			$sql = "UPDATE event SET start='$start' WHERE url='$url'";
			$system->executeQuery($sql);
		}
		if(isset($_GET["duration"])){
			$duration = $_GET["duration"];
			$sql = "UPDATE event SET duration='$duration' WHERE url='$url'";
			$system->executeQuery($sql);
		}
		if(isset($_GET["creator"])){
			$creator = $_GET["creator"];
			$sql = "UPDATE event SET creator='$creator' WHERE url='$url'";
			$system->executeQuery($sql);
		}
		if(isset($_GET["notification"])){
			$notification = $_GET["notification"];
			$sql = "UPDATE event SET notification='$notification' WHERE url='$url'";
			$system->executeQuery($sql);
		}
		if(isset($_GET["name"])){
			$name = $_GET["name"];
			$sql = "UPDATE event SET name='$name' WHERE url='$url'";
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
		if(isset($_GET["description"])){
			$description = $_GET["description"];
			$sql = "UPDATE $url SET description='$description' WHERE name='$sub'";
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
		if(isset($_GET["notification"])){
			$notification = $_GET["notification"];
			$sql = "UPDATE $url SET notification='$notification' WHERE name='$sub'";
			$system->executeQuery($sql);
		}
	}
	$system->redirectToPage("http://localhost/mis/event?url=$url");
?>