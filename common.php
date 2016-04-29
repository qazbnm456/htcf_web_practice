<?php

	/* Stop hackers. */
	if(!defined('FROM_INDEX')) die('Get out! Hacker...');

	define('MAX_IM_SIZE', 32);

	require_once 'config.inc.php';

	function create_image_key() {
		return sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . time() . mt_rand());
	}

	function save_image($im, $imagekey) {
		if(1 !== preg_match('/[0-9a-f]{40}/', $imagekey)) {
			fatal('Invalid image key.');
		}

		if(!imagepng($im, "uploads/{$imagekey}.png")) {
			fatal('Failed to save image.');
		}
	}

	function load_image($imagekey) {
		if(1 !== preg_match('/[0-9a-f]{40}/', $imagekey)) {
			fatal('Invalid image key.');
		}

		$im = imagecreatefrompng("uploads/{$imagekey}.png");
		if(!$im) {
			fatal('Failed to load image.');
		}
		return $im;
	}

	if( $DBMS == 'MySQL' ) {
		$DBMS = htmlspecialchars(strip_tags( $DBMS ));
		$DBMS_errorFunc = 'mysql_error()';
	}
	else {
		$DBMS = "No DBMS selected.";
		$DBMS_errorFunc = '';
	}

	$DBMS_connError = '
		<div align="center">
			<pre>Unable to connect to the database.<br />' . $DBMS_errorFunc . '<br /><br /></pre>
		</div>';

	function htcfDatabaseConnect() {
		global $_HTCF;
		global $DBMS;
		global $db;

		if( $DBMS == 'MySQL' ) {
			if( !@mysql_connect( $_HTCF[ 'db_server' ], $_HTCF[ 'db_user' ], $_HTCF[ 'db_password' ] )
			|| !@mysql_select_db( $_HTCF[ 'db_database' ] ) ) {
				die( $DBMS_connError );
			}
			// MySQL PDO Prepared Statements
			$db = new PDO('mysql:host=' . $_HTCF[ 'db_server' ].';dbname=' . $_HTCF[ 'db_database' ].';charset=utf8', $_HTCF[ 'db_user' ], $_HTCF[ 'db_password' ]);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}else {
			die ( "Unknown {$DBMS} selected." );
		}
	}

?>