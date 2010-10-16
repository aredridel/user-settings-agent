<?php

$key = $_COOKIE['key'];
$socket = $_COOKIE['socket'];

if(!$s = fsockopen("unix://".$socket, null, $errno, $errstr)) die("could not open socket: ".$errstr);

fwrite($s, $key."\n");
$stat  = fgets($s);
if($stat{0} != '2') die("Error: $stat");

if($_POST['away']) {
	fwrite($s, "WRITE /tmp/away\n");
	$stat  = fgets($s);
	if($stat{0} != '1') die("Error: $stat");
	fwrite($s, $_POST['away']);
	fwrite($s, "\n");
	fwrite($s, ".\n");
	$stat  = fgets($s);
	if($stat{0} != '2') die("Error: $stat");
	fwrite($s, "QUIT\n");
	$stat  = fgets($s);
	if($stat{0} != '2') die("Error: $stat");
}

fclose($s);
echo ("OK: $stat");

?>
