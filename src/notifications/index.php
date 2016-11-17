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

<?php
	$email = $system->getUserEmail();
	$emailClean = $system->clean($email);
	$sql = "SELECT * FROM $emailClean";
	$result = $system->executeNotificationQuery($sql);
	$id = 0;
	echo "<div class='container'>";
	echo "<h2>Running And Upcoming Events</h2>";
	echo "<div class='panel-group'>";
	while($row = $result->fetch_assoc()) {
		$id = $id + 1;
		$eventUrl = $row["url"];
		$sql = "SELECT * FROM event WHERE url = '$eventUrl'";
		$eventRes = $system->executeQuery($sql);
		$event = $eventRes->fetch_assoc();
		$notification = $event["notification"];
		if($notification == 0) continue;
		$eventName = $event["name"];
		$eventStart = $event["start"];
		$eventDuration = $event["duration"];
		$currDate = date("Y-m-d");
		$diff = $system->dateDiff($eventStart, $currDate);
		if($diff >= $eventDuration) continue;
		if($diff < 0) $status = "Starts In ".abs($diff)." days";
		else $status = "Running";
		echo "<div class='panel panel-default'>";
			echo "<div class='panel-heading'>";
				echo "<h4 class='panel-title'>";
					$HREF = "#collapse".$id."";
					$ID = "collapse".$id."";
					echo "<a data-toggle='collapse' href=$HREF>$eventName  [$status] </a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id=$ID class='panel-collapse collapse'>";
				echo "<ul class='list-group'>";
				$sql = "SELECT * FROM $eventUrl";
				$res = $system->executeQuery($sql);
				while($subRow = $res->fetch_assoc()){
					$subName = $subRow["name"];
					$subStart = $subRow["start"];
					$subDuration = $subRow["duration"];
					$subNotification = $subRow["notification"];
					if($subNotification == 0) continue;
					$diff = $system->dateDiff($subStart, $currDate);
					if($diff >= $subDuration) continue;
					if($diff < 0) $status = "Starts In ".abs($diff)." days";
					else $status = "Running";
					echo "<li class='list-group-item'>$subName  [$status]</li>";
				}
				echo "<li class='list-group-item'><a href='http://localhost/mis/event?url=$eventUrl'><button>Enter</button></a></li>";
				echo "</ul>";
			echo "</div>";
		echo "</div>";

	}
	echo "</div>";
	echo "</div>";
?>