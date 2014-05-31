<?php
	$type = $_GET['t'];
	$item = $_GET['s'];
	$file = './' . $type . '.csv';
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
	$logfile = "log.csv";
	$date = date('d-m-Y H:i:s');
	$content = file_get_contents($logfile);
	file_put_contents($logfile, $date  . ",computer_delete.png," . $_POST["servername"] . ",". $_POST["servername"] . " added to " . $_POST["type"] . "\n" . $content, LOCK_EX);
	header( 'Location: assets.php' ) ;
?>