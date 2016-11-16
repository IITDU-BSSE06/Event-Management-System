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
		$system->redirectToPage('http://localhost/mis/addTeacher/');
		die();
	}
	else{
		$system->addTeacher($_POST["name"],$_POST["designation"],$_POST["email"],$_POST["password"]);
		$email = $system->clean($email);
		$sql = "CREATE TABLE $email(
					url varchar(30)
				)";
		$system->executeNotificationQuery($sql);
		$system->showAlertMessage("Teacher Added");
		$system->redirectToPage('http://localhost/mis/teacherList/');
	}
?>
