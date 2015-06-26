<script>
  function empty() {
    swal({   title: "Error!",   text: "You must enter all fields",   type: "error",   confirmButtonText: "OK" , timer: 2500 });
  }

  function success() {
    swal({   title: "Updated!",   text: "Password Changed",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
  }

  function error(){
    swal({   title: "Oops...",   text: "Something went wrong!",   type: "error",   confirmButtonText: "OK" , timer: 1500 });
  }

  function notMatched() {
    swal({   title: "Error!",   text: "Password not matched",   type: "error",   confirmButtonText: "OK" , timer: 2500 });
  }

  function checkInput() {
    c_pwd 	= document.getElementById('c-pwd').value;
    n_pwd 	= document.getElementById('n-pwd').value;
    rt_pwd 	= document.getElementById('rt-pwd').value;

    if(c_pwd == '' || n_pwd == '' || rt_pwd == '') {
      empty();
      return false;
    } else if(n_pwd != rt_pwd) {
    	notMatched();
    	return false;
    }
  }
</script>

<?php
	$rows = db_get_where('vor_admin', array('username' => $_SESSION['username']));

	$image = $rows[0]['image'];

	$image = 'img/admin/'.$image;

	if(!file_exists($image) || empty($rows[0]['image'])) {
	  $image = 'img/admin/admin.png';
	}

	if(isset($_POST['changePassword'])) {
		$current_pass = $_POST['current_pass'];
		$new_pass = $_POST['new_pass'];
		$retype_pass = $_POST['retype_pass'];

		if(empty($current_pass) || empty($new_pass) || empty($retype_pass)) {
			echo '<script>error()</script>';
		} else {

			if($new_pass != $retype_pass) {
				echo '<script>notMatched()</script>';
			} else {
				$fields = array(
					'password' => $new_pass
				);

				$where = array(
					'username' => $_SESSION['username']
				);

				$success = db_update('vor_admin', $fields, $where);

				if($success) {
					echo '<script>success()</script>';
					echo "<meta http-equiv='refresh' content='1;url='>";
					session_destroy();
				} else {
					echo '<script>error()</script>';
				}
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
				<h1><?php echo $rows[0]['full_name']; ?></h1>
				<p><?php echo $rows[0]['email']; ?></p>
			</div>
			<ul class="nav nav-pills nav-stacked">
				<li><a href="profile"> <i class="fa fa-user"></i> Profile</a></li>
				<li class="active"><a href="change_password"> <i class="fa fa-lock"></i> Change Password</a></li>
				<li><a href="edit_profile"> <i class="fa fa-edit"></i> Edit profile</a></li>
			</ul>
		</section>
	</aside>
	<aside class="profile-info col-lg-9">
		<section>
			<div class="panel panel-primary">
				<div class="panel-heading"> Change your password</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="post" onsubmit="return checkInput()">
						<div class="form-group">
							<label class="col-lg-2 control-label">Current Password</label>
							<div class="col-lg-6">
								<input type="password" class="form-control" id="c-pwd" name="current_pass">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">New Password</label>
							<div class="col-lg-6">
								<input type="password" class="form-control" id="n-pwd" name="new_pass">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Re-type New Password</label>
							<div class="col-lg-6">
								<input type="password" class="form-control" id="rt-pwd" name="retype_pass">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10">
								<button type="submit" name="changePassword" class="btn btn-danger">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
	</aside>