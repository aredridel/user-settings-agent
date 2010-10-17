<?php

require('functions.php');

$s = userdaemon_connect();

$res = command($s, 'LISTWRITABLE', '/etc/mail/virtual');

print_r($res->data);

userdaemon_close($s);

?>
