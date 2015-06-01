<?php debug_backtrace() || die ("Direct access not permitted."); ?>

<?php
if(!is_admin()) {
  exit();
}

if(isset($_POST['add-new-student'])) {
  require_once 'imageResize.php';

  $image_name = (!empty($_FILES['new-student-image']['name'])) ? $_FILES['new-student-image']['name'] : NULL;
  $tmp_name   = (!empty($_FILES['new-student-image']['tmp_name'])) ? $_FILES['new-student-image']['tmp_name'] : NULL;

  $rand_img  = rand(1000,9999).'.jpg';

  $plug_path = plugin_path('school_management_vor');
  $students_img_location = $plug_path.'images/scl_students/'.$rand_img;

  if(!empty($image_name)) {
    $mime = getimagesize($tmp_name);

    if(in_array('image', explode('/', $mime['mime']))) {
      move_uploaded_file($tmp_name, $students_img_location);
      
      $image = new ImageResize($students_img_location);
      $image->resize(140, 140);
      $image->save();
    }
  }

  $fields = array(
    'id'            => NULL,
    'name'          => $_POST['name'],
    'class'         => $_POST['class'],
    'roll'          => $_POST['roll'],
    'gender'        => $_POST['gender'],
    'address'       => $_POST['address'],
    'date_of_birth' => $_POST['date_of_birth'],
    'mobile'        => $_POST['mobile'],
    'email'         => $_POST['email']
  );

  if(!empty($image_name)) {
    $fields['image'] = $rand_img;
  }
  
  $success = db_insert('scl_students', $fields);

  if($success) {
    echo '<script>std_add_success();</script>';
  } else {
      echo '<script>error();</script>';
  }
}
?>

<div class="row">
  <div class="col-lg-12">
      <section class="panel">
          <header class="panel-heading">Add new Student</header>
          <div class="panel-body">
              <form class="form-horizontal tasi-form" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Student Name</label>
                      <div class="col-sm-10">
                          <input class="form-control" id="name" type="text" name="name" placeholder="Enter Name">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Class</label>
                      <div class="col-sm-10">
                          <input class="form-control" id="class" type="text" name="class" placeholder="Enter Class">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Roll</label>
                      <div class="col-sm-10">
                          <input class="form-control" id="roll" type="text" name="roll" placeholder="Enter Roll">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Gender</label>
                      <div class="col-sm-10">
                          <select name="gender" class="form-control" id="gender">
                            <optgroup label="Select Gender">
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                          </optgroup>
                        </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Address</label>
                      <div class="col-sm-10">
                          <input class="form-control" id="address" type="text" name="address" placeholder="Enter Address">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Date of Birth</label>
                      <div class="col-sm-10" id="datepick">
                          <input class="form-control" id="date_of_birth" type="text" name="date_of_birth" placeholder="Pick Date of Birth">
                          <i class="fa fa-calendar"></i>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Mobile</label>
                      <div class="col-sm-10">
                          <input class="form-control" id="mobile" type="text" name="mobile" placeholder="Enter Mobile Number">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Email</label>
                      <div class="col-sm-10">
                          <input class="form-control" id="email" type="text" name="email" placeholder="Enter Email">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Image</label>
                      <div class="col-sm-10">
                          <input type="file" name="new-student-image" class="form-control" id="photo" accept="image/*">
                      </div>
                  </div>

                  <div class="pull-right" style="width:100%">
					           <input type="submit" name="add-new-student" class="btn pull-right add-new-full form-control" value="Add New Student">
				          </div>
            </div>
          </form>
        </div>
      </section>
    </div>
</div>