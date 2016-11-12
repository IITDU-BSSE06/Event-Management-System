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
<body>
	<div>
	<?php
		$result = $system->getTableContent("requests");
		$id = 0;
		echo "<div class='container'>";
		echo "<h2>All Requests</h2>";
		echo "<div class='panel-group'>";
		while($row = $result->fetch_assoc()){
			$id = $id + 1;
			echo "<div class='panel panel-default'>";
				echo "<div class='panel-heading'>";
					echo "<h4 class='panel-title'>";
					$name = $row["name"];
					$email = $row["email"];
					$roll = $row["roll"];
					$HREF = "#collapse".$id."";
					$ID = "collapse".$id."";
					echo "<a data-toggle='collapse' href=$HREF>$name</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<a style='border: 0px' href='add.php?email=$email' title='Add'><span class='glyphicon glyphicon-ok'></span></a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<a style='border: 0px' href='remove.php?email=$email' title='Remove'><span class='glyphicon glyphicon-remove'></span></a>";
					echo "</h4>";
				echo "</div>";
				echo "<div id=$ID class='panel-collapse collapse'>";
					echo "<ul class='list-group'>";
					echo "<li class='list-group-item'>Roll &nbsp;&nbsp;&nbsp;: $roll</li>";
					echo "<li class='list-group-item'>Email : $email</li>";
					echo "</ul>";
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";
	?>
	</div>
</body>
</html>
