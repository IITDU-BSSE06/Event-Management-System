<?php
    include("../System/System.php");
    $system = new System();
    $userType = $system->userTypeLoggedIn();
    if($userType == "admin"){
        $system->redirectToPage("http://localhost/mis/admin");
        die();
    }
    else if($userType == "teacher"){
        $system->redirectToPage("http://localhost/mis/teacher");
        die();
    }
    else if($userType == "student"){
        $system->redirectToPage("http://localhost/mis/student");
        die();
    }
    else{
        include("../headers/header.php");
        include("../headers/menubarwithoutlogin.php");
    }
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
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    if($system->isStudent($email, $password, FALSE)){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header("refresh:0; url=http://localhost/mis/student");
    }
    else if($system->isTeacher($email, $password, FALSE)){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header("refresh:0; url=http://localhost/mis/teacher");
    }
    else if($system->isAdmin($email, $password, FALSE)){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        header("refresh:0; url=http://localhost/mis/admin");
    }
    else{
        echo "<script>alert('No such email or password.');</script>";
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
