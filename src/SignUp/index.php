<?php
	include("../headers/header.php");
	include("../headers/menubarwithoutlogin.php");
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
$name = $email = $password = "";
$roll = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = test_input($_POST["name"]);
	$email = test_input($_POST["email"]);
	$password = test_input($_POST["password"]);
	$roll = test_input($_POST["roll"]);
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "mis";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if($conn->connect_error) {
		echo "Connection Failed ";
	    die("Connection failed: " . $conn->connect_error);
	}
	$forms = "SELECT * FROM form WHERE email = '$email'";
	$formResult = $conn->query($forms);
	$requests = "SELECT * FROM requests WHERE email = '$email'";
	$requestsResult = $conn->query($requests);
	$students = "SELECT * FROM student WHERE email = '$email'";
	$studentResult = $conn->query($students);
	$teachers = "SELECT * FROM teacher WHERE email = '$email'";
	$teacherResult = $conn->query($teachers);
	$admins = "SELECT * FROM admin WHERE email = '$email'";
	$adminResult = $conn->query($admins);
	if($formResult->num_rows == 0 && $requestsResult->num_rows == 0 &&$studentResult->num_rows == 0 && $teacherResult->num_rows == 0 && $adminResult->num_rows == 0){
		$sql = "INSERT INTO form (name, roll, email, password) VALUES ('$name', '$roll', '$email', '$password')";
		if($conn->query($sql)){
			echo "<script>alert('Registration Successfull. Verify Your Email.');</script>";
			header("refresh:0; url=http://localhost/mis/");
		}
		else{
			echo "<script>alert('Sorry ! Try Again.');</script>";
		}
	}
	else{
		echo "<script>alert('Email Already taken. Retry with a different Email.');</script>";
	}
	$conn->close();
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<div class="container">
  <h2>Register</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  	<div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
    </div>
    <div class="form-group">
      <label for="roll">Roll:</label>
      <input type="roll" class="form-control" id="roll" name="roll" placeholder="Enter roll" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body> 
</html>

