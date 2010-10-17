<?php
	if($_REQUEST['flash'] == 'timeout') {
		echo "<p class='error'>Your session timed out. Please log in again.</p>";
	}
?>
<form action=login method=post>
<label>Username <input name=username></label><br>
<label>Password <input name=password type=password></label><br>
<input type=submit>
</form>
