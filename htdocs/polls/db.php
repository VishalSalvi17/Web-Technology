<?php
	date_default_timezone_set("Africa/Banjul");
	$db = new mysqli("localhost","root","","vote3") or die("Could not connect");

	$date_added = date("2019-07-09 23:20:59");
	$date_now = date("Y-m-d H:i:s");
	$startdate = new DateTime($date_added);
	$enddate = new DateTime($date_now);
	$interval = $startdate->diff($enddate);
	$msg = "";
	
	
