<?php 
//include 'config.php';



$page = new R();

$page->a('/a', 'callbackFunction');

$page->a('/settings', function(){
include('lib/settings.php');

});
$page->a('/404', function(){
echo "404 page not found";
}); 

$page->a('/b', function(){
    echo 'Hello B';
});
 
$page->a('/', function(){
    include('home.php');
});
 
 $page->a('/home', function(){
    include('home.php');
});

$page->a('/backup', function(){
if(user_type()=='admin'){
  include('backup.php');
}
else{
  echo "forbidden";
}
});

$page->a('/logout', function(){
session_destroy();
echo "<script>logout();</script>";
echo " <meta http-equiv='refresh' content='2;url=index.php'>";


});

// profile area start

$page->a('/profile', function(){
  if(isset($_SESSION['username'])) {
    include_once 'profile/profile.php';
  } else {
    echo 'something went wrong';
  }
});

$page->a('/edit_profile', function(){
  include_once 'profile/edit_profile.php';
});

$page->a('/change_password', function(){
  include_once 'profile/change_password.php';
});

// profile area end

//notification page
 $page->a('/notification', function(){

  $user = $_SESSION['username'];

mysql_connect(HOST, USER, PASS) or die ("can't connect <br>");
mysql_select_db(DB) or die ("Can't counnect to database<br>");
$sql = "SELECT * FROM vor_admin WHERE username = '$user'";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
$type =  $row['type'];

if($type == 'admin')
{

include('notification.php');
}
else
{ echo "Forbidden";}
});





 $page->a('/status', function(){
include('status.php');

 });


