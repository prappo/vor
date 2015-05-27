<?php debug_backtrace() || die ("Direct access not permitted."); ?>

<div class="col-lg-6 col-sm-6">
  <h3 style="margin:10px 10px 20px 15px; color:#818da1; font-weight:200;"><i class="fa fa-arrow-circle-right"></i> Exam Routine</h3>
</div>

<?php
$pdo = db_connect();
$plug_path = plugin_path('school_management');

if(is_admin()) {
  echo '<a class="btn pull-right add-new add-routine" data-toggle="modal" data-target="#add-new"><i class="fa fa-plus-circle"></i> Add Routine</a>';

  if(isset($_POST['add_routine'])) {
    if(empty($_POST['class']) || empty($_POST['subject']) || empty($_POST['day']) || empty($_POST['start']) || empty($_POST['end'])) {
      echo '<script>routine_empty();</script>';
      echo "<meta http-equiv='refresh' content='1;url='>";
      exit();
    }

    $fields = array(
      'id'      => NULL,
      'class'   => $_POST['class'],
      'subject' => $_POST['subject'],
      'day'     => $_POST['day'],
      'start'   => $_POST['start'],
      'end'     => $_POST['end']
    );

    $success = db_insert('scl_exam_routine', $fields);

    if($success) {
      echo '<script>routine_add_success();</script>';
    } else {
      echo '<script>error();</script>';
    }
  }

  if(isset($_POST['edit_exam_routine'])) {
    if(empty($_POST['class']) || empty($_POST['subject']) || empty($_POST['day']) || empty($_POST['start']) || empty($_POST['end'])) {
      echo '<script>routine_empty();</script>';
      echo "<meta http-equiv='refresh' content='1;url='>";
      exit();
    }

    $fields = array(
      'id'      => $_POST['id'],
      'class'   => $_POST['class'],
      'subject' => $_POST['subject'],
      'day'     => $_POST['day'],
      'start'   => $_POST['start'],
      'end'     => $_POST['end']
    );

    $where = array(
      'id' => $_POST['id']
    );

    $success = db_update('scl_exam_routine', $fields, $where);

    if($success) {
      echo '<script>routine_update_success();</script>';
    } else {
      echo '<script>error();</script>';
    }
  }

  if(isset($_GET['delete_routine']) && !empty($_GET['delete_routine'])) {
    $routine_id = $_GET['delete_routine'];

    if(is_numeric($routine_id)) {

      $where = array(
          'id' => $routine_id
      );

      $success = db_delete('scl_exam_routine', $where);

      if($success) {
        extract(parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

        echo '<script>routine_delete_success();</script>';
        echo "<meta http-equiv='refresh' content='2;url=http://".$path."'>";
      } else {
        echo '<script>error();</script>';
      }
    }
  }
}

$classes = array();

  foreach($pdo->query("SELECT `class` FROM `scl_exam_routine` GROUP BY `class`") as $studentClass) {
    $classes[] = $studentClass['class'];
  }

  $rows = array();

  foreach($classes as $class) {
    $where = array(
          'class' => $class
      );

    $rows[] = db_get_where('scl_exam_routine', $where);
  }

if(empty($rows)) {
    ?>
      <div class="col-md-12">
        <div class="panel">
          <div class="panel-body">
            <div class="alert alert-info alert-block">
              <h4>
                  <i class="fa fa-ok-sign"></i>
                  No Data Found!
              </h4>
              <p>&nbsp;<?php echo (is_admin()) ? 'Add a New Data from Add Routine Button.' : 'No routine data found in your class.' ; ?></p>
            </div>              
          </div>
        </div>
      </div>
    <?php
  }

foreach($rows as $val) {
  ?>
    <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    Class <?php echo $val[0]['class']; ?>
                    <span class="tools pull-right">
                          <a href="javascript:;" class="fa fa-chevron-down"></a>
                      </span>
                </div>
                <div class="panel-body">
                    <div class="col-lg-12 col-sm-12">
                <div class="panel" id="printableArea">
                    <div class="panel-body">
                        <div class="table-responsive">                  
                              <table class="table table-striped table-bordered table-hover text-center">
                                  <thead>
                                      <tr>
                                          <th>Subject</th>
                                          <th>Day</th>
                                          <th>Start</th>
                                          <th>End</th>
                                          <?php if(is_admin()) echo '<th>Options</th>'; ?>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      foreach($val as $row) {
                                        echo '<tr>';
                                        echo '<td class="lead">'.$row['subject'].'</td>';
                                        echo '<td class="lead">'.$row['day'].'</td>';
                                        echo '<td class="lead">'.$row['start'].'</td>';
                                        echo '<td class="lead">'.$row['end'].'</td>';
                                        
                                        if(is_admin()) {
                                          echo '<td><div class="btn-group">
                                              <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm" id=" type="button" aria-expanded="false">Action<span class="caret"></span></button>
                                                  <ul role="menu" class="dropdown-menu">
                                                    <li><a href="" data-toggle="modal" data-target="#edit'.$row['id'].'"
                                                    class="routine_edit" id="'.$row['id'].'"><i class="fa fa-edit"></i> Edit</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="?delete_routine='.$row['id'].'" onclick="return confirm(\'Are you sure you want to delete?\')" class="teachers_profile_delete" id="'.$row['id'].'"><i class="fa fa-trash-o"></i> Delete</a></li>
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
                                          <th>Subject</th>
                                          <th>Day</th>
                                          <th>Start</th>
                                          <th>End</th>
                                          <?php if(is_admin()) echo '<th>Options</th>'; ?>
                                      </tr>
                                  </tfoot>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
  <?php
}
$rows = db_get('scl_exam_routine');
  
if(is_admin()) {

  foreach($rows as $row) {
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
                    <div class="col-md-12 personal-info">
                      <form class="form-horizontal" id="teachers_edit_form" role="form" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group">
                          <label class="col-lg-3 control-label" for="class">Class:</label>
                          <div class="col-lg-8">
                            <input class="form-control" id="class" type="text" name="class" value="'.$row['class'].'" required>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-lg-3 control-label" for="class">Subject:</label>
                          <div class="col-lg-8">
                            <input class="form-control" id="subject" type="text" name="subject" value="'.$row['subject'].'" required>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-lg-3 control-label" for="day">Day:</label>
                          <div class="col-lg-8">
                            <select name="day" class="form-control">
                                <option value="sunday">sunday</option>
                                <option value="monday">monday</option>
                                <option value="tuesday">tuesday</option>
                                <option value="wednesday">wednesday</option>
                                <option value="thursday">thursday</option>
                                <option value="friday">friday</option>
                                <option value="saturday">saturday</option>
                            </select>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-lg-3 control-label" for="start">Start:</label>
                          <div class="col-lg-8">
                            <input class="form-control" id="start" type="text" name="start" value="'.$row['start'].'" required>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-lg-3 control-label" for="end">End:</label>
                          <div class="col-lg-8">
                            <input class="form-control" id="end" type="text" name="end" value="'.$row['end'].'" required>
                          </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                  <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="edit_exam_routine" name="edit_exam_routine">Save Changes</button>
                </form>
              </div>
            </div>
          </div>
        </div>';
  }
?>
    <!-- Add New -->
    <div class="modal fade" id="add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add Routine</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12 personal-info">
                    <form class="form-horizontal" id="students_edit_form" role="form" method="post" enctype="multipart/form-data">
                      
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="class">Class:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="class" type="text" name="class" placeholder="Enter Class" required>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="subject">Subject:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="subject" type="text" name="subject" placeholder="Enter Subject" required>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="day">Day:</label>
                        <div class="col-lg-8">
                          <select name="day" class="form-control">
                              <option value="sunday">sunday</option>
                              <option value="monday">monday</option>
                              <option value="tuesday">tuesday</option>
                              <option value="wednesday">wednesday</option>
                              <option value="thursday">thursday</option>
                              <option value="friday">friday</option>
                              <option value="saturday">saturday</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="start">Start:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="start" type="text" name="start" placeholder="Start Time" required>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="end">End:</label>
                        <div class="col-lg-8">
                          <input class="form-control" id="end" type="text" name="end" placeholder="End Time" required>
                        </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add_routine" name="add_routine">Add Routine</button>
              </form>
            </div>
          </div>
        </div>
      </div
 <?php
    }