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

<?php
	$sql = "SELECT * FROM admin";
	$res = $system->executeQuery($sql);
	$admins = $res->num_rows;
	$sql = "SELECT * FROM teacher";
	$res = $system->executeQuery($sql);
	$teacher = $res->num_rows;
	$sql = "SELECT * FROM student";
	$res = $system->executeQuery($sql);
	$student = $res->num_rows;
	$sql = "SELECT * FROM requests";
	$res = $system->executeQuery($sql);
	$requests = $res->num_rows;
?>

<body>
<div class='container'>
	<table class='table table-bordered'>
	<thead>
		<tr><th>News Feed</th></tr>
	</thead>
	<tbody>
	<tr><td><a href='#'><span class='glyphicon glyphicon-send'></span> Notifications <span class='badge'>3</span></a><br></td></tr>
	<tr><td><a href='http://localhost/mis/Requests/'><span class='glyphicon glyphicon-user'></span> Verification Requests <span class='badge'><?php echo $requests ?></span></a><br></td></tr>
	</tbody>
	</table>
</div>
<br>
<div class='container'>
	<table class='table table-bordered'>
		<thead><tr><th>All Users</th></tr>
	</thead>
	<tbody>
	<tr><td>
		<a href='http://localhost/mis/AdminList/'><span class='glyphicon glyphicon-user'></span> System Admins <span class='badge'><?php echo $admins ?></span></a><br>
	</td></tr>
	<tr><td>
		<a href='http://localhost/mis/TeacherList/'><span class='glyphicon glyphicon-user'></span> Honourable Teachers <span class='badge'><?php echo $teacher ?></span></a><br>
	</td></tr>
	<tr><td>
		<a href='http://localhost/mis/StudentList/'><span class='glyphicon glyphicon-user'></span> All Students <span class='badge'><?php echo $student ?></span></a><br>
	</td></tr>
	</tbody>
	</table>
</div>
</body>
</html>