$page->a('/active_plugins_list', function(){
$user = $_SESSION['username'];

mysql_connect(HOST, USER, PASS) or die (mysql_error());
mysql_select_db(DB) or die (mysql_error());
$sql = "SELECT * FROM vor_admin WHERE username = '$user'";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
$type =  $row['type'];

if($type == 'admin')
{


$count = 0;
 	$plugin_dir = "./plugins/";
 	$plugin_list = glob($plugin_dir."*_vor/vor.json");

  $total_plugins = count($plugin_list);

  ?>

  <div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
      <section class="panel">
        <div class="symbol blue">
          <i class="fa fa-puzzle-piece"></i>
        </div>
        <div class="value">
          <h1 class="count"><?php echo $total_plugins; ?></h1>
          <p><?php echo ($total_plugins > 1) ? 'plugins' : 'plugin' ; ?> found</p>
        </div>
      </section>
    </div>
  </div>

<?php
 	foreach($plugin_list as $all_plugin)
 	{
 		
 		$string = file_get_contents($all_plugin);
		$json_a = json_decode($string,true);

    $path = $_SERVER['SCRIPT_FILENAME'];
    $script_path = str_replace('index.php','',$path);
   
    $plug_link = str_replace('vor.json', '',$all_plugin);
    $final_plug_link = str_replace("./","",$plug_link);
    $old_path = $script_path. $final_plug_link;
    $new_path = str_replace('_vor','',$old_path);


?>
 <script type="text/javascript">        
        function done(){
            swal({   title: "Done !",   text: "Your settings are updated successfully",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
           
        }
        function reload(){
          location.reload();
        }
   </script>
<section class="panel">
                          <header class="panel-heading tab-bg-dark-navy-blue tab-right ">
                              <ul class="nav nav-tabs pull-right">
                                  <li class="active">
                                      <a data-toggle="tab" href="#home-<?php echo $count;?>">
                                          <i class="fa fa-home"></i>
                                      </a>
                                  </li>
                                  <li class="">
                                      <a data-toggle="tab" href="#about-<?php echo $count;?>">
                                          <i class="fa fa-star"></i>
                                          Details
                                      </a>
                                  </li>
                                  <li class="">
                                      <a data-toggle="tab" href="#contact-<?php echo $count;?>">
                                          <i class="fa  fa-cog"></i>
                                          Settings
                                      </a>
                                  </li>
                              </ul>
                              <span class="hidden-sm wht-color"><?php echo  $json_a['Plugin Name']; ?></span>
                          </header>
                          <div class="panel-body">
                              <div class="tab-content">
                                  <div id="home-<?php echo $count;?>" class="tab-pane active">
                                      Plugin Name : <?php echo  $json_a['Plugin Name']; ?> <br>
                                      Author : <?php echo  $json_a['Author']; ?> <br>
                                      Status :  <span class="label label-success">Active</span> <br><br>
                                     
                                    

                                  </div>
                                  <div id="about-<?php echo $count;?>" class="tab-pane"><?php echo $json_a['Details']; ?></div>
                                  <div id="contact-<?php echo $count;?>" class="tab-pane"><h5>Settings</h5>
                                  <form method="post">
                                  <input type="hidden" value="<?php echo $old_path; ?>" name="old">
                                  <input type="hidden" value="<?php echo $new_path; ?>" name = "new">
                                  <input type="submit" class="btn btn-danger" value="Deactive" name="deactive">
                                  </form>

                                  </div>
                              </div>
                          </div>
                      </section>


<?php
$count++;
  }

  if(isset($_POST['deactive']))
  {
    $html_old = $_POST['old'];
    $html_new = $_POST['new'];
    $do = rename($html_old,$html_new);
    if($do)
    {
      echo "<script> done();</script>";
                              echo "<meta http-equiv='refresh' content='1.5; url=active_plugins_list' />";

    }
    else { echo "Error while working . May be permission denied";}
  }
 }
 else
  { echo "forbidden";}

 });

// all plugins page

$page->a('/plugins_list', function(){

  $user = $_SESSION['username'];

mysql_connect(HOST, USER, PASS) or die (mysql_error());
mysql_select_db(DB) or die (mysql_error());
$sql = "SELECT * FROM vor_admin WHERE username = '$user'";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
$type =  $row['type'];

if($type == 'admin')
{


$count = 0;
  $plugin_dir = "./plugins/";
  $plugin_list = glob($plugin_dir."*/vor.json");

  $total_plugins = count($plugin_list);

  ?>

    <div class="row state-overview">
      <div class="col-lg-3 col-sm-6">
        <section class="panel">
          <div class="symbol blue">
            <i class="fa fa-puzzle-piece"></i>
          </div>
          <div class="value">
            <h1 class="count"><?php echo $total_plugins; ?></h1>
            <p><?php echo ($total_plugins > 1) ? 'plugins' : 'plugin' ; ?> found</p>
          </div>
        </section>
      </div>
    </div>

  <?php
  foreach($plugin_list as $all_plugin)
  {
    
    $string = file_get_contents($all_plugin);
    $json_a=json_decode($string,true);

   $path = $_SERVER['SCRIPT_FILENAME'];
   $script_path = str_replace('index.php','',$path);
   
   $plug_link = str_replace('vor.json', '',$all_plugin);
   $old_path  = $script_path. str_replace("./","",$plug_link);
   
   $ex_path   = substr($old_path,0,-1);
   $new_path  = $ex_path."_vor/";
   


?>
 <script type="text/javascript">        
        function done(){
            swal({   title: "Done !",   text: "Your settings are updated successfully",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
           
        }
        function reload(){
          location.reload();
        }
   </script>
<section class="panel">
                          <header class="panel-heading tab-bg-dark-navy-blue tab-right ">
                              <ul class="nav nav-tabs pull-right">
                                  <li class="active">
                                      <a data-toggle="tab" href="#home-<?php echo $count;?>">
                                          <i class="fa fa-home"></i>
                                      </a>
                                  </li>
                                  <li class="">
                                      <a data-toggle="tab" href="#about-<?php echo $count;?>">
                                          <i class="fa fa-star"></i>
                                          Details
                                      </a>
                                  </li>
                                  <li class="">
                                      <a data-toggle="tab" href="#contact-<?php echo $count;?>">
                                          <i class="fa  fa-cog"></i>
                                          Settings
                                      </a>
                                  </li>
                              </ul>
                              <span class="hidden-sm wht-color"><?php echo  $json_a['Plugin Name']; ?></span>
                          </header>
                          <div class="panel-body">
                              <div class="tab-content">
                                  <div id="home-<?php echo $count;?>" class="tab-pane active">
                                      Plugin Name : <?php echo  $json_a['Plugin Name']; ?> <br>
                                      Author : <?php echo  $json_a['Author']; ?> <br>
                                      
                                     
                                    

                                  </div>
                                  <div id="about-<?php echo $count;?>" class="tab-pane"><?php echo $json_a['Details']; ?></div>
                                  <div id="contact-<?php echo $count;?>" class="tab-pane"><h5>Settings</h5>
                                  <form method="post">
                                  <input type="hidden" value="<?php echo $old_path; ?>" name="old">
                                  <input type="hidden" value="<?php echo $new_path; ?>" name = "new">
                                  <input type="submit" class="btn btn-success" value="Active now" name="active">
                                  </form>

                                  </div>
                              </div>
                          </div>
                      </section>


<?php   
$count++;
  }
  if(isset($_POST['active']))
  {
    $html_old = $_POST['old'];
    $html_new = $_POST['new'];
    $do = rename($html_old,$html_new);
    if($do)
    {
      echo "<script> done();</script>";
                              echo "<meta http-equiv='refresh' content='1.5; url=plugins_list' />";

    }
    else { echo "Error while working . May be permission denied";}
  }
 }
 else
  { echo "forbidden";}

 });

// add new plugins

$page->a('/add_plugins' , function(){

$user = $_SESSION['username'];

mysql_connect(HOST, USER, PASS) or die ("can't connect <br>");
mysql_select_db(DB) or die ("Can't counnect to database<br>");
$sql = "SELECT * FROM vor_admin WHERE username = '$user'";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
$type =  $row['type'];


if($type == 'admin')

	{include('plugins.php');}
else { echo "forbidden";}
});
//browser
$page->a('/vor_browsr', function(){
?>
<iframe src="filebrowser/find.php" width="1000" height="430">Error ! , VOR could not open file browser</iframe>

<?php
});
//about page

$page->a('/about', function(){

echo "About section here";

});
$page->a('/soft_settings', function(){
$user = $_SESSION['username'];

mysql_connect(HOST, USER, PASS) or die ("can't connect <br>");
mysql_select_db(DB) or die ("Can't counnect to database<br>");
$sql = "SELECT * FROM vor_admin WHERE username = '$user'";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
$type =  $row['type'];

if($type == 'admin')
{


include('settings.php');
}
else {echo "forbidden";}
});
include('template/head.php');
include('template/body_ek.php');

echo " <li>
<a href='home'><i class='fa fa-dashboard'></i> Dashboard</a>
</li>";

$content = "";
require_once("upadan.php");
add_menu('vor_browsr', 'File Browser', 'folder');

$type = user_type();
if($type == 'admin')
{



menu_start('', 'Pluings', 'puzzle-piece');
add_menu('add_plugins', 'Add Plugins', 'plus');
add_menu('active_plugins_list', 'Active Plugins List', 'list');
add_menu('plugins_list', 'All Plugins List', 'list');
menu_end();

menu_start('','Settings','cogs');
add_menu('profile','Profile', 'user');
add_menu('soft_settings', 'Software', 'rocket');
add_menu('backup', 'Backup', 'cloud-download');
menu_end();

add_menu('about', 'About', 'circle');
}

include('template/body_dui.php');
include('template/body_tin.php');

$page->a('/c', [new Foo, 'bar']);

$page->a('/c/d', [new Foo, 'bar']);

$page->e();




include('template/body_char.php');
include('template/foot.php');
function callbackFunction(){
   echo "prappo prince";
}
 
class Foo{
    function bar(){
        echo 'Hello Bar';
    }
}

 ?>
