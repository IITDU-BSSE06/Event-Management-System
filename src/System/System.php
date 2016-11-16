<?php
	class System{
		public $dbservername;
		private $dbusername;
		private $dbpassword;
		private $dbname;
		private $UNSPECIFIED;
		private $UserEmail;
		private $UserPassword;
		private $UserName;
		private $UserDesignation;
		private $UserRoll;
		private $dbconn;
		public function initialize(){
			$this->dbservername = "localhost";
			$this->dbusername = "root";
			$this->dbpassword = "";
			$this->dbname = "mis";
			$this->UNSPECIFIED = "unspecified";
			$this->UserEmail = $this->UNSPECIFIED;
			$this->UserPassword = $this->UNSPECIFIED;
			$this->UserName = $this->UNSPECIFIED;
			$this->UserDesignation = $this->UNSPECIFIED;
			$this->UserRoll = $this->UNSPECIFIED;
		}
		public function __construct() {
			if(session_status() == PHP_SESSION_NONE){
			    session_start();
			}
			$this->initialize();
		}
		public function connectWithDatabase(){
			$this->dbconn = new mysqli($this->dbservername, $this->dbusername, $this->dbpassword, $this->dbname);
			if($this->dbconn->connect_error) {
			    echo "Connection Failed ";
			    die("Connection failed: " . $dbconn->connect_error);
			}
		}
		public function disconnectWithDatabase(){
			$this->dbconn->close();
		}
		public function userTypeLoggedIn(){
			if(isset($_SESSION["email"]) == FALSE || isset($_SESSION["password"]) == FALSE){
				return "guest";
			}
			$session_email = $_SESSION["email"];
			$session_password = $_SESSION["password"];
			if($this->isAdmin($session_email, $session_password, TRUE)){
				$this->UserEmail = $session_email;
				$this->UserPassword = $session_password;
				$this->name = $this->getPropertyByEmailInTable($this->UserEmail,"admin","name");
				$this->designation = $this->getPropertyByEmailInTable($this->UserEmail,"admin","designation");
				return "admin";
			}
			else if($this->isTeacher($session_email, $session_password, TRUE)){
				$this->UserEmail = $session_email;
				$this->UserPassword = $session_password;
				$this->name = $this->getPropertyByEmailInTable($this->UserEmail,"teacher","name");
				$this->designation = $this->getPropertyByEmailInTable($this->UserEmail,"teacher","designation");
				return "teacher";
			}
			else if($this->isStudent($session_email, $session_password, TRUE)){
				$this->UserEmail = $session_email;
				$this->UserPassword = $session_password;
				$this->name = $this->getPropertyByEmailInTable($this->UserEmail,"student","name");
				$this->roll = $this->getPropertyByEmailInTable($this->UserEmail,"student","roll");
				return "student";
			}
			else return "guest";
		}
		public function refreshCurrentPage(){
			header("Refresh:0");
		}
		public function redirectToHomePage(){
			$this->redirectToPage("http://localhost/mis");
		}
		public function redirectToLogInPage(){
			$this->redirectToPage("http://localhost/mis/LogIn");
		}
		public function redirectToPage($url){
			header("refresh:0; url=$url");
		}
		public function isSessionSet(){
			if(isset($_SESSION["email"]) == FALSE || isset($_SESSION["password"]) == FALSE){
				return FALSE;
			}
			return TRUE;
		}
		public function isCurrentUserAdmin(){
			if($this->isSessionSet() == FALSE) return FALSE;
			else if($this->isAdmin($_SESSION["email"], $_SESSION["password"], TRUE)){
				return TRUE;
			}
			else return FALSE;
		}
		public function isAdmin($email, $password, $checkPassword){
			$sql = $this->getUserTypeQuery($email, $password, $checkPassword, "admin");
			return $this->isDataexists($sql);
		}
		public function isTeacher($email, $password, $checkPassword){
			$sql = $this->getUserTypeQuery($email, $password, $checkPassword, "teacher");
			return $this->isDataexists($sql);
		}
		public function isStudent($email, $password, $checkPassword){
			$sql = $this->getUserTypeQuery($email, $password, $checkPassword, "student");
			return $this->isDataexists($sql);
		}
		public function isEmailExists($email){
			$sql = "SELECT * FROM student WHERE email = '$email'";
			if($this->isDataexists($sql)) return TRUE;
			$sql = "SELECT * FROM admin WHERE email = '$email'";
			if($this->isDataexists($sql)) return TRUE;
			$sql = "SELECT * FROM teacher WHERE email = '$email'";
			if($this->isDataexists($sql)) return TRUE;
			return FALSE;
		}
		public function isDataexists($sql){
			$this->connectWithDatabase();
			$result = $this->dbconn->query($sql);
			$this->disconnectWithDatabase();
			if($result->num_rows > 0) return TRUE;
			else return FALSE;
		}
		public function executeQuery($sql){
			$this->connectWithDatabase();
			$result = $this->dbconn->query($sql);
			$this->disconnectWithDatabase();
			return $result;
		}
		public function connectWithNotificationDatabase(){
			$this->dbconn = new mysqli($this->dbservername, $this->dbusername, $this->dbpassword, "notification");
			if($this->dbconn->connect_error) {
			    echo "Connection Failed ";
			    die("Connection failed: " . $dbconn->connect_error);
			}
		}
		public function executeNotificationQuery($sql){
			$this->connectWithNotificationDatabase();
			$result = $this->dbconn->query($sql);
			$this->disconnectWithDatabase();
			return $result;
		}
		public function getUserTypeQuery($email, $password, $checkPassword, $table){
			if($checkPassword == TRUE)
				$sql = "SELECT * FROM $table WHERE email = '$email' AND password = '$password'";
			else $sql = "SELECT * FROM $table WHERE email = '$email'";
			return $sql;
		}
		public function getUserEmail(){
			if($this->UserEmail == $this->UNSPECIFIED && isset($_SESSION["email"])) $this->UserEmail = $_SESSION["email"];
			return $this->UserEmail;
		}
		public function getUserPassword(){
			if($this->UserPassword == $this->UNSPECIFIED && isset($_SESSION["password"])) $this->UserPassword = $_SESSION["password"];
			return $this->UserPassword;
		}
		public function getUserName(){
			if($this->UserName == $this->UNSPECIFIED && $this->getUserEmail() != $this->UNSPECIFIED)
				$this->UserName = $this->getPropertyByEmail($this->getUserEmail(), "name");
			return $this->UserName;
		}
		public function getUserDesignation(){
			if($this->UserDesignation == $this->UNSPECIFIED && $this->getUserEmail() != $this->UNSPECIFIED)
				$this->UserDesignation = $this->getPropertyByEmail($this->getUserEmail(), "designation");
			return $this->UserDesignation;
		}
		public function getUserRoll(){
			if($this->UserRoll == $this->UNSPECIFIED && $this->getUserEmail() != $this->UNSPECIFIED)
				$this->UserRoll = $this->getPropertyByEmail($this->getUserEmail(), "roll");
			return $this->UserRoll;
		}
		public function getPropertyByEmail($email,$property){
			$name = $this->getPropertyByEmailInTable($email,"admin",$property);
			if($name != "Not Found") return $name;
			$name = $this->getPropertyByEmailInTable($email,"teacher",$property);
			if($name != "Not Found") return $name;
			$name = $this->getPropertyByEmailInTable($email,"student",$property);
			if($name != "Not Found") return $name;
			return "Not Found";
		}
		public function getPropertyByEmailInTable($email, $table, $property){
			$sql = "SELECT * FROM $table WHERE email = '$email'";
			$this->connectWithDatabase();
			$result = $this->dbconn->query($sql);
			$this->disconnectWithDatabase();
			if($result->num_rows > 0){
				$row=mysqli_fetch_assoc($result);
				return $row["$property"];
			}
			else return "Not Found";
		}
		public function getTableContent($table){
			$sql = "SELECT * FROM $table";
			$this->connectWithDatabase();
			$result = $this->dbconn->query($sql);
			$this->disconnectWithDatabase();
			return $result;
		}
		public function removeUserWithEmailInTable($email, $table){
			$sql = "DELETE FROM $table WHERE email = '$email'";
			$this->connectWithDatabase();
			$result = $this->dbconn->query($sql);
			$this->disconnectWithDatabase();
		}
		public function showAlertMessage($msg){
			echo "<script>alert('$msg');</script>";
		}
		public function addStudent($name, $roll, $email, $password){
			$sql = "INSERT INTO student (name, roll, email, password) VALUES ('$name', '$roll', '$email', '$password')";
			$this->connectWithDatabase();
			$result = $this->dbconn->query($sql);
			$this->disconnectWithDatabase();
		}
		public function addTeacher($name, $designation, $email, $password){
			$sql = "INSERT INTO teacher (name, designation, email, password) VALUES ('$name', '$designation', '$email', '$password')";
			$this->connectWithDatabase();
			$result = $this->dbconn->query($sql);
			$this->disconnectWithDatabase();
		}
		public function addAdmin($name, $designation, $email, $password){
			$sql = "INSERT INTO admin (name, designation, email, password) VALUES ('$name', '$designation', '$email', '$password')";
			$this->connectWithDatabase();
			$result = $this->dbconn->query($sql);
			$this->disconnectWithDatabase();
		}
		public function isHoliday($date){
			$day = strtotime($date);
			$day = date("l", $day);
			$day = strtolower($day);
			if($day == "saturday" || $day == "friday") {
			    return TRUE;
			}
			$sql = "SELECT * FROM holiday";
			$result = $this->executeQuery($sql);
			while($row = $result->fetch_assoc()){
				$start = $row["start"];
				$end = $row["end"];
				if($date >= $start && $date <= $end)
					return TRUE;
			}
			return FALSE;
		}
		public function nextDate($date){
			$date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
			return $date;
		}
		public function dateAfterDays($date, $after){
			for($i=0; $i < $after; $i++) { 
				$date = $this->nextDate($date);
				while($this->isHoliday($date)){
					$date = $this->nextDate($date);
				}
			}
			return $date;
		}
		public function clean($string) {
			$string = str_replace(' ', '-', $string);
			return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
		}
		public function escape($string){
			$this->connectWithDatabase();
			$res = mysqli_real_escape_string($this->dbconn, $string);;
			$this->disconnectWithDatabase();
			return $res; 
		}
	}
?>