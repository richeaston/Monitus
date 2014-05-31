<?php	
	$folder = '';
	$filetype = '*.csv';
	$files = glob($folder.$filetype);
		for ($i=0; $i<count($files); $i++) {
			copy($files[$i], "backups/" . $files[$i]);
		}
	header( 'Location: settings.php' ) ;
				
		?>

