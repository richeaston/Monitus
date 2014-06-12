<?php
	$type = $_POST['type'];
	$name = $_POST['servername'];
	$ipaddress = $_POST['ipaddress'];
	$port = $_POST['port'];
	$alert = $_POST['alerts'];
	$file = $type . '.csv';
	$lines = file($file);
    $pattern = '/' . $name . '/im';
	$rows=array();
	$gfp = fopen($file, "w");
	fwrite($gfp, "");
foreach ($lines as $key => $value) {
    if (!preg_match($pattern, $value)) {
        $rows[] = $value;
		fwrite($gfp, $value );
	}
}
	fwrite($gfp, "\n" . $name . "," . $ipaddress . "," . $port . "," . $alert);
	fclose($gfp);
	$logfile = "log.csv";
	$date = date('d-m-Y H:i:s');
	$content = file_get_contents($logfile);
	file_put_contents($logfile, $date  . ",information.png," . $_POST["servername"] . ",". $_POST["servername"] . " updated on the list: " . $_POST["type"] . "\n" . $content, LOCK_EX);
	header( 'Location: assets.php' ) ;
?>