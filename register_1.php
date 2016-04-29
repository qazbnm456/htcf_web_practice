<?php

	session_start();
	include 'common.php';
	if(@$_SESSION['username']) die('Get out! Hacker...');
	htcfDatabaseConnect();
	$username = $_POST['username'];
	$password = $_POST['password'];
	$pwd_again = $_POST['pwd_again'];

	if($username == "" || $password == "")
	{
	    echo "Either username or password cannot be blank!";
	}
	else
	{
	    if($password != $pwd_again)
	    {
	        echo "Password are not the same!";
	        echo '<meta http-equiv=REFRESH CONTENT=1;url=?op=register>';
	    }
	    else
	    {
	    	// Check the database
			$data = $db->prepare('INSERT INTO users (username, password) VALUES (:username, :password);');
			$data->bindParam(':username', $username, PDO::PARAM_STR);
			$data->bindParam(':password', md5($password), PDO::PARAM_STR);
			
	        if(!$data->execute())
	        {
	            echo "Failed!";
	            echo '<meta http-equiv=REFRESH CONTENT=1;url=?op=register>';
	        }
	        else
	        {
	        	$_SESSION['username'] = $username;
	        	echo "Success!";
	            echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
	        }
	    }
	}

?>