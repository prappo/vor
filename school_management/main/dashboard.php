<?php debug_backtrace() || die ("Direct access not permitted."); ?>

<div class="row state-overview">
  <div class="col-lg-3 col-sm-6">
      <section class="panel">
          <div class="symbol principal_panel">
              <i class="fa fa-user"></i>
          </div>
          <div class="value">
              <div><font size="5">Principal</font></div>
                <div style="padding: 6px">
                	<?php
                		$rows = db_get('scl_principal');
                		if(!empty($rows)) {
                			echo $rows[0]['name_title'].' '.$rows[0]['first_name'];
                		} else {
                			echo 'No Principal';
                		}
                	?>
                </div>
          </div>
          <a href="school_principal">
                <div class="panel-footer">
                    <span class="pull-left">View Full Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
      </section>
  </div>
  <div class="col-lg-3 col-sm-6">
      <section class="panel">
          <div class="symbol teachers_panel">
              <i class="fa fa-list"></i>
          </div>
          <div class="value">
              <h1 class="count"><?php echo count(db_get('scl_teachers')); ?></h1>
              <p>Total Teachers</p>
          </div>
          <a href="school_teachers">
                <div class="panel-footer">
                    <span class="pull-left">View Full Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
      </section>
  </div>
  <div class="col-lg-3 col-sm-6">
      <section class="panel">
          <div class="symbol students_panel">
              <i class="fa fa-group"></i>
          </div>
          <div class="value">
              <h1 class="count"><?php echo count(db_get('scl_students')); ?></h1>
              <p>Total Students</p>
          </div>
          <a href="school_students">
                <div class="panel-footer">
                    <span class="pull-left">View Full Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
      </section>
  </div>
  <div class="col-lg-3 col-sm-6">
      <section class="panel">
          <div class="symbol notices_panel">
              <i class="fa fa-tags"></i>
          </div>
          <div class="value">
              <h1 class="count"><?php echo count(db_get('scl_notices')); ?></h1>
              <p>Total Notices</p>
          </div>
          <a href="school_notices">
				<div class="panel-footer">
					<span class="pull-left">View Full Details</span>
					<span class="pull-right"><i class="fa fa-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
      	</section>
  	</div>      
	</div>