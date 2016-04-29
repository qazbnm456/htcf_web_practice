<?php
	
	/* ini_set */
	ini_set("open_basedir", '.');
	
	@$filename = $_GET['filename'];
    @$test = $_GET['test'];
	if(empty($filename)) die(highlight_file(__FILE__, TRUE));
	else {
        if(($test != '240610708') && (md5($test) == md5('240610708')))
            highlight_file($filename);
        else die('Try again!');
    }