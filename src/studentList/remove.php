<?php
    include("../System/System.php");
    $system = new System();
    if($system->userTypeLoggedIn() != "admin"){
        $system->redirectToHomePage();
        die();
    }
    $email = $_GET['email'];
    $system->removeUserWithEmailInTable($email,"student");
    $email = $system->clean($email);
    $sql = "DROP TABLE $email";
    $system->executeNotificationQuery($sql);
    header("refresh:0; url=http://localhost/mis/studentList");
?>
