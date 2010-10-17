<?php
	require('functions.php');
	$s = userdaemon_connect();

	if($_SERVER['REQUEST_METHOD'] != 'POST'):
?>
<form action='logout' method='post'>
	<button name='logout'>Logout</button>
</form>
<?php

	else:

		command($s, "SHUTDOWN");
		header("Location: index");

	endif;


	userdaemon_close($s);
?>
