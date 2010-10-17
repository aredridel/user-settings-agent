<?php

require('functions.php');

$s = userdaemon_connect();

if($_POST['away']) {
	$v = command($s, "MKDIR", ".vacation")->stat();
	if($v != ERROR and $v != OK) die("Could not make vacation settings folder"); 
	if(command($s, "PUT", ".vacation/message")->stat() != CONT) die("Could not start writing message");
	if(send_data($s, $_POST['away'])->stat() != OK) die("Could not write message");
	command($s, "QUIT");
}

userdaemon_disconnect($s);
echo ("OK!");
header("Location: menu");

?>
