<?php
include ( 'iCalEasyReader.php' );
$ical = new iCalEasyReader();
$lines = $ical->load( file_get_contents( 'basic.ics' ) );
var_dump( $lines ); 
?>
