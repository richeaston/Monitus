<?php
	$file = "./log.csv";
	unlink($file);
	$date = date('d-m-Y H:i:s');
	file_put_contents($file, $date . ", Alert Log Cleared, The current Alert Log was Clear.", LOCK_EX);
	header( 'Location: alertlog.php' ) ;
?>
