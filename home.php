<?php
	session_start();
	include 'common.php';
	$username = @$_SESSION['username'];
?>
<div class="figure">
    <img src="images/mario.png" width="200" height="200" alt="Pixel Mario">
</div>
<div class="article">
    <h2><?php if($username != null) echo "<b>"."$username"."!</b> "; ?>Welcome to PixelShop!<?php if($username != null) echo "<a href='?op=logout'>logout</a>"; ?></h2>
    <p>
        PixelShop lets you edit your pixel art to perfection. Edit colors, palettes and more, all for free.<br/>
        Get started by <a href="?op=register">register an account</a> and <a href="?op=login">login</a>.<br/>
    	Then <a href="?op=upload">uploading a picture</a> or <a href="?op=new">creating a new picture.</a>
    </p>
</div>