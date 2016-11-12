<?php
	include("../System/System.php");
	$system = new System();
	if($system->userTypeLoggedIn() != "admin" || !isset($_POST["email"])){
		$system->redirectToHomePage();
		die();
	}
	$email = $_POST["email"];
	if($system->isEmailExists($email)){
		$system->showAlertMessage("Email Already Exists");
		$system->redirectToPage('http://localhost/mis/addStudent/');
		die();
	}
	else{
		$system->addStudent($_POST["name"],$_POST["roll"],$_POST["email"],$_POST["password"]);
		$system->showAlertMessage("Student Added");
		$system->redirectToPage('http://localhost/mis/studentList/');
	}
?>
