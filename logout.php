<?php
	session_start();
	include 'common.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	//將session清空
	session_destroy();
	echo 'logging out...';
	echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
?>