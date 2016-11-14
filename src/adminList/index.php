<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "guest"){
		$system->redirectToHomePage();
		die();
	}
	include("../headers/header.php");
	if($userType == "admin")
		include("../headers/adminheader.php");
	else if($userType == "student")
		include("../headers/studentheader.php");
	else if($userType == "teacher")
		include("../headers/teacherheader.php");
?>
<html>
<body>
	<div>
	<?php
		$result = $system->getTableContent("admin");
		$id = 0;
		echo "<div class='container'>";
		echo "<h2>Admins In This System</h2>";
		echo "<div class='panel-group'>";
		while($row = $result->fetch_assoc()){
			$id = $id + 1;
			echo "<div class='panel panel-default'>";
				echo "<div class='panel-heading'>";
					echo "<h4 class='panel-title'>";
					$name = $row["name"];
					$email = $row["email"];
					$designation = $row["designation"];
					$HREF = "#collapse".$id."";
					$ID = "collapse".$id."";
					echo "<a data-toggle='collapse' href=$HREF>$name</a>";
					if($userType == "admin"){
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "<a style='border: 0px' href='remove.php?email=$email' title='Remove'><span class='glyphicon glyphicon-trash'></span></a>";
					}
					echo "</h4>";
				echo "</div>";
				echo "<div id=$ID class='panel-collapse collapse'>";
					echo "<ul class='list-group'>";
					echo "<li class='list-group-item'>Designation : $designation</li>";
					echo "<li class='list-group-item'>Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;$email</li>";
					echo "</ul>";
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";
	?>
	</div>
</body>
</html>
