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
