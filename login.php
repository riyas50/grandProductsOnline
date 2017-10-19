<?php
                $msg = null;
                $username = null;
                $password = null;

                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                //if (isset($_POST['submit']) ) 
                    {
                        if (!empty($_POST['name']) && !empty($_POST['paw'])) 
                        {
                            include('general.php');
                            require_once('dbconnect.php');

                            $username = $_POST["name"];
                            $password = $_POST["paw"];
                            
                            $sql = $conn->prepare("SELECT `user_id` FROM `users` WHERE `user_login` = ? and `user_password` = PASSWORD(?)");
                            $sql->bind_param("ss",$username,$password);
                            $sql->execute();
                            $sql->bind_result($userid);
                            $sql->fetch();
                            $sql->close();

                            if (!empty($userid))
                                    {
                                        session_start();
                                        $session_key = session_id();

                                        $query = $conn->prepare("INSERT INTO `sessions` ( `user_id`, `session_key`, `session_address`, `session_useragent`, `session_expires`) VALUES ( ?, ?, ?, ?, DATE_ADD(NOW(),INTERVAL 1 HOUR) );");
                                        $query->bind_param("isss", $userid, $session_key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'] );
                                        $query->execute();
                                        $query->close();
                                        
                                        header('Location: index.php');
                                    }
                            else
                                    {
                                        $msg = "Wrong username or password";
                                        displayMessage($msg);
                                        header('Location: login.php');
                                    }
                            //$_SESSION['valid'] = true;
                            //$_SESSION['timeout'] = time();
                            //$_SESSION['name'] = 'tutorialspoint';
                        }
                    else 
                        {  
                            header('Location: login.php');
                        }
                   }
    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include('general.php');
            putLinks();
        ?>
        <link href='css/login.css' rel='stylesheet' >

        <title>Backoffice Login</title>
    </head>
<body>
  <div class="container">
  <div class="row"><div class='col-lg-1'></div></div>
  <div class="row"><div class='col-lg-1'></div></div>
  <div class="row"><div class='col-lg-1'></div></div>
  <div class="row">
    <div class="col-col-lg-1">
        <header class="site__header island">
            <div class="wrap">
            <span id="animationSandbox" style="display: block;"  class="tada animated">
            <h1 class="site__title mega text-center">Grand Stationery Product Management</h1>
            </span>
            </div>
        </header>
    </div>
  </div>
  
	<div class="row">
		<div class="col-md-4 col-md-offset-4 text-center">
			<div class="search-box">
				<div class="caption">
					<h3>Provide Credentials</h3>
                    <p class="text-capitalize text-center text-danger">Authorized Personnel Only</p>
				</div>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form"
                     method="post" class="loginForm">
					<div class="input-group">
						<input type="text" id="name" name="name" value="tutorialspoint" class="form-control text-center" placeholder="User Name">
						<input type="password" id="paw" name="paw" value="Aa1234567@" class="form-control text-center" placeholder="Password">
						<input type="submit" id="submit" class="form-control" value="Login..." name="submit">
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-4">
			<div class="aro-pswd_info">
				<div id="pswd_info">
					<h4>Password requirements</h4>
					<ul>
						<li id="letter" class="invalid">At least <strong>one letter</strong></li>
						<li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
						<li id="number" class="invalid">At least <strong>one number</strong></li>
						<li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
						<li id="space" class="invalid">be<strong> use [~,!,@,#,$,%,^,&,*,-,=,.,;,']</strong></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>


<?php
    putScripts();
    echo "<script src='js/login.js'></script>";
    stickfooter();
?>
</body>
</html>