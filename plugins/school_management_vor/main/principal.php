<script>
  function update_success(){
    swal({   title: "Updated!",   text: "Principal's Profile updated",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
  }

  function update_error(){
    swal({   title: "Oops...",   text: "Something went wrong!",   type: "error",   confirmButtonText: "OK" , timer: 1500 });
  }

  function img_update_error(){
    swal({   title: "Error!",   text: "File not supported",   type: "error",   confirmButtonText: "OK" , timer: 1500 });
  }
</script>

<?php
  require 'imageResize.php';

  $row = db_get('scl_principal');
  $plugin_path = plugin_path('school_management_vor');
  $image = (file_exists($plugin_path.'images/scl_principal/principal.jpg')) ? $plugin_path.'images/scl_principal/principal.jpg' : $plugin_path.'images/default_image.jpg' ;

  if(is_admin()) {
    if(isset($_POST['send_principal_data'])) {
      $image_name = $_FILES['edit-principal-image']['name'];
      $tmp_name   = $_FILES['edit-principal-image']['tmp_name'];

      $fields = array(
        'id'            => (isset($_POST[0]['id'])) ? $_POST[0]['id'] : '',
        'name_title'    => $_POST['name_title'],
        'first_name'    => $_POST['first_name'],
        'last_name'     => $_POST['last_name'],
        'nationality'   => $_POST['nationality'],
        'gender'        => $_POST['gender'],
        'address'       => $_POST['address'],
        'qualification' => $_POST['qualification'],
        'date_of_birth' => $_POST['date_of_birth'],
        'joining_date'  => $_POST['joining_date'],
        'mobile'        => $_POST['mobile'],
        'email'         => $_POST['email'],
        'about'         => $_POST['about']
      );

      $where = array(
        'id' => (isset($_POST[0]['id'])) ? $_POST[0]['id'] : NULL
      );

      $success = db_update('scl_principal', $fields, $where);

      if($success) {
        echo '<script>update_success();</script>';
        echo "<meta http-equiv='refresh' content='2;url='>";
      } else {
        echo '<script>update_error();</script>';
      }
      
      if(isset($image_name) && !empty($image_name)) {
        $mime = getimagesize($tmp_name);

        if(in_array('image', explode('/', $mime['mime']))) {

          $principal_img_location = $plugin_path.'images/scl_principal/principal.jpg';

          move_uploaded_file($tmp_name, $principal_img_location);
          
          $image = new ImageResize($principal_img_location);
          $image->resize(140, 140);
          $image->save();
        } else {
          echo '<script>img_update_error();</script>';
        }
      }
    }
  }

?>

<section>
    <div class="row">
        <aside class="profile-nav col-lg-3">
            <section class="panel">
                <div class="user-heading round">
                    <a>
                        <img src="<?php echo $image; ?>" alt="avatar">
                    </a>
                    <h1><?php echo $row[0]['name_title'].' '.$row[0]['first_name']; ?></h1>
                    <p><?php echo $row[0]['email']; ?></p>
                </div>

                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a><i class="fa fa-user"></i> Profile</a></li>
                    <?php if(is_admin()) echo '<li><a href="" data-toggle="modal" data-target="#edit"><i class="fa fa-edit"></i> Edit profile</a></li>'; ?>
                </ul>

            </section>
        </aside>
        <aside class="profile-info col-lg-9">
          <section class="panel">
              <div class="bio-graph-heading">
                  <?php echo $row[0]['about']; ?>
              </div>
              <div class="panel-body bio-graph-info">
                  <h1>Bio Graph</h1>
                  <div class="row">
                      <div class="bio-row">
                          <p><span>First Name </span>: <?php echo $row[0]['first_name']; ?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Last Name </span>: <?php echo $row[0]['last_name']; ?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Nationality </span>: <?php echo $row[0]['nationality']; ?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Gender </span>: <?php echo $row[0]['gender']; ?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Address </span>: <?php echo $row[0]['address']; ?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Qualification </span>: <?php echo $row[0]['qualification']; ?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Date of Birth </span>: <?php echo $row[0]['date_of_birth']; ?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Joining Date </span>: <?php echo $row[0]['joining_date']; ?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Mobile </span>: <?php echo $row[0]['mobile']; ?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Email </span>: <?php echo $row[0]['email']; ?></p>
                      </div>
                  </div>
              </div>
            </section>
        </aside>
    </div>
  </section>

  <?php
    if(is_admin()) {
  ?>

  <!--Edit Modal-->
  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
        </div>
        <div class="modal-body">
            <div class="row">

                <!-- left column -->
                <div class="col-md-3">
                  <div class="text-center">
                    <img src="<?php echo $image; ?>" class="avatar img-circle" alt="avatar" width="100px" height="100px">
                  </div>
                </div>
                
                <!-- edit form column -->
                <div class="col-md-9 personal-info">
                  <form class="form-horizontal" id="principal_edit_form" role="form" method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="name_title">Name Title:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="name_title" type="text" name="name_title" value="<?php echo $row[0]['name_title']; ?>">
                      </div>
                    </div>
                      <div class="form-group">
                      <label class="col-lg-3 control-label" for="first_name">First name:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="first_name" type="text" name="first_name" value="<?php echo $row[0]['first_name']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="last_name">Last name:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="last_name" type="text" name="last_name" value="<?php echo $row[0]['last_name']; ?>">
                      </div>
                    </div>
                   <div class="form-group">
                      <label class="col-lg-3 control-label" for="nationality">Nationality:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="nationality" type="text" name="nationality" value="<?php echo $row[0]['nationality']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="gender">Gender:</label>
                      <div class="col-lg-4">
                        <select name="gender" class="form-control" id="gender">
                          <optgroup label="Select Gender">
                            <?php
                              $default = $row[0]['gender'];
                              if(strtolower($default) == 'female') {
                                echo
                                  '<option value="Female">Female</option>
                                  <option value="Male">Male</option>';
                              } else {
                                echo
                                  '<option value="Male">Male</option>
                                  <option value="Female">Female</option>
                                  ';
                              }
                            ?>
                        </optgroup>
                      </select>
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="col-lg-3 control-label" for="address">Address:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="address" type="text" name="address" value="<?php echo $row[0]['address']; ?>">
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="col-lg-3 control-label" for="qualification">Qualification:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="qualification" type="text" name="qualification" value="<?php echo $row[0]['qualification']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="date_of_birth">Date of Birth:</label>
                      <div class="col-lg-8" id="datepick">
                        <input class="form-control" id="date_of_birth" type="text" name="date_of_birth" value="<?php echo $row[0]['date_of_birth']; ?>">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="joining_date">Joining Date:</label>
                      <div class="col-md-8" id="datepick">
                        <input class="form-control" id="joining_date" type="text" name="joining_date" value="<?php echo $row[0]['joining_date']; ?>">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="mobile">Mobile:</label>
                      <div class="col-md-8">
                        <input class="form-control" id="mobile" type="text" name="mobile" value="<?php echo $row[0]['mobile']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="email">Email:</label>
                      <div class="col-md-8">
                        <input class="form-control" id="email" type="text" name="email" value="<?php echo $row[0]['email']; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="about">About:</label>
                      <div class="col-md-8">
                        <textarea name="about" id="about" class="form-control"><?php echo $row[0]['about']; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="photo">Photo:</label>
                      <div class="col-md-8">
                        <input type="file" name="edit-principal-image" class="form-control" id="photo" accept="image/*">
                      </div>
                    </div>
                </div>
            </div>
          </div>
        <div class="modal-footer">
            <input type="hidden" name="id" value="<?php echo $row[0]['id']; ?>">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="send_principal_data" name="send_principal_data">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php
  }