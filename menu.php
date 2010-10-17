<?php require('functions.php'); ?>
<?php $s = userdaemon_connect(); ?>
<ul>
<li> <a href='vacation'>Set a vacation or out of office message</a></li>
<li> <a href='listdomains'>List domains I can alter</a></li>
<li><a href='logout'>Logout</a></li>
</ul>
<?php userdaemon_close($s); ?>

