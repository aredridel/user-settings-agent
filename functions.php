<?php

define('CONT', 1);
define('OK', 2);
define('ERROR', 4);
define('ABORT', 5);

class UserdaemonResult {
	public $data;
	function __construct() {
		$this->data = array();
	}
	public $status;

	function stat() {
		if($this->status{0} == '1') return CONT;
		if($this->status{0} == '2') return OK;
		if($this->status{0} == '4') return ERROR;
		if($this->status{0} == '5') return ABORT;
	}
}

function command($s, $command, $arg = '') {
	if(is_array($arg)) $arg = join(' ', $arg);
	if($arg) $arg = " $arg";
	fwrite($s, "$command$arg\n");
	$result = collect_result($s);
	return $result;
}

function collect_result($s) {
	$result = new UserdaemonResult();
	do {
		$stat = fgets($s);
		if($stat{3} == '-') {
			$result->data[] = substr($stat, 4);
		}
	} while($stat{3} == '-'); 
	$result->status = substr($stat, 0, 3);
	return $result;
}

function send_data($s, $data) {
	fwrite($s, $data);
	if($data{strlen($data)} != "\n") fwrite($s, "\n");
	fwrite($s, ".\n");
	$result = collect_result($s);
	return $result;
}

function userdaemon_connect() {

	$key = $_COOKIE['key'];
	$socket = $_COOKIE['socket'];

	if(!$s = fsockopen("unix://".$socket, null, $errno, $errstr)) die("could not open socket: ".$errstr);

	fwrite($s, $key."\n");
	$stat  = fgets($s);
	if($stat{0} != '2') die("Error: $stat");

	return $s;

}

function userdaemon_close($s) {
	fclose($s);
}


?>
