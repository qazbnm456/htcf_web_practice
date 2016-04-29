<?php
	session_start();
	include 'common.php';
	if(@$_SESSION['username']) echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>';
?>
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<div class="figure">
    <img src="images/mario.png" width="200" height="200" alt="Pixel Mario">
</div>
<div class="article">
    <h2>Login</h2>
    <div>
		<form method="POST" action="?op=check" role="form">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
				<label for="password">Password</label>
				<input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
			</div>
  			<input type="submit" value="Submit" class="btn"/>
  			<input type="reset" value="Clear" class="btn"/>  
  			<a class="btn" href="?op=register" >Register</a>
  		</form>
 	</div>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>