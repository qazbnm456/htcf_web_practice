<?php

    session_start();
    include 'common.php';

    if(isset($_POST['submit'])) {
        htcfDatabaseConnect();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = md5($password);

        if($username == "") {
             echo"<script type='text/javascript'> alert('username please');location = './?op=4dm1n'; </script>";
        } elseif($password == "") {
            echo"<script type='text/javascript'> alert('password please');location = './?op=4dm1n'; </script>";
        } else {

            // Using RAW SQL here because no one will hit this place, lol
            $data = $db->query("SELECT admin, username FROM users WHERE username = '{$username}' and password = '{$password}';");
            // Only fetch first result
            $row = $data->fetch();

            // Make sure at least 1 result is returned
            if($data->rowCount() != 0) {
                if($row['admin'] === '1') {
                    $_SESSION['admin'] = $row['username'];
                    echo "Success!";
                } else {
                    echo "You are not authorized to view this page!";
                }

                echo '<meta http-equiv=REFRESH CONTENT=1;url=?op=4dm1n>';
            } else {
                print_r($db->errorInfo());
                echo '<meta http-equiv=REFRESH CONTENT=1;url=?op=4dm1n>';
            }
        }
    } else {
	    if(@$_SESSION['admin'] == null) {
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
                <h2>4dm1n Login Panel</h2>
                <div>
                    <form method="POST" action="?op=4dm1n" role="form">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                        </div>
                        <input type="submit" value="Submit" name="submit" class="btn"/>
                        <input type="reset" value="Clear" class="btn"/>  
                    </form>
                </div>
            </div>
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
<?php
        } else {
            if(empty($_GET['boom'])) header('Location: ?op=4dm1n&boom=4dm1n_home.');
            $boom = $_GET['boom'];
            if(!is_string($boom) || preg_match('/\.\./', $boom))
                die('hacker');
            if(!(include $boom . 'php'))
                fatal('no such page');
        }
    }
?>