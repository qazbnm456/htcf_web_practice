<?php

	session_start();
	include 'common.php';
	if(@$_SESSION['username']) die('Get out! Hacker...');
	htcfDatabaseConnect();
	$username = $_POST['username'];
	$password = $_POST['password'];
	if($username == "")
	{
	     echo"<script type='text/javascript'> alert('username please');location = './?op=login'; </script>";
	}
	elseif($password == "")
	{
	    echo"<script type='text/javascript'> alert('password please');location = './?op=login'; </script>";
	}
	else
	{
		// Check the database
		$data = $db->prepare('SELECT username, password FROM users WHERE username = (:username) LIMIT 1;');
		$data->bindParam(':username', $username, PDO::PARAM_STR);
		$data->execute();
		$row = $data->fetch();

		// Make sure only 1 result is returned
		if($data->rowCount() == 1) {
			// Compare values
			if(($row['username'] == $username) && ($row['password'] == md5($password)))
			{
		    	$_SESSION['username'] = $username;
		    	echo "Success!";
		     	echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
		    }
		    else
		    {
		    	echo "Failed!";
		    	echo"<script type='text/javascript'> alert('wrong password');location = './?op=login'; </script>";
		    }
		} else {
            echo "Retry!";
            echo '<meta http-equiv=REFRESH CONTENT=1;url=?op=login>';
        }
	}

?>  