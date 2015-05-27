<?php debug_backtrace() || die ("Direct access not permitted."); ?>

<?php
$pdo = db_connect();

require 'imageResize.php';

$rows = db_get('scl_teachers');
$plug_path = plugin_path('school_management_vor');

if(is_admin()) {
  $db_ids = array();

  foreach($rows as $row) {
    $db_ids[] = $row['image'];
  }

  $image_dir     = $plug_path.'images/scl_teachers/';
  $stored_images = glob($image_dir.'*.jpg');

  if(!empty($stored_images)) {
      $stored_image_m = array();

      foreach ($stored_images as $stored_image) {
          $stored_image_m[] = basename($stored_image);
      }

    foreach($stored_image_m as $stored_image_h) {
      if(!in_array($stored_image_h, $db_ids)) {
        unlink($image_dir.$stored_image_h);
      }
    }
  }

  if(isset($_POST['add_teacher'])) {
    $image_name = (!empty($_FILES['new-teacher-image']['name'])) ? $_FILES['new-teacher-image']['name'] : NULL;
    $tmp_name   = (!empty($_FILES['new-teacher-image']['tmp_name'])) ? $_FILES['new-teacher-image']['tmp_name'] : NULL;

    $rand_img = (!empty($image_name)) ? rand(1000,9999).'.jpg' : '';
    $teachers_img_location = $plug_path.'images/scl_teachers/'.$rand_img;

    if(!empty($image_name)) {

      $mime = getimagesize($tmp_name);

      if(in_array('image', explode('/', $mime['mime']))) {
        move_uploaded_file($tmp_name, $teachers_img_location);
        
        $image = new ImageResize($teachers_img_location);
        $image->resize(140, 140);
        $image->save();
      }
    }

    $fields = array(
      'id'            => NULL,
      'name'          => $_POST['name'],
      'position'      => $_POST['position'],    
      'gender'        => $_POST['gender'],
      'date_of_birth' => $_POST['date_of_birth'],
      'address'       => $_POST['address'],
      'mobile'        => $_POST['mobile'],
      'email'         => $_POST['email']
    );

    if(isset($image_name)) {
      $fields['image'] = $rand_img;
    }


    $success = db_insert('scl_teachers', $fields);

    if($success) {
      echo '<script>teacher_add_success();</script>';
      echo "<meta http-equiv='refresh' content='1;url='>";
    } else {
        echo '<script>error();</script>';
    }
  }

  if(isset($_POST['send_teachers_data'])) {
    $image_name = (isset($_FILES['edit-teachers-image']['name'])) ? $_FILES['edit-teachers-image']['name'] : NULL;
    $tmp_name   = (isset($_FILES['edit-teachers-image']['tmp_name'])) ? $_FILES['edit-teachers-image']['tmp_name'] : NULL;

    if(!empty($image_name)) {
      $rand_img = (!empty($image_name)) ? rand(1000,9999).'.jpg' : '';
      $teachers_img_location = $plug_path.'images/scl_teachers/'.$rand_img;
      
      if(!empty($image_name)) {

        $mime = getimagesize($tmp_name);

        if(in_array('image', explode('/', $mime['mime']))) {
          move_uploaded_file($tmp_name, $teachers_img_location);
          
          $image = new ImageResize($teachers_img_location);
          $image->resize(140, 140);
          $image->save();
        }
      }
    }
    
    $fields = array(
      'id'            => $_POST['id'],
      'name'          => $_POST['name'],
      'position'      => $_POST['position'],    
      'gender'        => $_POST['gender'],
      'date_of_birth' => $_POST['date_of_birth'],
      'address'       => $_POST['address'],
      'mobile'        => $_POST['mobile'],
      'email'         => $_POST['email']
    );

    if(!empty($image_name)) {
      $fields['image'] = $rand_img;
    }

    $where = array(
      'id' => $_POST['id']
    );

    $success = db_update('scl_teachers', $fields, $where);

    if($success) {
      echo '<script>teacher_update_success()();</script>';
      echo "<meta http-equiv='refresh' content='2;url='>";
    } else {
      echo '<script>error();</script>';
    }
  }

  if(isset($_GET['delete_teacher']) && !empty($_GET['delete_teacher'])) {
    $teacher_id = $_GET['delete_teacher'];

    if(is_numeric($teacher_id)) {

      $where = array(
          'id' => $teacher_id
      );

      $success = db_delete('scl_teachers', $where);

      if($success) {
        extract(parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
        
        echo '<script>teacher_delete_success();</script>';
        echo "<meta http-equiv='refresh' content='2;url=http://".$path."'>";
      } else {
        echo '<script>error();</script>';
      }
    }
  }
}

?>

<div class="col-lg-6 col-sm-6">
  <h3 style="margin:10px 10px 20px 15px; color:#818da1; font-weight:200;"><i class="fa fa-arrow-circle-right"></i> Manage Teachers</h3>
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
            <h4 class="modal-title" id="myModalLabel">Add New Teacher</h4>
          </div>
          <div class="modal-body">
              <div class="row">

                  <div class="col-md-12 personal-info">
                    <form class="form-horizontal" id="teachers_edit_form" role="form" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Name:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="name" type="text" name="name" placeholder="Enter Name">
                      </div>
                      </div>
                        <div class="form-group">
                        <label class="col-lg-3 control-label" for="position">Position:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="position" type="text" name="position" placeholder="Enter Position">
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
                        <label class="col-lg-3 control-label" for="date_of_birth">Date of Birth:</label>
                        <div class="col-lg-8" id="datepick">
                          <input class="form-control" id="date_of_birth" type="text" name="date_of_birth" placeholder="Select Date of Birth">
                          <i class="fa fa-calendar"></i>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="col-lg-3 control-label" for="address">Address:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="address" type="text" name="address" placeholder="Enter Address">
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
                          <input type="file" name="new-teacher-image" class="form-control" id="photo" accept="image/*">
                        </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add_teacher" name="add_teacher">Add Teacher</button>
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
                  <?php if(is_admin()) echo '<a class="btn pull-right add-new" data-toggle="modal" data-target="#add-new"><i class="fa fa-plus-circle"></i> Add New Teacher</a>'; ?>
          <table class="table table-striped table-bordered table-hover text-center" id="example">
            <thead>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Position</th>
                <th>Address</th>
                <th>Mobile</th>
                <th>Options</th>
              </tr>
            </thead>
            <tbody>
            <?php
              foreach ($rows as $row) {
                $img_path = $plug_path.'images/scl_teachers/'.$row['image'];
                
                if(empty($row['image'])) {
                  $image = $plug_path.'images/default_image.jpg';
                } else {
                  $image = (file_exists($img_path)) ? $img_path : $plug_path.'images/default_image.jpg';
                }

                echo '<tr>';
                echo '<td><img src="'.$image.'" class="img-circle" height="30px" width="30px"></img></td>';
                echo '<td class="lead">'.$row['name'].'</td>';
                echo '<td class="lead">'.$row['position'].'</td>';
                echo '<td class="lead">'.$row['address'].'</td>';
                echo '<td class="lead">'.$row['mobile'].'</td>';
                
                if(is_admin()) {
                  echo '<td><div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm" id=" type="button" aria-expanded="false">Action<span class="caret"></span></button>
                      <ul role="menu" class="dropdown-menu">
                        <li><a href="" data-toggle="modal" data-target="#profile'.$row['id'].'" class="teachers_profile" id="'.$row['id'].'"><i class="fa fa-user"></i> Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="" data-toggle="modal" data-target="#edit'.$row['id'].'"
                        class="teachers_profile_edit" id="'.$row['id'].'"><i class="fa fa-edit"></i> Edit</a></li>
                        <li class="divider"></li>
                        <li><a href="?delete_teacher='.$row['id'].'" onclick="return confirm(\'Are you sure you want to delete?\')" class="teachers_profile_delete" id="'.$row['id'].'"><i class="fa fa-trash-o"></i> Delete</a></li>
                      </ul>
                      </div>
                    </td>';
                  } else {
                    echo '<td><div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm" id=" type="button" aria-expanded="false">Action<span class="caret"></span></button>
                      <ul role="menu" class="dropdown-menu">
                        <li><a href="" data-toggle="modal" data-target="#profile'.$row['id'].'" class="teachers_profile" id="'.$row['id'].'"><i class="fa fa-user"></i> Profile</a></li>
                      </ul>
                      </div>
                    </td>';
                  }

                echo '</tr>';

              }
            ?>
            </tbody>
            <tfoot>
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Position</th>
              <th>Address</th>
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
    $img_path = $plug_path.'images/scl_teachers/'.$row['image'];

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
              <td>Class</td>
              <td>'.$row['position'].'</td>
            </tr>
            <tr>
              <td>Gender</td>
              <td>'.$row['gender'].'</td>
            </tr>
              <td>Date of Birth</td>
              <td>'.$row['date_of_birth'].'</td>
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
              <form class="form-horizontal" id="teachers_edit_form" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                <label class="col-lg-3 control-label" for="name">Name:</label>
                <div class="col-lg-8">
                  <input class="form-control" id="name" type="text" name="name" value="'.$row['name'].'">
                </div>
                </div>
                <div class="form-group">
                <label class="col-lg-3 control-label" for="class">Position:</label>
                <div class="col-lg-8">
                  <input class="form-control" id="position" type="text" name="position" value="'.$row['position'].'">
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
                  <input type="file" name="edit-teachers-image" class="form-control" id="photo" accept="image/*">
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" id="id" name="id" value="'.$row['id'].'">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="send_teachers_data" name="send_teachers_data">Save Changes</button>
            </form>
          </div>
          </div>
        </div>
        </div>';
  }