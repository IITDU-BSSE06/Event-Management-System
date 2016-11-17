<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType == "guest"){
		$system->redirectToLogInPage();
		die();
	}
	if(!isset($_GET["url"]) && !isset($_SESSION["url"])){
		$system->redirectToPage('http://localhost/mis/templates/');
		die();
	}
    include("../headers/header.php");
	if($userType == "admin"){
		include("../headers/adminheader.php");
	}
	else if($userType == "teacher"){
		include("../headers/teacherheader.php");
	}
	else if($userType == "student"){
		include("../headers/studentheader.php");
	}
	if(isset($_GET["url"])) $templateUrl = $_GET["url"];
	else $templateUrl = $_SESSION["url"];
	$_SESSION["url"] = $templateUrl;
	$sql = "SELECT * FROM template WHERE url = '$templateUrl'";
	$result = $system->executeQuery($sql);
	if($result->num_rows == 0){
		$system->redirectToPage('http://localhost/mis/templates/');
		die();
	}
	$row = $result->fetch_assoc();
	$templateName = $row["name"];
	$templateDuration = $row["duration"];
?>

<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url= test_input($_POST["url"]);
    $sql = "SELECT * FROM event WHERE url = '$url'";
    if($system->isDataexists($sql)){
    	$system->showAlertMessage('URL is not available. Retry with another url.');
    	$system->redirectToPage("http://localhost/mis/templates/");
    	die();
    }
    else{
    	$sql = "SHOW TABLES LIKE '$url'";
		$val = $system->executeQuery($sql);
		if($val->num_rows > 0){
			$system->showAlertMessage('URL is not available. Retry with another url.');
			$system->redirectToPage("http://localhost/mis/templates/");
			die();
		}
		$email = $system->getUserEmail();
    	$name = $templateName;
    	$start = test_input($_POST["start"]);
    	$duration = $templateDuration;
        $sql = "INSERT INTO event (name, url, creator, start, duration) VALUES ('$name', '$url', '$email','$start','$duration')";
        $system->executeQuery($sql);
       	$sql = "CREATE TABLE $url(
				name varchar(30),
				description varchar(500),
				start date,
				duration int(10),
				notification Boolean
				)";
        $system->executeQuery($sql);
        $sql = "SELECT * FROM $templateUrl";
        $result = $system->executeQuery($sql);
        while($row = $result->fetch_assoc()){
        	$subName = $row["name"];
        	$subStart = $row["start"];
        	$toStart = $system->dateAfterDays($start, $subStart);
        	$duration = $row["duration"];
        	$sql = "INSERT INTO $url (name, start, duration, notification) VALUES ('$subName', '$toStart', '$duration', 0)";
        	$system->executeQuery($sql);
        }
    	$system->showAlertMessage('Congrats ! Your event was successfully added.');
        $system->redirectToPage("http://localhost/mis/events/");
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<div class="container">
    <h2>Create An Event With <?php echo $templateName ?> Template</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label for="url">Event Url:</label>
            <input type="text" class="form-control" id="url" name="url" placeholder="Select an unique url" required>
        </div>
        <div class="form-group">
            <label for="start">Start Date:</label>
            <input type="date" class="form-control" id="start" name="start" placeholder="Start date (Y-M-D)" required>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
</body> 
</html>