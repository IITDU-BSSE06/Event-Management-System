<?php
    include("../System/System.php");
    $system = new System();
    if($system->userTypeLoggedIn() != "admin"){
        $system->redirectToHomePage();
        die();
    }
    $email = $_GET['email'];
    $system->removeUserWithEmailInTable($email,"teacher");
    header("refresh:0; url=http://localhost/mis/teacherList");
?>
