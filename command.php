<?php

$key = $_COOKIE['key'];
$socket = $_COOKIE['socket'];

if(!$s = fsockopen("unix://".$socket, null, $errno, $errstr)) die("could not open socket: ".$errstr);

fwrite($s, $key."\n");
$stat  = fgets($s);
if($stat{0} != '2') die("Error: $stat");

define('CONT', 1);
define('OK', 2);
define('ERROR', 4);
define('ABORT', 5);

function command($s, $command, $arg = '') {
	if(is_array($arg)) $arg = join(' ', $arg);
	if($arg) $arg = " $arg";
	fwrite($s, "$command$arg\n");
	$stat = fgets($s);
	if($stat{0} == '1') return CONT;
	if($stat{0} == '2') return OK;
	if($stat{0} == '4') return ERROR;
	if($stat{0} == '5') return ABORT;
}

function send_data($s, $data) {
	fwrite($s, $data);
	if($data{strlen($data)} != "\n") fwrite($s, "\n");
	fwrite($s, ".\n");
	$stat = fgets($s);
	if($stat{0} == '1') return CONT;
	if($stat{0} == '2') return OK;
	if($stat{0} == '4') return ERROR;
	if($stat{0} == '5') return ABORT;
}


if($_POST['away']) {
	$v = command($s, "MKDIR", ".vacation");
	if($v != ERROR and $v != OK) die("Could not make vacation settings folder"); 
	if(command($s, "WRITE", ".vacation/message") != CONT) die("Could not start writing message");
	if(send_data($s, $_POST['away']) != OK) die("Could not write message");
	command($s, "QUIT");
}

fclose($s);

header("Location: menu");

?>
