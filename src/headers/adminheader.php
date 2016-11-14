<?php
	$system = new System();
	$name = $system->getUsername();
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
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li><a href="http://localhost/mis" title="Home Page"><span class="glyphicon glyphicon-home"></span> Home</a></li>
					<li><a href="http://localhost/mis/AdminList" title="List of Admins"><span class="glyphicon glyphicon-user"></span> Admins</a></li>
					<li><a href="http://localhost/mis/StudentList" title="List of Students"><span class="glyphicon glyphicon-education"></span> Students</a></li>
					<li><a href="http://localhost/mis/TeacherList" title="List of Teachers"><span class="glyphicon glyphicon-user"></span> Teachers</a></li>
					<li><a href="http://localhost/mis/Requests" title="All Sign Up Requests"><span class="glyphicon glyphicon-user"></span> Requests</a></li>
					<li><a href="http://localhost/mis/addStudent" title="Create New Student Account"><span class="glyphicon glyphicon-plus"></span> Add User</a></li>
					<li><a href="http://localhost/mis/calendar"><span class="glyphicon glyphicon-calendar"></span> Calendar</a></li>
					<li><a href="http://localhost/mis/events"><span class="glyphicon glyphicon-list"></span> Events</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<?php echo "<a class='dropdown-toggle' data-toggle='dropdown' href='http://localhost/mis/Admin'>$name<span class='caret'></span></a>"; ?>
						<ul class="dropdown-menu">
							<?php echo "<li><a href='http://localhost/mis/Admin' title='View Profile'><span class='glyphicon glyphicon-user'></span> $name</a></li>"; ?>
							<li><a href="http://localhost/mis/changePassword" title="Change Your Password"><span class='glyphicon glyphicon-wrench'></span> Change Password</a></li>
							<li><a href="http://localhost/mis/createEvent" title="Create An Event"><span class='glyphicon glyphicon-plus'></span> Create Event</a></li>
						</ul>
					</li>
					<li><a href="http://localhost/mis/SignOut" title="Sign Out"><span class="glyphicon glyphicon-log-out"></span> Sign Out</a></li>
				</ul>
			</div>
		</div>
	</nav>
</body>
</html>
