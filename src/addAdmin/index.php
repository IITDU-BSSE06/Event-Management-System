<?php
	include("../System/System.php");
	$system = new System();
	if($system->userTypeLoggedIn() != "admin"){
		$system->redirectToHomePage();
		die();
	}
	include("../headers/header.php");
	include("../headers/adminheader.php");
?>
<html>
<title>Admin</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h3>Add an Admin Account</h3>
		<ul class="nav nav-pills">
			<li><a href="http://localhost/mis/addStudent/">Student</a></li>
			<li><a href="http://localhost/mis/addTeacher/">Teacher</a></li>
			<li class="active"><a href="http://localhost/mis/addAdmin/">Admin</a></li>
		</ul>
	</div>
	<div class="container">
		<form role="form" action="adminAddition.php" method="post">
			<div class="form-group">
				<label for="name">Name:</label>
				<input type="text" required="true" class="form-control" name="name" id="name" placeholder="Enter name">
			</div>
			<div class="form-group">
				<label for="designation">Designation:</label>
				<input type="text" required="true" class="form-control" name="designation" id="designation" placeholder="Enter designation">
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" required="true" class="form-control" name="email" id="email" placeholder="Enter email">
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" required="true" class="form-control" name="password" id="password" placeholder="Enter password">
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</body>
</html>
