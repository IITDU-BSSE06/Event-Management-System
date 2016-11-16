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
	$_SESSION["url"] = $eventUrl;
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
	$notification = $row["notification"];
	$email = $_SESSION["email"];
	$creatorName = $system->getPropertyByEmail($creator,"name");
	if($description == NULL) $description = "[ No Description ]";
	$emailClean = $system->clean($email);
	$sql = "SELECT * FROM $emailClean WHERE url ='$eventUrl'";
	$result = $system->executeNotificationQuery($sql);
	if($result->num_rows > 0){
		$userNotification = 1;
	}
	else{
		$userNotification = 0;
	}
?>
  <script>
  		function editDescription(){
  			makeEditable('descriptbutt', 'description');
  		}
  		function editStart(){
  			makeEditable('startbutt', 'start');
  		}
  		function editCreator(){
  			if(document.getElementById('creatorbutt').innerHTML == "edit"){
  				document.getElementById("creator").innerHTML = "<?php echo $creator ?>";
  			}
  			makeEditable('creatorbutt', 'creator');
  		}
  		function editNotification(){
  			window.location.href = "change.php?url=<?php echo $eventUrl ?>&notification=" + <?php echo ($notification ? 0 : 1) ?>;
  		}
  		function editDuration(){
  			makeEditable('durationbutt', 'duration');
  		}
  		function editName() {
  			makeEditable('namebutt', 'name');
  		}
  		function editSubEvent(button){
  			var buttonid = button.id;
  			var contentid = buttonid + "extra";
  			var content = document.getElementById(contentid).innerHTML;
  			var field = button.name;
  			makeFieldEditable(buttonid, contentid, field);
  		}
  		function changeNotification(button){
  			var buttonid = button.id;
  			var contentid = buttonid + "extra";
  			var content = document.getElementById(contentid).innerHTML;
  			var field = button.name;
  			var subname = document.getElementById(contentid).className;
  			var val = '0';
  			if(content.length > 3) val = '1';
  			window.location.href = "change.php?url=<?php echo $eventUrl ?>&sub=" + subname + "&"+field +"=" + val;
  		}
  		function makeFieldEditable(butt, field, name) {
  			if(document.getElementById(butt).innerHTML == "edit"){
				document.getElementById(field).contentEditable = true;
				document.getElementById(butt).innerHTML = "save";
			}
			else{
				var subname = document.getElementById(field).className;
				var url = "change.php?url=<?php echo $eventUrl ?>&sub=" + subname + "&"+name +"=" + document.getElementById(field).innerHTML;
				window.location.href = url;
			}
		}
  		function makeEditable(butt, field) {
  			if(document.getElementById(butt).innerHTML == "edit"){
				document.getElementById(field).contentEditable = true;
				document.getElementById(butt).innerHTML = "save";
			}
			else{
				window.location.href = "change.php?url=<?php echo $eventUrl ?>&"+field +"=" + document.getElementById(field).innerHTML;
			}
		}
  </script>

	<div class="container">
		<div class="jumbotron">
			<h1><?php echo $name ?></h1><br>
			<?php
				if($userNotification == 0){
					echo "<a href='addChoice.php?url=$eventUrl'><button>Turn ON Notification</button></a>";
				}
				else{
					echo "<a href='removeChoice.php?url=$eventUrl'><button>Turn OFF Notification</button></a>";
				}
			?>
		</div>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#descript">Description</a></li>
			<li><a data-toggle="tab" href="#date">Date</a></li>
			<li><a data-toggle="tab" href="#sub">Sub Events</a></li>
			<?php if($email == $creator){
				echo "<li><a data-toggle='tab' href='#add'>Add</a></li>";
				echo "<li><a data-toggle='tab' href='#settings'>Settings</a></li>";
			} ?>
		</ul>
		<div class="tab-content">
			<div id="descript" class="tab-pane fade in active">
				<br> <div class="panel panel-default">
					<div id="description" class="panel-body"><?php echo $description ?></div>
					<?php if($email == $creator){
						echo "<button type='button' onclick='editDescription()' id='descriptbutt' class='btn btn-link'>edit</button>";
					} ?>
				</div>
			</div>
			<div id="date" class="tab-pane fade">
				<br> <div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-2"><b> Starts :</b></div>
							<div id="start" class="col-xs-1"><?php echo $start ?></div>
							<?php if($email == $creator){
								echo "<div class='col-xs-2'><button type='button' onclick='editStart()' id='startbutt' class='btn btn-link'>edit</button></div>";
							} ?>
						</div>
						<div class="row">
							<div class="col-xs-2"><b> Duration :</b></div>
							<div id="duration" class="col-xs-1"><?php echo $duration ?></div>
							<?php if($email == $creator){
								echo "<div class='col-xs-2'><button type='button' onclick='editDuration()' id='durationbutt' class='btn btn-link'>edit</button></div>";
							} ?>
						</div>
					</div>
				</div>
			</div>
			<div id="sub" class="tab-pane fade">
				<?php
					$sql = "SELECT * FROM $eventUrl";
					$result = $system->executeQuery($sql);
					echo "<br>";
					if($result->num_rows == 0){
						echo "<div class='panel panel-default'>";
							echo "<div id='description' class='panel-body'>[No Sub Events]</div>";
						echo "</div>";
					}
					while ($row = $result->fetch_assoc()) {
						$subEventName = $row["name"];
						$subEventdescription = $row["description"];
						$subEventStart = $row["start"];
						$subEventDuration = $row["duration"];
						$subEventNotification = $row["notification"];
						echo "<div class='panel panel-default'>";
							echo "<div class='panel-body'>";
								echo "<div class='row'>";
									$buttid = $subEventName."name";
									$fieldid = $buttid."extra";
									echo "<div class='col-xs-2'>";
									echo "<div id='$fieldid' class = '$subEventName'>$subEventName</div>";
									echo "</div>";
									if($email == $creator){
										echo "<button type='button' onclick='editSubEvent(this)' id = '$buttid' name = 'name' class='btn btn-link'>edit</button>";
									}
								echo "</div>";
								echo "<div class='row'>";
									$buttid = $subEventName."description";
									$fieldid = $buttid."extra";
									echo "<div class='col-xs-2'><b> Details :</b></div>";
									echo "<div class='col-xs-6'>";
										echo "<div id='$fieldid' class = '$subEventName'>$subEventdescription</div>";
									echo "</div>";
									if($email == $creator){
										echo "<button type='button' onclick='editSubEvent(this)' id = '$buttid' name = 'description' class='btn btn-link'>edit</button>";
									}
								echo "</div>";
								echo "<div class='row'>";
									$buttid = $subEventName."start";
									$fieldid = $buttid."extra";
									echo "<div class='col-xs-2'><b> Starts :</b></div>";
									echo "<div class='col-xs-6'>";
									echo "<div id='$fieldid' class = '$subEventName'> $subEventStart</div>";
									echo "</div>";
									if($email == $creator){
										echo "<button type='button' onclick='editSubEvent(this)' id='$buttid' name='start' class='btn btn-link'>edit</button>";
									}
								echo "</div>";
								echo "<div class='row'>";
									$buttid = $subEventName."duration";
									$fieldid = $buttid."extra";
									echo "<div class='col-xs-2'><b> Duration :</b></div>";
									echo "<div class='col-xs-1'>";
									echo "<div id='$fieldid' class = '$subEventName'>$subEventDuration</div>";
									echo "</div>";
									echo "<div id='$fieldid' class = 'col-xs-5'>days</div>";
									if($email == $creator){
										echo "<button type='button' onclick='editSubEvent(this)' id='$buttid' name='duration' class='btn btn-link'>edit</button>";
									}
								echo "</div>";
								if($email == $creator){
									echo "<div class='row'>";
										$buttid = $subEventName."notification";
										$fieldid = $buttid."extra";
										echo "<div class='col-xs-2'><b> Notification :</b></div>";
										$subEventStaus = $subEventNotification ? 'ON' : 'OFF';
										echo "<div class='col-xs-6'>";
											echo "<div id='$fieldid' class = '$subEventName'> $subEventStaus</div>";
										echo "</div>";
										if($email == $creator){
											echo "<button type='button' onclick='changeNotification(this)' id='$buttid' name='notification' class='btn btn-link'>edit</button>";
										}
									echo "</div>";
									echo "<a href='removeSub.php?url=$eventUrl&sub=$subEventName'><button>delete</button></a>";
								}
							echo "</div>";
						echo "</div>";
					}
				?>
			</div>
			<?php if($email == $creator){
				echo "<br><div id='add' class='tab-pane fade'>";
					echo "<div class='panel panel-default'>";
						echo "<div class='panel-body'>";
							echo "<h3 style='text-align: center;'>Add Sub Event</h3>";
							echo "<form role='form' action='addSubEvent.php' method='post'>";
								echo "<div class='form-group'>";
									echo "<label for='name'>Name:</label>";
									echo "<input type='text' required='true' class='form-control' name='name' placeholder='Enter sub event name'>";
								echo "</div>";
								echo "<div class='form-group'>";
									echo "<label for='description'>Description:</label>";
									echo "<input type='text' required='true' class='form-control' name='description' placeholder='Description'>";
								echo "</div>";
								echo "<div class='form-group'>";
									echo "<label for='start'>Start Date:</label>";
									echo "<input type='date' required='true' class='form-control' name='start' placeholder='Enter start date'>";
								echo "</div>";
								echo "<div class='form-group'>";
									echo "<label for='duration'>Duration:</label>";
									echo "<input type='number' required='true' class='form-control' name='duration' placeholder='Enter duration of this sub event'>";
								echo "</div>";
								echo "<button type='submit' class='btn btn-default'>Submit</button>";
							echo "</form>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
				echo "<div id='settings' class='tab-pane fade'>";
					echo "<br> <div class='panel panel-default'>";
						echo "<div class='panel-body'>";
							echo "<div class='row'>";
								echo "<div class='col-xs-2'><b> Name :</b></div>";
								echo "<div id='name' class='col-xs-2'>$name</div>";
								echo "<div class='col-xs-2'><button type='button' onclick='editName()' id='namebutt' class='btn btn-link'>edit</button></div>";
							echo "</div>";
							echo "<div class='row'>";
								echo "<div class='col-xs-2'><b> Owner :</b></div>";
								echo "<div id='creator' class='col-xs-2'>$creatorName ($creator)</div>";
								echo "<div class='col-xs-2'><button type='button' onclick='editCreator()' id='creatorbutt' class='btn btn-link'>edit</button></div>";
							echo "</div>";
							echo "<br><div class='row'>";
								echo "<div class='col-xs-2'><b> Notification :</b></div>";
								$staus = $notification ? 'ON' : 'OFF';
								echo "<div id='start' class='col-xs-2'>$staus</div>";
								echo "<div class='col-xs-2'><button type='button' onclick='editNotification()' id='notificationbutt' class='btn btn-link'>edit</button></div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			} ?>
		</div>
	</div>

