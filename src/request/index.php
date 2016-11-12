<?php
	session_start();
	include("../headers/header.php");
	include("../headers/adminheader.php");
?>
<html>
<body>
	<div>
	<?php
		$dbservername = "localhost";
	    $dbusername = "root";
	    $dbpassword = "";
	    $dbname = "mis";
	    $dbconn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
	    if($dbconn->connect_error) {
	        echo "Connection Failed ";
	        die("Connection failed: " . $dbconn->connect_error);
	    }
		$sql = "SELECT * FROM admin";
		$result = $dbconn->query($sql);
		$id = 0;
		echo "<div class='container'>";
		echo "<h2>Admins In This System</h2>";
		echo "<div class='panel-group'>";
		while($row = $result->fetch_assoc()){
			$id = $id + 1;
			echo "<div class='panel panel-default'>";
				echo "<div class='panel-heading'>";
					echo "<h4 class='panel-title'>";
					$name = $row["name"];
					$email = $row["email"];
					$designation = $row["designation"];
					$HREF = "#collapse".$id."";
					$ID = "collapse".$id."";
					echo "<a data-toggle='collapse' href=$HREF>$name</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<a style='border: 0px' href='remove.php?email=$email'><span class='glyphicon glyphicon-trash'></span></a>";
					echo "</h4>";
				echo "</div>";
				echo "<div id=$ID class='panel-collapse collapse'>";
					echo "<ul class='list-group'>";
					echo "<li class='list-group-item'>$designation</li>";
					echo "<li class='list-group-item'>$email</li>";
					echo "</ul>";
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";
		$dbconn->close();
	?>
	</div>
</body>
</html>
