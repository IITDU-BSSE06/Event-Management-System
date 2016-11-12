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

session_start();

$name = $email = $password = "";
$roll = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);

    $dbservername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "mis";
    $dbconn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
    if($dbconn->connect_error) {
        echo "Connection Failed ";
        die("Connection failed: " . $dbconn->connect_error);
    }
    $students = "SELECT * FROM student WHERE email = '$email' and password = '$password'";
    $studentResult = $dbconn->query($students);
    $teachers = "SELECT * FROM teacher WHERE email = '$email' and password = '$password'";
    $teacherResult = $dbconn->query($teachers);
    $admins = "SELECT * FROM admin WHERE email = '$email' and password = '$password'";
    $adminResult = $dbconn->query($admins);
    if($studentResult->num_rows == 1){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header("refresh:0; url=http://localhost/mis/student");
    }
    else if($teacherResult->num_rows == 1){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header("refresh:0; url=http://localhost/mis/teacher");
    }
    else if($adminResult->num_rows == 1){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header("refresh:0; url=http://localhost/mis/admin");
    }
    else{
        echo "<script>alert('No such email or password.');</script>";
    }
    $dbconn->close();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="container">
  <h2>Log In</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
