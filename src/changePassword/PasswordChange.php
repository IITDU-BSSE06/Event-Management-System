<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "guest"){
		$system->redirectToLogInPage();
		die();
	}
	$table = $userType;
	$email = $_SESSION["email"];
	$curPass = $_POST["current"];
	$newPass = $_POST["new"];
	if($curPass != $_SESSION["password"]){
		$system->showAlertMessage("Your current password does not match with actual one.");
		$system->redirectToPage("http://localhost/mis/changePassword/");
		die();
	}
	else{
		$sql = "UPDATE $table SET password='$newPass' WHERE email='$email'";
		$system->executeQuery($sql);
		$_SESSION["password"] = $newPass;
		$system->showAlertMessage("Your password was successfully changed.");
		$system->redirectToPage("http://localhost/mis/");
	}
?>