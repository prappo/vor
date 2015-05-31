<?php debug_backtrace() || die ("Direct access not permitted."); ?>

<?php
$pdo = db_connect();

$rows = db_get('scl_notices');
$plug_path = plugin_path('school_management_vor');

if(is_admin()) {
  if(isset($_POST['add_notice'])) {  
    $fields = array(
      'id'     => NULL,
      'notice' => $_POST['notice']
    );

    $success = db_insert('scl_notices', $fields);

    if($success) {
      echo '<script>notice_add_success();</script>';
      echo "<meta http-equiv='refresh' content='1;url='>";
    } else {
        echo '<script>error();</script>';
    }
  }

  if(isset($_POST['send_notices_data'])) {
    $fields = array(
      'id'     => $_POST['id'],
      'notice' => $_POST['notice'],
    );

    $where = array(
      'id' => $_POST['id']
    );

    $success = db_update('scl_notices', $fields, $where);

    if($success) {
      echo '<script>notice_update_success()();</script>';
      echo "<meta http-equiv='refresh' content='2;url='>";
    } else {
      echo '<script>error();</script>';
    }
  }

  if(isset($_GET['delete_notice']) && !empty($_GET['delete_notice'])) {
    $notice_id = $_GET['delete_notice'];

    if(is_numeric($notice_id)) {

      $where = array(
          'id' => $notice_id
      );

      $success = db_delete('scl_notices', $where);

      if($success) {
        extract(parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
        
        echo '<script>notice_delete_success();</script>';
        echo "<meta http-equiv='refresh' content='2;url=http://".$path."'>";
      } else {
        echo '<script>error();</script>';
      }
    }
  }
}

?>

<div class="col-lg-6 col-sm-6">
  <h3 style="margin:10px 10px 20px 15px; color:#818da1; font-weight:200;"><i class="fa fa-arrow-circle-right"></i> Manage Notices</h3>
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
            <h4 class="modal-title" id="myModalLabel">Add New Notice</h4>
          </div>
          <div class="modal-body">
              <div class="row">

                  <div class="col-md-12 personal-info">
                    <form class="form-horizontal" id="notices_edit_form" role="form" method="post">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="notice">Notice:</label>
                        <div class="col-lg-8">
                          <textarea class="form-control" id="notice" type="text" name="notice" placeholder="Enter Notice" rows="10" cols="30"></textarea>
                        </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add_notice" name="add_notice">Add Notice</button>
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
                  <?php if(is_admin()) echo '<a class="btn pull-right add-new" data-toggle="modal" data-target="#add-new"><i class="fa fa-plus-circle"></i> Add New Notice</a>'; ?>
                  <table class="table table-striped table-bordered table-hover text-center" id="example">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Notice</th>
                              <?php if(is_admin()) echo '<th>Options</th>'; ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                            foreach ($rows as $row) {
                                echo '<tr>';
                                echo '<td class="lead">'.$row['id'].'</td>';
                                echo '<td class="lead">'.$row['notice'].'</td>';
                                
                                if(is_admin()) {
                                  echo '<td><div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm" id=" type="button" aria-expanded="false">Action<span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                              <li><a href="" data-toggle="modal" data-target="#edit'.$row['id'].'"
                                              class="notice_edit" id="'.$row['id'].'"><i class="fa fa-edit"></i> Edit</a></li>
                                              <li class="divider"></li>
                                              <li><a href="?delete_notice='.$row['id'].'" onclick="return confirm(\'Are you sure you want to delete?\')" class="notice_delete" id="'.$row['id'].'"><i class="fa fa-trash-o"></i> Delete</a></li>
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
                          <th>ID</th>
                          <th>Notice</th>
                          <?php if(is_admin()) echo '<th>Options</th>'; ?>
                        </tr>
                      </tfoot>
                  </table>
              </div>
          </div>
      </div>
  </div>

  <?php
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
                            <form class="form-horizontal" id="not_edit_form" role="form" method="post" enctype="multipart/form-data">
                              <div class="form-group">
                                <label class="col-lg-3 control-label" for="notice">Notice:</label>
                                <div class="col-lg-8">
                                  <textarea class="form-control" id="notice" type="text" name="notice" placeholder="Enter Notice" rows="10" cols="30">'.$row['notice'].'</textarea>
                                </div>
                          </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id" name="id" value="'.$row['id'].'">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="send_notices_data" name="send_notices_data">Save Changes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>';
  }