<?php
  $rows = db_get_where('vor_admin', array('username' => $_SESSION['username']));
?>
<div class="row">
  <aside class="profile-nav col-lg-3">
    <section class="panel">
      <div class="user-heading round">
        <a href="#">
          <img src="<?php if(file_exists('img/admin/avatar.jpg')) { echo 'img/admin/avatar.jpg'; } else { echo 'https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg'; } ?>" alt="">
        </a>
        <h1><?php echo $rows[0]['full_name']; ?></h1>
        <p><?php echo $rows[0]['email']; ?></p>
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
                <p><span>First Name </span>: Jonathan</p>
              </div>
              <div class="bio-row">
                <p><span>Last Name </span>: Smith</p>
              </div>
              <div class="bio-row">
                <p><span>Country </span>: Australia</p>
              </div>
              <div class="bio-row">
                <p><span>Birthday</span>: 13 July 1983</p>
              </div>
              <div class="bio-row">
                <p><span>Occupation </span>: UI Designer</p>
              </div>
              <div class="bio-row">
                <p><span>Email </span>: jsmith@flatlab.com</p>
              </div>
              <div class="bio-row">
                <p><span>Mobile </span>: (12) 03 4567890</p>
              </div>
              <div class="bio-row">
                <p><span>Phone </span>: 88 (02) 123456</p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </aside>
</div>