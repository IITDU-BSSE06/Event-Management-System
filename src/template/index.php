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
	$sql = "SELECT * FROM template WHERE url = '$eventUrl'";
	$result = $system->executeQuery($sql);
	if($result->num_rows == 0){
		$system->redirectToPage('http://localhost/mis/templates/');
		die();
	}
	$row = $result->fetch_assoc();
	$name = $row["name"];
	$duration = $row["duration"];
?>
  <script>
  		function editStart(){
  			makeEditable('startbutt', 'start');
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
			<h1><?php echo $name ?></h1>
			<?php
				$URL = "useTemplate.php?url=".$eventUrl;
			?>
			<a href="<?php echo $URL ?>"><button>Use This Template</button></a>
		</div>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#date">Duration</a></li>
			<li><a data-toggle="tab" href="#sub">Sub Events</a></li>
			<?php if($userType == "admin"){
				echo "<li><a data-toggle='tab' href='#add'>Add</a></li>";
				echo "<li><a data-toggle='tab' href='#settings'>Settings</a></li>";
			} ?>
		</ul>
		<div class="tab-content">
			<div id="date" class="tab-pane fade in active">
				<br> <div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-2"><b> Duration :</b></div>
							<div id="duration" class="col-xs-1"><?php echo $duration ?></div>
							<?php if($userType == "admin"){
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
					while ($row = $result->fetch_assoc()) {
						$subEventName = $row["name"];
						$subEventStart = $row["start"];
						$subEventDuration = $row["duration"];
						echo "<div class='panel panel-default'>";
							echo "<div class='panel-body'>";
								echo "<div class='row'>";
									$buttid = $subEventName."name";
									$fieldid = $buttid."extra";
									echo "<div class='col-xs-2'>";
									echo "<div id='$fieldid' class = '$subEventName'>$subEventName</div>";
									echo "</div>";
									if($userType == "admin"){
										echo "<button type='button' onclick='editSubEvent(this)' id = '$buttid' name = 'name' class='btn btn-link'>edit</button>";
									}
								echo "</div>";
								echo "<div class='row'>";
									$buttid = $subEventName."start";
									$fieldid = $buttid."extra";
									echo "<div class='col-xs-2'><b> Starts :</b></div>";
									echo "<div class='col-xs-1'>";
									echo "<div id='$fieldid' class = '$subEventName'> $subEventStart</div>";
									echo "</div>";
									echo "<div class='col-xs-5'> days later </div>";
									if($userType == "admin"){
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
									if($userType == "admin"){
										echo "<button type='button' onclick='editSubEvent(this)' id='$buttid' name='duration' class='btn btn-link'>edit</button>";
									}
								echo "</div>";
								if($userType == "admin"){
									echo "<a href='removeSub.php?url=$eventUrl&sub=$subEventName'><button>delete</button></a>";
								}
							echo "</div>";
						echo "</div>";
					}
				?>
			</div>
			<?php if($userType == "admin"){
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
									echo "<label for='start'>Start Date:</label>";
									echo "<input type='number' required='true' class='form-control' name='start' placeholder='Enter start days after the initial event'>";
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
						echo "</div>";
					echo "</div>";
				echo "</div>";
			} ?>
		</div>
	</div>
