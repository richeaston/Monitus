<?php
	$file = "./log.csv";
	unlink($file);
	$date = date('d-m-Y H:i:s');
	file_put_contents($file, $date . ",Error Log Deleted,The current alert log was deleted a new file has been created.\n", FILE_APPEND | LOCK_EX);
	header( 'Location: settings.php' ) ;
?>
