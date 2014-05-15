<?php
	$item = $_GET['s'];
	$file = './servers.csv';
	$lines = file($file);
    $pattern = '/' . $item. '/im';
	$rows=array();
	$gfp = fopen($file, "w");
	fwrite($gfp, "");
foreach ($lines as $key => $value) {
    if (!preg_match($pattern, $value)) {
        $rows[] = $value;
		fwrite($gfp, $value );
	}
}
fclose($gfp);

header( 'Location: settings.php' ) ;
?>