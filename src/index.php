<?php
	include("System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	include("headers/header.php");
	if($userType == "admin"){
		include("headers/adminheader.php");
	}
	else if($userType == "teacher"){
		include("headers/teacherheader.php");
	}
	else if($userType == "student"){
		include("headers/studentheader.php");
	}
	else{
		include("headers/menubarwithoutlogin.php");
	}
?>

<body>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>

    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="images/img1.jpg" alt="Image">
        <div class="carousel-caption">
          <h3>We Offer You An Online Event Management System</h3>
        </div>      
      </div>

      <div class="item">
        <img src="images/img2.jpg" alt="Image">
        <div class="carousel-caption">
          <h3>We Give You Templates To Make Even Creation Simple</h3>
        </div>      
      </div>
    </div>

    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>

</body>
</html>