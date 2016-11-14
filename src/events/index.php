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
		include("../headers/menubarwithoutlogin.php");
	}
?>

<html>
<body>
	<div>
	<?php
		$result = $system->getTableContent("event");
		$email = $system->getUserEmail();
		$id = 0;
		echo "<div class='container'>";
		echo "<h2>Events</h2>";
		echo "<div class='panel-group'>";
		while($row = $result->fetch_assoc()){
			$id = $id + 1;
			echo "<div class='panel panel-default'>";
				echo "<div class='panel-heading'>";
					echo "<h4 class='panel-title'>";
					$eventName = $row["name"];
					$eventUrl = $row["url"];
					$eventStart = $row["start"];
					$duration = $row["duration"];
					$eventCreator = $row["creator"];
					$description = $row["description"];
					$HREF = "#collapse".$id."";
					$ID = "collapse".$id."";
					if($description == NULL) $description = "[No Description]";
					echo "<a data-toggle='collapse' href=$HREF>$eventName</a>";
					if($userType == "admin" || $email == $eventCreator){
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "<a style='border: 0px' href='remove.php?url=$eventUrl' title='Remove'><span class='glyphicon glyphicon-trash'></span></a>";
					}
					echo "</h4>";
				echo "</div>";
				echo "<div id=$ID class='panel-collapse collapse'>";
					echo "<ul class='list-group'>";
					echo "<li class='list-group-item'>Starts : $eventStart, Duration : $duration days</li>";
					echo "<li class='list-group-item'>$description</li>";
					echo "</ul>";
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";
	?>
	</div>
</body>
</html>