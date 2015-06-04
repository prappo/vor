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
        <li><a href="profile"> <i class="fa fa-user"></i> Profile</a></li>
        <li><a href="change_password"> <i class="fa fa-lock"></i> Change Password</a></li>
        <li class="active"><a href="edit_profile"> <i class="fa fa-edit"></i> Edit profile</a></li>
      </ul>
    </section>
  </aside>
  <aside class="profile-info col-lg-9">
    <section>
      <div class="panel panel-primary">
        <div class="panel-heading"> Edit your profile information</div>
        <div class="panel-body">
          <div class="panel-body bio-graph-info">
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <label class="col-lg-2 control-label">First Name</label>
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="f-name" placeholder=" ">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Last Name</label>
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="l-name" placeholder=" ">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Country</label>
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="c-name" placeholder=" ">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Birthday</label>
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="b-day" placeholder=" ">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Occupation</label>
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="occupation" placeholder=" ">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Email</label>
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="email" placeholder=" ">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Mobile</label>
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="mobile" placeholder=" ">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Change Avatar</label>
                <div class="col-lg-6">
                  <input type="file" class="file-pos" id="exampleInputFile">
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <button type="submit" class="btn btn-danger">Save</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>
    </aside>
  </div>