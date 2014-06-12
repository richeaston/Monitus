<?php	
	$folder = '';
	$filetype = '*.csv';
	$files = glob($folder.$filetype);
		for ($i=0; $i<count($files); $i++) {
			copy($files[$i], "backups/" . $files[$i]);
		}
	$logfile = "log.csv";
	$date = date('d-m-Y H:i:s');
	$content = file_get_contents($logfile);
	file_put_contents($logfile, $date  . ",page_white_zip.png,Backup Successful,Settings and assets backed up\n" . $content, LOCK_EX);
	header( 'Location: settings.php' ) ;
				
		?>

