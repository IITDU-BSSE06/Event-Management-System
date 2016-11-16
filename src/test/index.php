<?php
	include("../System/System.php");
    $system = new System();
    $email = $system->escape("froghramar@gmail.com");
    echo $email;
?>
