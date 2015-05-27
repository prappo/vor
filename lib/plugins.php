<?php
if(isset($_FILES["zip_file"]["name"])) {
  $filename = $_FILES["zip_file"]["name"];
  $source = $_FILES["zip_file"]["tmp_name"];
  $type = $_FILES["zip_file"]["type"];
 
  if(empty($filename)) {
    $message = '<div class="alert alert-warning fade in"><i class="close" data-dismiss="alert">&times;</i>You Must Select a Plugin to Upload</div>';  
  } else {  
    $ext = pathinfo($filename);
    if(strtolower($ext['extension']) == 'zip') {
      $continue = true;
    } else {
      $continue = false;
    }
 
    if($continue == false) {
      $message = '<div class="alert alert-warning fade in"><i class="close" data-dismiss="alert">&times;</i>The file you are trying to upload is not a (.zip) file. Please try again</div>';
    } else {
      $target_path = "./plugins/".$filename;
      if(move_uploaded_file($source, $target_path)) {
        $zip = new ZipArchive();
        $x = $zip->open($target_path);
      if ($x === true) {
       $zip->extractTo("./plugins/");
       $zip->close();
     
       unlink($target_path);
      }
        $message = '<div class="alert alert-success fade in"><i class="close" data-dismiss="alert">&times;</i>Plugin Uploaded and Activated</div>';
      } else {
        $message = '<div class="alert alert-danger fade in"><i class="close" data-dismiss="alert">&times;</i>Something went wrong. Please try again</div>';
      }
    }
  }
}
?>
<div class="row text-center">
  <div class="col-md-6 col-md-offset-3">
    <div class="login-panel panel panel-default">
      <div class="panel-body">
        <form role="form" enctype="multipart/form-data" method="post" action="">
          <h2>Choose a plugin file to upload</h2><br>
          <div align="center"><input type="file" name="zip_file"  /> </div><br />
          <div align="center"><input type="submit" name="submit" class="btn btn-outline btn-success" value="Upload" /></div>
        </form>
      </div>
    </div>
    <div class="text-center">
      <?php if(isset($message)) { echo $message; }?>
    </div>
  </div>
</div>