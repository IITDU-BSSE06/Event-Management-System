<?php
	session_start();
	include("../headers/header.php");
	include("../headers/adminheader.php");
	$dbservername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "mis";
    $dbconn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
    if($dbconn->connect_error) {
        echo "Connection Failed ";
        die("Connection failed: " . $dbconn->connect_error);
    }
    if($_SESSION['email'] != $_GET['email']){
    	$toremove = mysqli_real_escape_string($dbconn, $_GET['email']);
    	$sql = "DELETE FROM admin WHERE email = '$toremove'";
    	$result = $dbconn->query($sql);
    }
    else{
    	echo "<script>alert('You can not remove yourself.');</script>";
    }
    header("refresh:0; url=http://localhost/mis/adminList");
?>
