<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	if($userType != "admin"){
		$system->redirectToHomePage();
		die();
	}
	include("../headers/header.php");
	include("../headers/adminheader.php");
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
    $sql = "SELECT * FROM template WHERE url = '$url'";
    if($system->isDataexists($sql)){
    	echo "<script>alert('URL is not available. Retry with another url.');</script>";
    	$system->redirectToPage("http://localhost/mis/createTemplate/");
    	die();
    }
    else{
    	$sql = "SHOW TABLES LIKE '$url'";
		$val = $system->executeQuery($sql);
		if($val->num_rows > 0){
			echo "<script>alert('URL is not available. Retry with another url.');</script>";
			$system->redirectToPage("http://localhost/mis/createTemplate/");
			die();
		}
    	$name = test_input($_POST["name"]);
    	$duration = test_input($_POST["duration"]);
        $sql = "INSERT INTO template (name, url, duration) VALUES ('$name', '$url', '$duration')";
        $system->executeQuery($sql);
       	$sql = "CREATE TABLE $url(
				name varchar(30),
                start int(10),
				duration int(10)
				)";
        $system->executeQuery($sql);
        echo "<script>alert('Congrats ! Your template was successfully added.');</script>";
        $system->redirectToPage("http://localhost/mis/templates/");
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
    <h2>Create A Template</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label for="name">Template Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
        </div>
        <div class="form-group">
            <label for="url">Choose An URL:</label>
            <input type="text" class="form-control" id="url" name="url" placeholder="Choose an url" required>
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