<script>
  function empty() {
    swal({   title: "Error!",   text: "You must enter Name",   type: "error",   confirmButtonText: "OK" , timer: 2500 });
  }

  function success() {
    swal({   title: "Updated!",   text: "Profile updated",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
  }

  function error(){
    swal({   title: "Oops...",   text: "Something went wrong!",   type: "error",   confirmButtonText: "OK" , timer: 1500 });
  }

  function checkInput() {
    name = document.getElementById('name').value;

    if(name == '') {
      empty();
      return false;
    }
  }
</script>

<?php
  require_once 'lib/imageResize.php';

  $rows = end(db_get_where('vor_admin', array('username' => $_SESSION['username'])));
  $image = $rows['image'];

  $image    = 'img/admin/'.$image;
  $real_img = 'img/admin/'.$rows['image'];

  if(!file_exists($image) || empty($rows['image'])) {
    $image = 'img/admin/admin.png';
  }

  if(isset($_POST['updateProfile'])) {
    if(empty($_POST['name'])) {
      echo '<script>empty();</script>';
    } else {
      $image_name = (!empty($_FILES['image']['name'])) ? $_FILES['image']['name'] : NULL;
      $tmp_name   = (!empty($_FILES['image']['tmp_name'])) ? $_FILES['image']['tmp_name'] : NULL;

      $img_location = 'img/admin/'.$image_name;

      if(!empty($image_name)) {
        $mime = getimagesize($tmp_name);

        if(in_array('image', explode('/', $mime['mime']))) {
          move_uploaded_file($tmp_name, $img_location);
          
          $image = new ImageResize($img_location);
          $image->resize(140, 140);
          $image->save();
        }
      }

      $fields = array(
        'full_name' => $_POST['name'],
        'email'     => $_POST['email']
      );

      $where = array(
        'username' => $_SESSION['username']
      );

      if(!empty($image_name)) {
        unlink($real_img);
        $fields['image'] = $image_name;
      }

      $success = db_update('vor_admin', $fields, $where);

      if($success) {
        echo '<script>success();</script>';
        echo "<meta http-equiv='refresh' content='1;url='>";
      } else {
        echo '<script>error();</script>';
        echo "<meta http-equiv='refresh' content='1;url='>";
      }
    }
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
            <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" onsubmit="return checkInput()">
              <div class="form-group">
                <label class="col-lg-2 control-label">Name</label>
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="name" placeholder="<?php echo $rows['full_name']; ?>" value="<?php echo $rows['full_name']; ?>" name="name">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Email</label>
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="email" placeholder="<?php echo $rows['email']; ?>" value="<?php echo $rows['email']; ?>" name="email">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-2 control-label">Change Avatar</label>
                <div class="col-lg-6">
                    <input type="file" name="image" class="file-pos" id="exampleInputFile" accept="image/*">
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <button type="submit" class="btn btn-danger" name="updateProfile">Save</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>
    </aside>
  </div>

  