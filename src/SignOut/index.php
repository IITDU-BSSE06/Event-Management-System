<?php
	session_start();
	session_destroy();
	header("refresh:0; url=http://localhost/mis");
?>