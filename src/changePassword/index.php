<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "admin"){
		include("../headers/adminheader.php");
	}
	else if($userType == "teacher"){
		include("../headers/teacherheader.php");
	}
	else if($userType == "student"){
		include("../headers/studentheader.php");
	}
	else{
		die();
	}
?>
<html>
<title>Change Password</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h3>Change Password</h3>
		<form role="form" action="PasswordChange.php" method="post">
			<div class="form-group">
				<label for="current">Current Password:</label>
				<input type="password" required="true" class="form-control" name="current" id="current" placeholder="Enter current password">
			</div>
			<div class="form-group">
				<label for="new">Password:</label>
				<input type="password" required="true" class="form-control" name="new" id="new" placeholder="Enter new password">
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</body>
</html>