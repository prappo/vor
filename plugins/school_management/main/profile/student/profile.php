<?php
  $username = $_SESSION['username'];
  preg_match("/student_(.*)/", $username, $student_id);
  $student_id = $student_id[1];

  $rows = db_get_where('scl_students', array('id' => $student_id));
?>
<div class="row">
  <aside class="profile-nav col-lg-3">
    <section class="panel">
      <div class="user-heading round">
        <a href="#">
          <img src="<?php if(file_exists('img/admin/avatar.jpg')) { echo 'img/admin/avatar.jpg'; } else { echo 'https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg'; } ?>" alt="">
        </a>
        <h1><?php echo $rows[0]['name']; ?></h1>
        <p><?php echo $rows[0]['email']; ?></p>
      </div>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="profile"> <i class="fa fa-user"></i> Profile</a></li>
        <li><a href="change_password"> <i class="fa fa-lock"></i> Change Password</a></li>
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
                <p><span>First Name </span>: <?php echo $rows[0]['name']; ?></p>
              </div>
              <div class="bio-row">
                <p><span>Class </span>: <?php echo $rows[0]['class']; ?></p>
              </div>
              <div class="bio-row">
                <p><span>Roll </span>: <?php echo $rows[0]['roll']; ?></p>
              </div>
              <div class="bio-row">
                <p><span>Gender</span>: <?php echo $rows[0]['gender']; ?></p>
              </div>
              <div class="bio-row">
                <p><span>Address </span>: <?php echo $rows[0]['address']; ?></p>
              </div>
              <div class="bio-row">
                <p><span>Date of Birth </span>: <?php echo $rows[0]['date_of_birth']; ?></p>
              </div>
              <div class="bio-row">
                <p><span>Mobile </span>: <?php echo $rows[0]['mobile']; ?></p>
              </div>
              <div class="bio-row">
                <p><span>Email </span>: <?php echo $rows[0]['email']; ?></p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </aside>
</div>