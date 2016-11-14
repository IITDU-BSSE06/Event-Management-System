<?php
	$xml = simplexml_load_file("https://calendar.google.com/calendar/htmlembed?src=bd@holiday.calendar.google.com");
	$xml->asXML();
	$holidays = array();
	foreach ($xml->entry as $entry){
	  $a = $entry->children('http://schemas.google.com/g/2005');
	  $when = $a->when->attributes()->startTime;

	  $holidays[(string)$when]["title"] = $entry->title;
	}
	if(is_array($holidays[date("2016-10-12")]))
	    echo "holiday";
	else 
	    echo "Not holiday";
?>