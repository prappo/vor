<?php
    session_start();
    if(isset($_SESSION["username"])){
        header('Location: index.php');
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
</head>

<body>
    <div class="container" style="padding-top: 110px">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default" id="box">
                <div align="center">
                    <img src="img/logo.png"></img>
                    </div>
                  <div align="center"><h1 class="black">VOR { }</h1>
                   </div>
                        <div class="panel-body">
                            <form role="form" method="post" action="checklogin.php" id="form">
                                <fieldset>
                                    <div class="form-group">
                                        <input id="username" class="form-control black" placeholder="Username"  type="text" name="username" autofocus>
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
                    <div id="alert">
                        <div data-msg="success" class="alert alert-success login-message    " style="display:none"><i class="close" data-dismiss="alert">&times;</i>Login successful. Redirecting…</div>
                        <div data-msg="error" class="alert alert-danger login-message" style="display:none"><i class="close" data-dismiss="alert">&times;</i>Your username or password is incorrect</div>
                        <div data-msg="empty" class="alert alert-warning login-message" style="display:none"><i class="close" data-dismiss="alert" id="emptyMsg">&times;</i>You must enter username and password</div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/login.js"></script>
</body>
</html>