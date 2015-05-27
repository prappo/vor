   <script type="text/javascript">        
        function done(){
            swal({   title: "Done !",   text: "Your settings are updated successfully",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
           
        }
        function reload(){
        	location.reload();
        }
   </script>
<div class="row">

<!-- registar user-->

<div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Add new User
                          </header>
                          <div class="panel-body">
                              <div class="stepy-tab">
                                  <ul id="default-titles" class="stepy-titles clearfix">
                                      <li id="default-title-0" class="current-step">
                                          <div>Step 1</div>
                                      </li>
                                      <li id="default-title-1" class="">
                                          <div>Step 2</div>
                                      </li>
                                      
                                  </ul>
                              </div>
                              <form class="form-horizontal" id="default">
                                  <fieldset title="Step1" class="step" id="default-step-0">
                                      <legend> </legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Full Name</label>
                                          <div class="col-lg-10">
                                              <input type="text" class="form-control" placeholder="Full Name">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Email Address</label>
                                          <div class="col-lg-10">
                                              <input type="text" class="form-control" placeholder="Email Address">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">User Name</label>
                                          <div class="col-lg-10">
                                              <input type="text" class="form-control" placeholder="Username">
                                          </div>
                                      </div>

                                  </fieldset>
                                  <fieldset title="Step 2" class="step" id="default-step-1" >
                                      <legend> </legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Password</label>
                                          <div class="col-lg-10">
                                              <input type="password" class="form-control" placeholder="Password">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Type</label>
                                          <div class="col-lg-10">
                                              
                                              <select class="form-control">
                                              <option>admin</option>
                                              <option>user</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Bio</label>
                                          <div class="col-lg-10">
                                              <input type="text" class="form-control" placeholder="Bio">
                                          </div>
                                      </div>

                                  </fieldset>
                                 
                                  <input type="submit" class="finish btn btn-danger" value="Finish"/>
                              </form>
                          </div>
                      </section>
                  </div>


<!--/register user-->

 <div class="col-lg-8">
                              <section class="panel">
                                  <header class="panel-heading">
                                  <i class="fa fa-edit"></i>    Edit Home page content 
                                  </header>
                                  <div class="panel-body">
                                      <div class="form">
                                          <form method="post" class="form-horizontal">
                                              <div class="form-group">
                                                 
                                                 
                                                      <textarea class="form-control ckeditor" name="editor" rows="6"> <?php echo settings('home'); ?></textarea>
                                                 
                                              </div>

                                              <input type="submit" name="home_edit" value="Change" class="btn btn-info">
                                          </form>
                                      </div>

                                      <?php 
                                      $editor = $_POST['editor'];
                                      if(isset($_POST['home_edit']))
                                      {
                                      	if(settings_update('home',$editor))
                                      	{
                                      		echo "<script> done();</script>";
                          		echo "<meta http-equiv='refresh' content='1.5; url=soft_settings' />";

                                      	}
                                      	else
                                      	{
                                      		echo mysql_error();
                                      	}
                                      }

                                       ?>
                                  </div>
                              </section>
                          </div>

                          
                         <div class="col-lg-4">
                      <section class="panel">
                          <header class="panel-heading">
                              Notification Settings
                          </header>
                          <div class="panel-body">
                          <form method="post">

                          	<select name="option" class="form-control m-bot10" onchange="this.form.submit()"> 
                          		<option><?php $hm=settings('notify'); echo $hm;?></option>
                          		<option><?php if($hm=='on'){echo "off";}else{ echo "on";} ?></option>
                          		
                          	</select>

                          </form>

                          <?php
                          $option = $_POST['option']; 
                          if(isset($_POST['option']))
                          {
                          	if(settings_update('notify', $option))
                          	{
                          		echo "<script> done();</script>";
                          		echo "<meta http-equiv='refresh' content='1.5; url=soft_settings' />";

                          	}
                          	else { echo "error";}
                          }

                           ?>
                          </div>
                          </section>
                          </div>


                           <div class="col-lg-4">
                      <section class="panel">
                          <header class="panel-heading">
                            Software Text
                          </header>
                          <div class="panel-body">
                          	<form class="form-horizontal" method="post">
                                  <div class="form-group">
                                      <label  class="col-lg-3 col-sm-3 control-label">Header</label>
                                      <div class="col-lg-9">
                                          <div class="iconic-input">
                                              <i class="fa fa-check-circle-o"></i>
                                              <input type="text" class="form-control" name="header" placeholder="Header Text" value="<?php echo settings('header'); ?>">
                                          </div>
                                      </div>
                                  </div>
                                 
                                   <div class="form-group">
                                      <label  class="col-lg-3 col-sm-3 control-label">Footer</label>
                                      <div class="col-lg-9">
                                          <div class="iconic-input">
                                              <i class="fa fa-check-circle-o"></i>
                                              <input type="text" name="foot" class="form-control" placeholder="Footer Text" value="<?php echo settings('foot'); ?>">
                                          </div>
                                      </div>
                                  </div>
                                
                                 <input type="submit" name="text_edit" class="btn btn-info" value="Submit">
                              </form>
                              <?php 
                              if(isset($_POST['text_edit']))
                              {
                              	if(settings_update('header', $_POST['header']) && settings_update('foot',$_POST['foot']))
                              	{
                              		echo "<script> done();</script>";
                          		echo "<meta http-equiv='refresh' content='1.5; url=soft_settings' />";
                              	}
                              	else
                              	{
                              		echo "error";
                              	}
                              }

                               ?>
                          </div>
                          </section>
                          </div>

                       

                 


</div>

