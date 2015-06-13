<?php

if(file_exists('config.php'))
{

header('Location:../login.php');

}
else
{
	include 'function.php'
?>

<!DOCTYPE html>
<html>
<head>
	<title>Install VOR {}</title>
 <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/lib/sweet-alert.css">
     <script src="../assets/lib/sweet-alert.min.js"></script>

    <script>

    function installed(){

      swal({   title: "Installed",   text: "Now you can use VOR{}",   imageUrl: "img/up.jpg" });
    }

    </script>


    <script type="text/JavaScript">
function timeRefresh(timeoutPeriod) 
{
  setTimeout("location.reload(true);",timeoutPeriod);
}
</script>
</head>

<body class="login-body">

    <div class="container">

      <form class="form-signin" method="post" >
        <h2 class="form-signin-heading">Install VOR {}</h2>
        <div class="login-wrap">
            <input type="text" class="form-control" placeholder="Host Name, Ex : localhost"  autofocus name="host">
           
          
            <input type="text" class="form-control" placeholder="Database Name"  autofocus name="db_name">
            <input type="text" class="form-control" placeholder="User Name"  autofocus name="user">

            <input type="password" class="form-control" placeholder="Password" name="pass">
          
            <button class="btn btn-lg btn-login btn-block" type="submit" name="install">Install Now</button>
        
     

        </div>
  <?php
    if(isset($_POST['install']))
    {	

      $host 	= sanitize($_POST['host']);
      $user 	= sanitize($_POST['user']);
      $pass 	= sanitize($_POST['pass']);
      $db_name 	= sanitize($_POST['db_name']);

    	if($host=='')
    	{
    		echo "<center><div class=\"alert alert-warning fade in\"><i class=\"close\" data-dismiss=\"alert\">&times;</i>Enter host name</div></center>";
    	}
    	elseif ($user =='') {
    		echo "<center><div class=\"alert alert-warning fade in\"><i class=\"close\" data-dismiss=\"alert\">&times;</i>Enter Username</div></center>";
    	}
    	elseif($db_name=='')
    	{
    		echo "<center><div class=\"alert alert-warning fade in\"><i class=\"close\" data-dismiss=\"alert\">&times;</i>Enter Database Name</div></center>";
    	}
    	else
    	{
			$con = mysql_connect($host, $user, $pass) or die(mysql_error());

			if($con) {
				$query = "CREATE TABLE IF NOT EXISTS `vor_admin` (
				`id` int(11) NOT NULL,
                `full_name` varchar(30) NOT NULL,
                `username` varchar(30) NOT NULL,
                `password` varchar(200) NOT NULL,
                `type` varchar(10) NOT NULL,
                `email` varchar(30) NOT NULL,
                `last_login` varchar(15) NOT NULL,
                `registration_date` date NOT NULL,
                `image` varchar(1000) NOT NULL
              ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

              INSERT INTO `vor_admin` (`id`, `full_name`, `username`, `password`, `type`, `email`, `last_login`, `registration_date`, `image`) VALUES
              (1, 'Admin', 'admin', 'admin', 'admin', 'admin@mail.com', '', CURRENT_TIMESTAMP, 'admin_1.jpg');

              CREATE TABLE IF NOT EXISTS `vor_notify` (
              `id` int(50) NOT NULL,
                `class` varchar(20) NOT NULL,
                `content` varchar(50) NOT NULL,
                `time` varchar(50) NOT NULL,
                `status` varchar(10) NOT NULL
              ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

              CREATE TABLE IF NOT EXISTS `vor_settings` (
                `id` int(12) NOT NULL,
                `notify` varchar(10) NOT NULL,
                `home` varchar(255) NOT NULL,
                `header` varchar(20) NOT NULL,
                `foot` varchar(100) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

              INSERT INTO `vor_settings` (`id`, `notify`, `home`, `header`, `foot`) VALUES
              (1, 'on', '', 'My <span> Softwre ', '');

              ALTER TABLE `vor_admin`
               ADD PRIMARY KEY (`id`);

              ALTER TABLE `vor_notify`
               ADD PRIMARY KEY (`id`);

              ALTER TABLE `vor_settings`
               ADD PRIMARY KEY (`id`);";

    		$config = "<?php
  (!defined('HOST')) ? define('HOST', '".$host."') : NULL;
  (!defined('USER')) ? define('USER', '".$user."') : NULL;
  (!defined('PASS')) ? define('PASS', '".$pass."') : NULL;
  (!defined('DB')) ? define('DB', '".$db_name."') : NULL;
?>";

			mysql_query($query);

			$myfile = fopen("config.php", "w") or die("<div class='alert alert-block alert-danger fade in'>but unable to create config file .Permission forbidden <br>Please make config.php file with following code in lib folder</div> <br> <textarea class='form-control' rows='7'>$config</textarea>");

			$action = fwrite($myfile, $config);

			if($action) {
			  echo "<div><script>installed(); timeRefresh(1500)</script></div>";
			}
			}
		}
	}

        ?>
       
      </form>
 

    </div>



   
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>



  </body>
</html>

<?php
}

?>
