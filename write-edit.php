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

header( 'Location: assets.php' ) ;
?>