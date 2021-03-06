<?php

	/* ini_set */
	ini_set("open_basedir", '.'.':'.'/var/lib/php5/');

	define('FROM_INDEX', 1);

	$op = empty($_GET['op']) ? 'home' : $_GET['op'];
	if(!is_string($op) || preg_match('/\.\./', $op))
	    die('hacker');
	ob_start('ob_gzhandler');

	function page_top($op) {
?>
	<!DOCTYPE html>
		<html>
			<head>
				<meta charset="UTF-8">
				<title>PixelShop :: <?= htmlentities(ucfirst($op)); ?></title>
				<link rel="stylesheet" href="css/style.css" type="text/css">
				<script src="js/jquery-1.12.3.min.js"></script>
				<script>
					$.ajax('.git/refs/heads/master').done(function(version){$('#version').html('Version: ' +  version.substring (0,6))});
				</script>
			</head>
			<body>
				<div id="header">
					<a href="?op=home" class="logo"><img src="images/logo.png" alt=""></a>
				</div>
				<div id="body"><ul><li>
<?php
	}

	function fatal($msg) {
?>
		<div class="article">
			<h2>Error</h2>
			<p><?=$msg;?></p>
		</div>
<?php
		exit(1);
	}

	function page_bottom() {
?>
	    		</li></ul></div>
				<div id="footer">
					<div>
						<p>
							<span>2016 &copy; Plaid Parliament of Pixels. Modified by Lobsiinvok.</span>All rights reserved. If it doesn't work, try Chrome or Firefox.
						</p>
					</div>
					<div>
						<p id='version' style='float: left; color: gray'></p>
					</div>
				</div>
			</body>
		</html>
<?php
		ob_end_flush();
	}

	register_shutdown_function('page_bottom');

	page_top($op);

	if(!(include $op . '.php'))
		fatal('no such page');

?>
