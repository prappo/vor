<?php debug_backtrace() || die ("Direct access not permitted."); ?>

<?php
$pdo = db_connect();
$rows = db_get('scl_students');
$plug_path = plugin_path('school_management_vor');

require 'imageResize.php';

$db_ids = array();

foreach($rows as $row) {
  $db_ids[] = $row['image'];
}

$accs = db_get('vor_admin');

$db_accs = array();

foreach($accs as $acc) {
  $db_accs[] = $acc['image'];
}

$image_id_dir  = $plug_path.'images/scl_students/';
$image_acc_dir = 'img/admin/';

$stored_id_images  = glob($image_id_dir.'*.jpg');
$stored_acc_images = glob($image_acc_dir.'*.jpg');

$def_image = array_search('img/admin/default_image.jpg', $stored_acc_images);
unset($stored_acc_images[$def_image]);

if(!empty($stored_id_images)) {
  $stored_image_m = array();

  foreach ($stored_id_images as $stored_image) {
    $stored_image_m[] = basename($stored_image);
  }

  foreach($stored_image_m as $stored_image_h) {
    if(!in_array($stored_image_h, $db_ids)) {
      unlink($image_id_dir.$stored_image_h);
    }
  }
}

if(!empty($stored_acc_images)) {
  $stored_image_p = array();

  foreach ($stored_acc_images as $stored_image) {
    $stored_image_p[] = basename($stored_image);
  }

  foreach($stored_image_p as $stored_image_l) {
    if(!in_array($stored_image_l, $db_accs)) {
      unlink($image_acc_dir.$stored_image_l);
    }
  }
}

