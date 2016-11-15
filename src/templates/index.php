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
		$system->redirectToLogInPage();
		die();
	}
?>

<html>
<body>
	<div>
	<?php
		$result = $system->getTableContent("template");
		$id = 0;
		echo "<div class='container'>";
		echo "<h2>Templates</h2>";
		echo "<div class='panel-group'>";
		while($row = $result->fetch_assoc()){
			$id = $id + 1;
			echo "<div class='panel panel-default'>";
				echo "<div class='panel-heading'>";
					echo "<h4 class='panel-title'>";
					$eventName = $row["name"];
					$eventUrl = $row["url"];
					$duration = $row["duration"];
					$HREF = "#collapse".$id."";
					$ID = "collapse".$id."";
					echo "<a data-toggle='collapse' href=$HREF>$eventName</a>";
					if($userType == "admin"){
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "<a style='border: 0px' href='remove.php?url=$eventUrl' title='Remove'><span class='glyphicon glyphicon-trash'></span></a>";
					}
					echo "</h4>";
				echo "</div>";
				echo "<div id=$ID class='panel-collapse collapse'>";
					echo "<ul class='list-group'>";
					echo "<li class='list-group-item'>Duration : $duration days</li>";
					echo "<li class='list-group-item'><a href='http://localhost/mis/template?url=$eventUrl'><button>Enter</button></a></li>";
					echo "</ul>";
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";
	?>
	</div>
</body>
</html>