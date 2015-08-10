<?php
  $rows = end(db_get_where('vor_admin', array('username' => $_SESSION['username'])));
  $image = $rows['image'];
  $image = 'img/admin/'.$image;

  if(!file_exists($image) || empty($rows['image'])) {
    $image = 'img/admin/admin.png';
  }
?>
<div class="row">
  <aside class="profile-nav col-lg-3">
    <section class="panel">
      <div class="user-heading round">
        <a href="#">
          <img src="<?php echo $image; ?>" alt="">
        </a>
        <h1><?php echo $rows['full_name']; ?></h1>
        <p><?php echo $rows['email']; ?></p>
      </div>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="profile"> <i class="fa fa-user"></i> Profile</a></li>
        <li><a href="change_password"> <i class="fa fa-lock"></i> Change Password</a></li>
        <li><a href="edit_profile"> <i class="fa fa-edit"></i> Edit profile</a></li>
      </ul>
    </section>
  </aside>
  <aside class="profile-info col-lg-9">
    <section>
      <div class="panel panel-primary">
        <div class="panel-heading">Profile information</div>
        <div class="panel-body">
          <div class="panel-body bio-graph-info">
            <div class="row">
              <div class="bio-row">
                <p><span>Username </span>: <?php echo  $rows['username']?></p>
              </div>
              <div class="bio-row">
                <p><span>Name </span>: <?php echo  $rows['full_name']?></p>
              </div>
              <div class="bio-row">
                <p><span>User Type </span>: <?php echo  $rows['type']?></p>
              </div>
              <div class="bio-row">
                <p><span>Email</span>: <?php echo  $rows['email']?></p>
              </div>
              <div class="bio-row">
                <p><span>Last login IP </span>: <?php echo  $rows['last_login']?></p>
              </div>
              <div class="bio-row">
                <p><span>Registration Date </span>: <?php echo  $rows['registration_date']?></p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </aside>
</div>