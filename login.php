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
					<div id="alert">
						<div data-msg="error" class="alert alert-danger" style="display:none"><i class="close" data-dismiss="alert">&times;</i>Your username or password is incorrect</div>
                        <div data-msg="empty" class="alert alert-warning" style="display:none"><i class="close" data-dismiss="alert" id="emptyMsg">&times;</i>You must enter username and password</div>
					</div>
                </div>
            </div>
        </div>

        <script>

            $(function() {
                var alertDiv = $('#alert');
                var form = $('form');
                var btn = form.find('input[type=submit]');
                var errDiv = alertDiv.find('div[data-msg=error]');
                var emptyDiv = alertDiv.find('div[data-msg=empty]');
                
                form.on('submit', function(e) {
                    e.preventDefault();
                    errDiv.hide();
                    emptyDiv.hide();
                    btn.button('loading');
                    
                    var username = form.find('input#username').val();
                    var password = form.find('input#password').val();

                    if(username == '' || password == '') {
                        btn.button('reset');
                        emptyDiv.fadeToggle();
                        $('#box').shake();
                    } else {
                        $.post(form.attr('action'), form.serialize(), function(data) {

                            if(data.message == 1) {
                                success();
                                btn.button('reset');
                                
                                setTimeout(function() {
                                    location.reload(true);
                                }, 1600);
                            } else if(data.message == 0){
                                btn.button('reset');
                                errDiv.fadeToggle();
                                $('#box').shake();
                            }
                        }, 'json');
                    }
                });
            })
        </script>
</body>
</html>