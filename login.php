<?php
include('lib/auto_load.php');
include('lib/config.php');
if(isset($_SESSION["username"])){
    header('Location: index.php');
}
include('lib/function.php');
 
if(isset($_POST['submit'])) {
    
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);
    $remember = (isset($_POST['remember'])) ? true : false ;

    if(empty($username) || empty($password)) {
        $empty = true;
    } else {
        db_connect();
        $query = "SELECT * FROM vor_admin where username = ? AND password = ?";
        try{
            $result = $pdo->prepare($query);
            $result->bindParam(1, $username);
            $result->bindParam(2, $password);
            $result->execute();
            if($result->rowCount() > 0) {
                session_start();
                $_SESSION["username"] = $_POST["username"];
                $su = true;
                $date = date("l jS \of F Y h:i:s A");
                $content = $username." loged in";
                $ip = $_SERVER['REMOTE_ADDR'];
                $pdo->query("UPDATE vor_admin SET last_login = '{$ip}'");
                
                $pdo->query("INSERT INTO vor_notify(class, content, time, status) VALUES('info', '$content', '$date', 'unread')");
                echo "<meta http-equiv='refresh' content='2;url=index.php'>";
            } else {
                $notFound = true;
            }
        } catch(PDOException $e) {
            echo $e->getMessage().'<br>';
            die();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
</style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User Login</title>
    <style>
    .black{
        color:black;
    }
    </style>

    <!-- css -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/lib/sweet-alert.css">
    <link rel="shortcut icon" href="img/logo.png">
    <!-- javascript -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.ui.shake.js"></script>
    <script src="assets/lib/sweet-alert.min.js"></script> 
    <script type="text/javascript">        
        function success(){
            swal({   title: "Login Success!",   text: "redirecting....",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
        }
   </script>

</head>

<body>
    <div class="container" style="padding-top: 110px">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default" <?php if(isset($notFound) || isset($empty)) { echo 'id="box"'; } ?>>
                <div align="center">
                    <img src="img/logo.png"></img>
                    </div>
                  <div align="center"><h1 class="black">VOR { }</h1>
                   </div>
						<div class="panel-body">
							<form role="form" method="post" action="" id="form">
								<fieldset>
									<div class="form-group">
										<input id="username" class="form-control black" placeholder="Username"  type="text" name="username" <?php if(isset($username)) echo "value='$username'"; ?> autofocus>
									</div>
									<div class="form-group">
										<input id="password" class="form-control black" placeholder="Password" type="password" name="password">
									</div>
									<div>
										<input type="submit" name="submit" value="Login" id="login" class="btn btn-lg btn-success btn-block" id="submit">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
					<div>
						<?php if(isset($empty)) {?><div class="alert alert-warning fade in"><i class="close" data-dismiss="alert">&times;</i>You Must Enter Username and Password</div><?php } ?>
						<?php if(isset($notFound)) {?><div class="alert alert-danger fade in"><i class="close" data-dismiss="alert">&times;</i>Your Username or Password is incorrect</div><?php } ?>
						<?php if(isset($su)){ ?><script>success()</script><?php } ?>
					</div>
                </div>
            </div>
        </div>

        <script>
            $('#box').shake();
        </script>
</body>
</html>