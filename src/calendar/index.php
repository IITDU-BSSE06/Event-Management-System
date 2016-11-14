<?php
	include("../System/System.php");
	$system = new System();
	$userType = $system->userTypeLoggedIn();
	include("../headers/header.php");
	if($userType == "admin")
		include("../headers/adminheader.php");
	else if($userType == "student")
		include("../headers/studentheader.php");
	else if($userType == "teacher")
		include("../headers/teacherheader.php");
	else
		include("../headers/menubarwithoutlogin.php");
?>

<html lang="en">
<head>
  <title>Event Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="calendar.css">
</head>
<body>

<?php
	function draw_calendar($month,$year){
		$system = new System();
		$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
		$months = array('January', 'February', 'March','April','May','June','july','August','September','October','November','December');
		$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$calendar.= '<h2>'.$months[$month - 1].' '.$year.'</h2>';
		$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
		$running_day = date('w',mktime(0,0,0,$month,1,$year));
		$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		$days_in_this_week = 1;
		$day_counter = 0;
		$dates_array = array();
		$calendar.= '<tr class="calendar-row">';
		for($x = 0; $x < $running_day; $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
			$days_in_this_week++;
		endfor;
		for($list_day = 1; $list_day <= $days_in_month; $list_day++):
			$calendar.= '<td class="calendar-day">';
				if($system->isHoliday(date("Y-m-d", mktime(0, 0, 0, $month, $list_day, $year)))){
					$calendar.= '<div class="day-number-holiday">'.$list_day.'</div>';
				}
				else{
					$calendar.= '<div class="day-number">'.$list_day.'</div>';
				}
				$calendar.= str_repeat('<p> </p>',2);
			$calendar.= '</td>';
			if($running_day == 6):
				$calendar.= '</tr>';
				if(($day_counter+1) != $days_in_month):
					$calendar.= '<tr class="calendar-row">';
				endif;
				$running_day = -1;
				$days_in_this_week = 0;
			endif;
			$days_in_this_week++; $running_day++; $day_counter++;
		endfor;
		if($days_in_this_week < 8):
			for($x = 1; $x <= (8 - $days_in_this_week); $x++):
				$calendar.= '<td class="calendar-day-np"> </td>';
			endfor;
		endif;
		$calendar.= '</tr>';
		$calendar.= '</table>';
		return $calendar;
	}
	$year = date('Y');
	for($month = 1; $month <= 12; $month++) { 
		echo draw_calendar($month,$year);	
	}
?>