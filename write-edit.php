<?php
	$type = $_POST['t'];
	$name = $_POST['n'];
	$ipaddress = $_POST['i'];
	$port = $_POST['p'];
	$alert = $_POST['a'];
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
fclose($gfp);

file_put_contents($type . '.csv', $name . "," . $ipaddress . "," . $port . "," . $alert . "\n", FILE_APPEND | LOCK_EX);
header( 'Location: settings.php' ) ;
?>