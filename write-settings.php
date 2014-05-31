<?php
	$file = "settings.csv";
	$logfile = "log.csv";
	$siterefresh = "site-refresh," .$_POST["srefresh"] . "\n";
	$timerrefresh = "timer-refresh," .$_POST["trefresh"] . "\n";
	$alertsno = "alerts-no," .$_POST["noofalerts"] . "\n";
	$clearno = "clear-no," .$_POST["clearalertno"] . "\n";
	$timeout = "timeout," .$_POST["rtimeout"] . "\n";
	$ports = "ports," .$_POST["ports"];
	$settings = $siterefresh . $timerrefresh . $alertsno . $clearno . $timeout . $ports;
	file_put_contents($file, $settings, LOCK_EX);
	$date = date('d-m-Y H:i:s');
	$content = file_get_contents($logfile);
	file_put_contents($logfile, $date  . ",accept.png,Settings Updated,New settings committed to file\n" . $content, LOCK_EX);
	header( 'Location: settings.php' ) ;
	
?>
