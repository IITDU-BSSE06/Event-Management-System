<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "guest"){
		$system->redirectToLogInPage();
		die();
	}
	if(!isset($_GET["url"])){
		$system->redirectToPage('http://localhost/mis/events/');
		die();
	}
	if($userType == "admin"){
		include("../headers/adminheader.php");
	}
	else if($userType == "teacher"){
		include("../headers/teacherheader.php");
	}
	else if($userType == "student"){
		include("../headers/studentheader.php");
	}

	$eventUrl = $_GET["url"];
	$sql = "SELECT * FROM event WHERE url = '$eventUrl'";
	$result = $system->executeQuery($sql);
	if($result->num_rows == 0){
		$system->redirectToPage('http://localhost/mis/events/');
		die();
	}
	$row = $result->fetch_assoc();
	$name = $row["name"];
	$creator = $row["creator"];
	$description = $row["description"];
	$start = $row["start"];
	$duration = $row["duration"];
	$email = $_SESSION["email"];
	if($description == NULL) $description = "[ No Description ]";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Case</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
  		function makeEditable() {
			if(document.getElementById("butt").innerHTML == "edit"){
				document.getElementById("descript").contentEditable = true;
				document.getElementById("butt").innerHTML = "save";
			}
			else{
				document.getElementById("descript").contentEditable = false;
				document.getElementById("butt").innerHTML = "edit";
				window.location.href = "change.php?url=<?php echo $eventUrl ?>&description=" + document.getElementById("descript").innerHTML;
			}
		}
  </script>
</head>
<body>
	<div class="container">
		<div class="jumbotron">
			<h1><?php echo $name ?></h1>
		</div>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#description">Description</a></li>
			<li><a data-toggle="tab" href="#date">Date</a></li>
			<li><a data-toggle="tab" href="#sub">Sub Events</a></li>
			<?php if($email == $creator){
				echo "<li><a data-toggle='tab' href='#settings'>Settings</a></li>";
			} ?>
		</ul>
		<div class="tab-content">
			<div id="description" class="tab-pane fade in active">
				<br> <div class="panel panel-default">
					<div id="descript" class="panel-body"><?php echo $description ?></div>
					<?php if($email == $creator){
						echo "<button type='button' onclick='makeEditable()' id='butt' class='btn btn-link'>edit</button>";
					} ?>
				</div>
			</div>
			<div id="date" class="tab-pane fade">
				<br> <div class="panel panel-default">
					<div class="panel-body">
						<p> <b> Starts &nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;</b> <?php echo $start ?> </p>
						<p> <b> Duration : &nbsp;</b> <?php echo $duration ?> days</p>
					</div>
				</div>
			</div>
			<div id="sub" class="tab-pane fade">
				<br><p>Sub events here.</p>
			</div>
			<?php if($email == $creator){
				echo"<div id='settings' class='tab-pane fade'>";
					echo "<br><p>$email</p>";
				echo "</div>";
			} ?>
		</div>
	</div>
</body>
</html>
