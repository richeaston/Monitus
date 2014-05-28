<?php
	$file = $_POST["type"].".csv";
	$fp = fopen($file, "a");
	$data = "\n" . $_POST["servername"] . "," . $_POST["ipaddress"] . "," . $_POST["port"] . "," . $_POST["alerts"];
	fwrite($fp, $data);
	fclose($fp);
	header( 'Location: assets.php' ) ;
?>
