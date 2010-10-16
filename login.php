<?php

$sess = ssh2_connect('localhost');

if($sess) {
	$auth = ssh2_auth_password($sess, $_POST['username'], $_POST['password']);
}

if($auth) {
	$p = dirname(__FILE__);
	$stream = ssh2_exec($sess, $p.'/userdaemon', NULL);
	stream_set_blocking($stream, true);
	$info = stream_get_contents($stream);
	fclose($stream);
	$info = json_decode($info);
	setcookie('key', $info->key);
	setcookie('socket', $info->socket);
	header('Location: menu');
} else {
	echo "No";
}

?>