if(is_admin()) {
  if(isset($_POST['add_student'])) {
    if(empty($_POST['name']) || empty($_POST['class']) || empty($_POST['roll'])) {
      echo '<script>std_empty();</script>';
      echo "<meta http-equiv='refresh' content='1;url='>";
      exit();
    }

    $image_name = (!empty($_FILES['new-student-image']['name'])) ? $_FILES['new-student-image']['name'] : NULL;
    $tmp_name   = (!empty($_FILES['new-student-image']['tmp_name'])) ? $_FILES['new-student-image']['tmp_name'] : NULL;

    $rand_img = (!empty($image_name)) ? rand(1000,9999).'.jpg' : '';
    $students_img_location = $plug_path.'images/scl_students/'.$rand_img;

    if(!empty($image_name)) {
      $mime = getimagesize($tmp_name);

      if(in_array('image', explode('/', $mime['mime']))) {
        move_uploaded_file($tmp_name, $students_img_location);
        
        $image = new ImageResize($students_img_location);
        $image->resize(140, 140);
        $image->save();

        copy($students_img_location, 'img/admin/student_'.$rand_img);
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

    if(isset($image_name)) {
      $fields['image'] = $rand_img;
    }

    if(db_insert('scl_students', $fields)) {
      foreach($pdo->query('SELECT MAX(id) FROM `scl_students`') as $student_account_id) {
        $student_account = $student_account_id['0'];
      }

      $fields = array(
        'id'    => NULL,
        'full_name'         => $_POST['name'],
        'username'          => 'student_'.$student_account,
        'password'          => 'student_'.$student_account,
        'type'              => 'student',
        'email'             => $_POST['email'],
        'last_login'        => NULL,
        'registration_date' => date("Y-m-d")
        );

      if(isset($image_name)) {
        $student_acc_img = 'student_'.$rand_img;
        $fields['image'] = $student_acc_img;
      }

      $success = db_insert('vor_admin', $fields);
    }

    if($success) {
      echo '<script>std_add_success();</script>';
      echo '<div class="alert alert-success fade in"><i class="close" data-dismiss="alert">&times;</i>Student account created with username <strong>student_'.$student_account.'</strong> and password <strong>student_'.$student_account.'</strong></div>';
      echo "<meta http-equiv='refresh' content='5;url='>";
    } else {
      echo '<script>error();</script>';
    }
  }

  if(isset($_POST['send_students_data'])) {
    if(empty($_POST['name']) || empty($_POST['class']) || empty($_POST['roll'])) {
      echo '<script>std_empty();</script>';
      echo "<meta http-equiv='refresh' content='1;url='>";
      exit();
    }

    $image_name = (isset($_FILES['edit-students-image']['name'])) ? $_FILES['edit-students-image']['name'] : NULL;
    $tmp_name   = (isset($_FILES['edit-students-image']['tmp_name'])) ? $_FILES['edit-students-image']['tmp_name'] : NULL;

    $rand_img = (!empty($image_name)) ? rand(1000,9999).'.jpg' : '';

    if(!empty($image_name)) {
      $students_img_location = $plug_path.'images/scl_students/'.$rand_img;
      
      if(!empty($image_name)) {

        $mime = getimagesize($tmp_name);

        if(in_array('image', explode('/', $mime['mime']))) {
          move_uploaded_file($tmp_name, $students_img_location);
          
          $image = new ImageResize($students_img_location);
          $image->resize(140, 140);
          $image->save();

          copy($students_img_location, 'img/admin/student_'.$rand_img);
        }
      }
    }
    
    $fields = array(
      'id'            => $_POST['id'],
      'name'          => $_POST['name'],
      'class'         => $_POST['class'],
      'roll'          => $_POST['roll'],
      'gender'        => $_POST['gender'],
      'address'       => $_POST['address'],
      'date_of_birth' => $_POST['date_of_birth'],
      'mobile'        => $_POST['mobile'],
      'email'         => $_POST['email'],
      );

    if(!empty($image_name)) {
      $fields['image'] = $rand_img;
    }

    $where = array(
      'id' => $_POST['id']
      );

    if(db_update('scl_students', $fields, $where)) {
      $fields = array(
        'full_name'         => $_POST['name'],
        'email'             => $_POST['email'],
        );

      $where = array(
        'username' => 'student_'.$_POST['id']
        );

      if(isset($image_name)) {
        $student_acc_img = 'student_'.$rand_img;
        $fields['image'] = $student_acc_img;
      }

      $success = db_update('vor_admin', $fields, $where);
    }

    if($success) {
      echo '<script>std_update_success();</script>';
      echo "<meta http-equiv='refresh' content='2;url='>";
    } else {
      echo '<script>error();</script>';
    }
  }

  if(isset($_GET['delete_student']) && !empty($_GET['delete_student'])) {
    $std_id = $_GET['delete_student'];

    if(is_numeric($std_id)) {

      $where = array(
        'id' => $std_id
        );

      if(db_delete('scl_students', $where)) {
        $where = array(
          'username' => 'student_'.$std_id
          );
        $success = db_delete('vor_admin', $where);
      }

      if($success) {
        extract(parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

        echo '<script>std_delete_success();</script>';
        echo "<meta http-equiv='refresh' content='2;url=http://".$path."'>";
      } else {
        echo '<script>error();</script>';
      }
    }
  }
}

if(isset($_GET['class']) && !empty($_GET['class'])) {
  $class = sanitize($_GET['class']);

  $rows = db_get_where('scl_students', array(
    'class' => $class
    ));
  
  if(count($rows) == 0) {
	  echo '<div class="col-md-12">
        <div class="panel">
          <div class="panel-body">
            <div class="alert alert-info alert-block">
              <h4>
                  <i class="fa fa-ok-sign"></i>
                  No Data Found!
              </h4>
              <p>&nbsp;No Student found in class '.$class.'</p>
            </div>              
          </div>
        </div>
      </div>';
  } else {
?>
	<div class="col-lg-6 col-sm-6">
		<h3 style="margin:10px 10px 20px 15px; color:#818da1; font-weight:200;"><i class="fa fa-arrow-circle-right"></i> Manage Students</h3>
	</div>
      
      <?php
      if(is_admin()) {
        ?>
        <!-- Add New -->
        <div class="modal fade" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Student</h4>
              </div>
              <div class="modal-body">
                <div class="row">

                  <div class="col-md-12 personal-info">
                    <form class="form-horizontal" id="students_edit_form" role="form" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Name:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="name" type="text" name="name" placeholder="Enter Name" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="class">Class:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="class" type="text" name="class" placeholder="Enter Class" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="roll">Roll:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="roll" type="text" name="roll" placeholder="Enter Roll" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="gender">Gender:</label>
                        <div class="col-lg-4">
                          <select name="gender" class="form-control" id="gender">
                            <optgroup label="Select Gender">
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </optgroup>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="address">Address:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="address" type="text" name="address" placeholder="Enter Address">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="date_of_birth">Date of Birth:</label>
                        <div class="col-lg-8" id="datepick">
                          <input class="form-control" id="date_of_birth" type="text" name="date_of_birth" placeholder="Pick Date of Birth">
                          <i class="fa fa-calendar"></i>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="mobile">Mobile:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="mobile" type="text" name="mobile" placeholder="Enter Mobile Number">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="email">Email:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="email" type="text" name="email" placeholder="Enter Email">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="photo">Image:</label>
                        <div class="col-lg-8">
                          <input type="file" name="new-student-image" class="form-control" id="photo" accept="image/*">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="add_student" name="add_student">Add Student</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
      <div class="col-lg-12 col-sm-12">
        <div class="panel" id="printableArea">
          <div class="panel-body">
            <div class="table-responsive">
              <?php if(is_admin()) echo '<a class="btn pull-right add-new" data-toggle="modal" data-target="#add-new"><i class="fa fa-plus-circle"></i> Add New Student</a>'; ?>
              <table class="table table-striped table-bordered table-hover text-center" id="example">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Roll</th>
                    <th>Mobile</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($rows as $row) {
                    $img_path = $plug_path.'images/scl_students/'.$row['image'];
                    
                    if(empty($row['image'])) {
                      $image = $plug_path.'images/default_image.jpg';
                    } else {
                      $image = (file_exists($img_path)) ? $img_path : $plug_path.'images/default_image.jpg';
                    }

                    echo '<tr class="searchable" >';
                    echo '<td><img src="'.$image.'" class="img-circle" height="30px" width="30px"></img></td>';
                    echo '<td class="lead">'.$row['name'].'</td>';
                    echo '<td class="lead">'.$row['class'].'</td>';
                    echo '<td class="lead">'.$row['roll'].'</td>';
                    echo '<td>'.$row['mobile'].'</td>';
                    ?>

                    <td><div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm" type="button" aria-expanded="false">Action<span class="caret"></span></button>
                      <ul role="menu" class="dropdown-menu">
                        <li><a href="" data-toggle="modal" data-target="#profile<?php echo $row['id']; ?>" class="students_profile" id="<?php echo $row['id']; ?>"><i class="fa fa-user"></i> Profile</a></li>

                        <?php 
                        if(is_admin()) {
                          ?>
                          <li class="divider"></li>
                          <li><a href="" data-toggle="modal" data-target="#edit<?php echo $row['id']; ?>"
                            class="students_profile_edit" id="<?php echo $row['id']; ?>"><i class="fa fa-edit"></i> Edit</a></li>
                            <li class="divider"></li>
                            <li><a href="?delete_student=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="students_profile_delete" id="<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i> Delete</a></li>
                            <?php } ?>
                          </ul>
                        </div>
                      </td>

                      <?php
                      echo '</tr>';

                    }?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Class</th>
                      <th>Roll</th>
                      <th>Mobile</th>
                      <th>Options</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>

        <?php
			foreach($rows as $row) {
			  $img_path = $plug_path.'images/scl_students/'.$row['image'];
			  
			  if(empty($row['image'])) {
				$image = $plug_path.'images/default_image.jpg';
			  } else {
				$image = (file_exists($img_path)) ? $img_path : $plug_path.'images/default_image.jpg';
			  }

			  $default = $row['gender'];
			  if(strtolower($default) == 'male') {
				$gender = 
				'<option value="Male">Male</option>
				<option value="Female">Female</option>';
			  } else {
				$gender = 
				'<option value="Female">Female</option>
				<option value="Male">Male</option>';
			  }

			  echo '<!-- Profile Modal -->
			  <div class="modal fade" id="profile'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <h4 class="modal-title" id="myModalLabel">'.$row['name'].'\'s Profile</h4>
					</div>
					<div class="modal-body">
					  <div class="col-md-3 col-lg-3 profile_image" align="center">
						<img src="'.$image.'" class="img-circle" height="140px" width="140px"></img>
					  </div>
					  <div class="col-md-7 col-lg-7 profile_name" align="right">
						<h3>'.$row['name'].'</h3>
					  </div>
					  <table class="table table-user-information">
						<tbody>
						  <tr>
							<td>Login Account</td>
							<td>student_'.$row['id'].'</td>
						  </tr>
						  <tr>
							<td>Class</td>
							<td>'.$row['class'].'</td>
						  </tr>
						  <tr>
							<td>Roll</td>
							<td>'.$row['roll'].'</td>
						  </tr>
						  <tr>
							<td>Date of Birth</td>
							<td>'.$row['date_of_birth'].'</td>
						  </tr>
						  <tr>
							<td>Gender</td>
							<td>'.$row['gender'].'</td>
						  </tr>
						  <tr>
							<td>Address</td>
							<td>'.$row['address'].'</td>
						  </tr>
						  <tr>
							<td>Mobile Number</td>
							<td>'.$row['mobile'].'</td>
						  </tr>
						  <tr>
							<td>Email</td>
							<td>'.$row['email'].'</td>
						  </tr>
						</tbody>
					  </table>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>';

			  if(is_admin()) {
				echo '<!-- Edit Modal -->
				<div class="modal fade" id="edit'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
							  <img src="'.$image.'" class="avatar img-circle" alt="avatar" width="100px" height="100px">
							</div>
						  </div>
						  
						  <!-- edit form column -->
						  <div class="col-md-12 personal-info">
							<form class="form-horizontal" id="students_edit_form" role="form" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="col-lg-3 control-label" for="name">Name:</label>
								<div class="col-lg-8">
								  <input class="form-control" id="name" type="text" name="name" value="'.$row['name'].'" required>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label" for="class">Class:</label>
								<div class="col-lg-8">
								  <input class="form-control" id="class" type="text" name="class" value="'.$row['class'].'" required>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label" for="roll">Roll:</label>
								<div class="col-lg-8">
								  <input class="form-control" id="roll" type="text" name="roll" value="'.$row['roll'].'" required>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label" for="gender">Gender:</label>
								<div class="col-lg-4">
								  <select name="gender" class="form-control" id="gender">
									<optgroup label="Select Gender">
									  '.$gender.'
									</optgroup>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label" for="address">Address:</label>
								<div class="col-lg-8">
								  <input class="form-control" id="address" type="text" name="address" value="'.$row['address'].'">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label" for="date_of_birth">Date of Birth:</label>
								<div class="col-lg-8" id="datepick">
								  <input class="form-control" id="date_of_birth" type="text" name="date_of_birth" value="'.$row['date_of_birth'].'">
								  <i class="fa fa-calendar"></i>
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label" for="mobile">Mobile:</label>
								<div class="col-lg-8">
								  <input class="form-control" id="mobile" type="text" name="mobile" value="'.$row['mobile'].'">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-lg-3 control-label" for="email">Email:</label>
								<div class="col-lg-8">
								  <input class="form-control" id="email" type="text" name="email" value="'.$row['email'].'">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-md-3 control-label" for="photo">Photo:</label>
								<div class="col-md-8">
								  <input type="file" name="edit-students-image" class="form-control" id="photo" accept="image/*">
								</div>
							  </div>
							</div>
						  </div>
						</div>
						<div class="modal-footer">
						  <input type="hidden" id="id" name="id" value="'.$row['id'].'">
						  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  <button type="submit" class="btn btn-primary" id="send_students_data" name="send_students_data">Save Changes</button>
						</form>
					  </div>
					</div>
				  </div>
				</div>';
			  }
			}
	  }
  } else {

    ?>

    <div class="col-lg-6 col-sm-6">
      <h3 style="margin:10px 10px 20px 15px; color:#818da1; font-weight:200;"><i class="fa fa-arrow-circle-right"></i> Manage Students</h3>
    </div>
    
    <?php
    if(is_admin()) {
      ?>
      <!-- Add New -->
      <div class="modal fade" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Add New Student</h4>
            </div>
            <div class="modal-body">
              <div class="row">

                <div class="col-md-12 personal-info">
                  <form class="form-horizontal" id="students_edit_form" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="name">Name:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="name" type="text" name="name" placeholder="Enter Name" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="class">Class:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="class" type="text" name="class" placeholder="Enter Class" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="roll">Roll:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="roll" type="text" name="roll" placeholder="Enter Roll" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="gender">Gender:</label>
                      <div class="col-lg-4">
                        <select name="gender" class="form-control" id="gender">
                          <optgroup label="Select Gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </optgroup>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="address">Address:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="address" type="text" name="address" placeholder="Enter Address">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="date_of_birth">Date of Birth:</label>
                      <div class="col-lg-8" id="datepick">
                        <input class="form-control" id="date_of_birth" type="text" name="date_of_birth" placeholder="Select Date of Birth">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="mobile">Mobile:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="mobile" type="text" name="mobile" placeholder="Enter Mobile Number">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="email">Email:</label>
                      <div class="col-lg-8">
                        <input class="form-control" id="email" type="text" name="email" placeholder="Enter Email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="photo">Image:</label>
                      <div class="col-lg-8">
                        <input type="file" name="new-student-image" class="form-control" id="photo" accept="image/*">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add_student" name="add_student">Add Student</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php } ?>
      <div class="col-lg-12 col-sm-12">
        <div class="panel" id="printableArea">
          <div class="panel-body">
            <div class="table-responsive">
              <?php if(is_admin()) echo '<a class="btn pull-right add-new" data-toggle="modal" data-target="#add-new"><i class="fa fa-plus-circle"></i> Add New Student</a>'; ?>
              <table class="table table-striped table-bordered table-hover text-center" id="example">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Roll</th>
                    <th>Mobile</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($rows as $row) {
                    $img_path = $plug_path.'images/scl_students/'.$row['image'];
                    
                    if(empty($row['image'])) {
                      $image = $plug_path.'images/default_image.jpg';
                    } else {
                      $image = (file_exists($img_path)) ? $img_path : $plug_path.'images/default_image.jpg';
                    }

                    echo '<tr>';
                    echo '<td><img src="'.$image.'" class="img-circle" height="30px" width="30px"></img></td>';
                    echo '<td class="lead">'.$row['name'].'</td>';
                    echo '<td class="lead">'.$row['class'].'</td>';
                    echo '<td class="lead">'.$row['roll'].'</td>';
                    echo '<td class="lead">'.$row['mobile'].'</td>';
                    ?>

                    <td><div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm" type="button" aria-expanded="false">Action<span class="caret"></span></button>
                      <ul role="menu" class="dropdown-menu">
                        <li><a href="" data-toggle="modal" data-target="#profile<?php echo $row['id']; ?>" class="students_profile" id="<?php echo $row['id']; ?>"><i class="fa fa-user"></i> Profile</a></li>

                        <?php 
                        if(is_admin()) {
                          ?>
                          <li class="divider"></li>
                          <li><a href="" data-toggle="modal" data-target="#edit<?php echo $row['id']; ?>"
                            class="students_profile_edit" id="<?php echo $row['id']; ?>"><i class="fa fa-edit"></i> Edit</a></li>
                            <li class="divider"></li>
                            <li><a href="?delete_student=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="students_profile_delete" id="<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i> Delete</a></li>
                            <?php } ?>
                          </ul>
                        </div>
                      </td>

                      <?php
                      echo '</tr>';

                    }?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Class</th>
                      <th>Roll</th>
                      <th>Mobile</th>
                      <th>Options</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>

        <?php
        foreach($rows as $row) {
          $img_path = $plug_path.'images/scl_students/'.$row['image'];
          
          if(empty($row['image'])) {
            $image = $plug_path.'images/default_image.jpg';
          } else {
            $image = (file_exists($img_path)) ? $img_path : $plug_path.'images/default_image.jpg';
          }

          $default = $row['gender'];
          if(strtolower($default) == 'male') {
            $gender = 
            '<option value="Male">Male</option>
            <option value="Female">Female</option>';
          } else {
            $gender = 
            '<option value="Female">Female</option>
            <option value="Male">Male</option>';
          }

          echo '<!-- Profile Modal -->
          <div class="modal fade" id="profile'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">'.$row['name'].'\'s Profile</h4>
                </div>
                <div class="modal-body">
                  <div class="col-md-3 col-lg-3 profile_image" align="center">
                    <img src="'.$image.'" class="img-circle" height="140px" width="140px"></img>
                  </div>
                  <div class="col-md-7 col-lg-7 profile_name" align="right">
                    <h3>'.$row['name'].'</h3>
                  </div>
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Login Account</td>
                        <td>student_'.$row['id'].'</td>
                      </tr>
                      <tr>
                        <td>Class</td>
                        <td>'.$row['class'].'</td>
                      </tr>
                      <tr>
                        <td>Roll</td>
                        <td>'.$row['roll'].'</td>
                      </tr>
                      <tr>
                        <td>Date of Birth</td>
                        <td>'.$row['date_of_birth'].'</td>
                      </tr>
                      <tr>
                        <td>Gender</td>
                        <td>'.$row['gender'].'</td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td>'.$row['address'].'</td>
                      </tr>
                      <tr>
                        <td>Mobile Number</td>
                        <td>'.$row['mobile'].'</td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td>'.$row['email'].'</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>';
          if(is_admin()) {
            echo '<!-- Edit Modal -->
            <div class="modal fade" id="edit'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                          <img src="'.$image.'" class="avatar img-circle" alt="avatar" width="100px" height="100px">
                        </div>
                      </div>
                      
                      <!-- edit form column -->
                      <div class="col-md-12 personal-info">
                        <form class="form-horizontal" id="students_edit_form" role="form" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">Name:</label>
                            <div class="col-lg-8">
                              <input class="form-control" id="name" type="text" name="name" value="'.$row['name'].'" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-3 control-label" for="class">Class:</label>
                            <div class="col-lg-8">
                              <input class="form-control" id="class" type="text" name="class" value="'.$row['class'].'" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-3 control-label" for="roll">Roll:</label>
                            <div class="col-lg-8">
                              <input class="form-control" id="roll" type="text" name="roll" value="'.$row['roll'].'" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-3 control-label" for="gender">Gender:</label>
                            <div class="col-lg-4">
                              <select name="gender" class="form-control" id="gender">
                                <optgroup label="Select Gender">
                                  '.$gender.'
                                </optgroup>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-3 control-label" for="address">Address:</label>
                            <div class="col-lg-8">
                              <input class="form-control" id="address" type="text" name="address" value="'.$row['address'].'">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-3 control-label" for="date_of_birth">Date of Birth:</label>
                            <div class="col-lg-8" id="datepick">
                              <input class="form-control" id="date_of_birth" type="text" name="date_of_birth" value="'.$row['date_of_birth'].'">
                              <i class="fa fa-calendar"></i>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-3 control-label" for="mobile">Mobile:</label>
                            <div class="col-lg-8">
                              <input class="form-control" id="mobile" type="text" name="mobile" value="'.$row['mobile'].'">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-3 control-label" for="email">Email:</label>
                            <div class="col-lg-8">
                              <input class="form-control" id="email" type="text" name="email" value="'.$row['email'].'">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-3 control-label" for="photo">Photo:</label>
                            <div class="col-md-8">
                              <input type="file" name="edit-students-image" class="form-control" id="photo" accept="image/*">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" id="send_students_data" name="send_students_data">Save Changes</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>';          
          }
        }
      }