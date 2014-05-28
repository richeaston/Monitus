<?php
	$file = $_POST["type"].".csv";
	$fp = fopen($file, "a");
	$data = "\n" . $_POST["servername"] . "," . $_POST["ipaddress"] . "," . $_POST["port"] . "," . $_POST["alerts"];
	fwrite($fp, $data);
	fclose($fp);
	$logfile = "log.csv";
	$date = date('d-m-Y H:i:s');
	$content = file_get_contents($logfile);
	file_put_contents($logfile, $date  . "," . $_POST["servername"] . ",". $_POST["servername"] . " added to " . $_POST["type"] . "\n" . $content, LOCK_EX);
	header( 'Location: assets.php' ) ;
	
?>
