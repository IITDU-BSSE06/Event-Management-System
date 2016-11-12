<?php
	include("../System/System.php");
    $system = new System();
    if($system->userTypeLoggedIn() != "admin"){
        $system->redirectToHomePage();
        die();
    }
    if($_SESSION['email'] != $_GET['email']){
        $email = $_GET['email'];
    	$system->removeUserWithEmailInTable($email,"admin");
    }
    else{
    	echo "<script>alert('You can not remove yourself.');</script>";
    }
    header("refresh:0; url=http://localhost/mis/adminList");
?>
