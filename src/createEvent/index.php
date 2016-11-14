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

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
$name = $email = $password = "";
$roll = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url= test_input($_POST["url"]);
    $sql = "SELECT * FROM event WHERE url = '$url'";
    if($system->isDataexists($sql)){
    	echo "<script>alert('URL is not available. Retry with another url.');</script>";
    	$system->redirectToPage("http://localhost/mis/createEvent/");
    	die();
    }
    else{
    	$sql = "SHOW TABLES LIKE '$url'";
		$val = $system->executeQuery($sql);
		if($val->num_rows > 0){
			echo "<script>alert('URL is not available. Retry with another url.');</script>";
			$system->redirectToPage("http://localhost/mis/createEvent/");
			die();
		}
    	$email = $system->getUserEmail();
    	$name = test_input($_POST["name"]);
    	$start = test_input($_POST["start"]);
    	$duration = test_input($_POST["duration"]);
        $sql = "INSERT INTO event (name, url, creator, start, duration) VALUES ('$name', '$url', '$email','$start','$duration')";
        $system->executeQuery($sql);
       	$sql = "CREATE TABLE $url(
				name varchar(30),
				description varchar(500),
				start int(10),
				duration int(10),
				notification Boolean
				)";
        $system->executeQuery($sql);
        echo "<script>alert('Congrats ! Your event was successfully added.');</script>";
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
    <h2>Create An Event</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label for="name">Event Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter event name" required>
        </div>
        <div class="form-group">
            <label for="url">Choose An URL:</label>
            <input type="text" class="form-control" id="url" name="url" placeholder="Choose an url" required>
        </div>
        <div class="form-group">
            <label for="start">Start Date:</label>
            <input type="date" class="form-control" id="start" name="start" placeholder="Select start date (Year-Month-Day)" required>
        </div>
        <div class="form-group">
            <label for="duration">Duration:</label>
            <input type="number" class="form-control" id="duration" name="duration" placeholder="Duration in days" required>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
</body> 
</html>