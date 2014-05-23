<?php
	$file = "./log.csv";
	unlink($file);
	$date = date('d-m-Y H:i:s');
	file_put_contents($file, $date . ",Alert Log Cleared,The current Alert Log was Clear.\n", FILE_APPEND | LOCK_EX);
	header( 'Location: settings.php' ) ;
?>
