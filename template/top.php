 
          <?php
             mysql_connect(HOST, USER, PASS) or die ("can't connect <br>");
                              mysql_select_db(DB) or die ("Can't counnect to database<br>");

 $user = $_SESSION['username'];

          $sql = "SELECT * FROM vor_admin WHERE username = '$user'";
$query = mysql_query($sql);
$row_admin = mysql_fetch_array($query);
$type =  $row_admin['type'];

if($type == 'admin')
{
           if(vor_settings('notify')=='on'){ 
             
                             

                           

             $undread_sql = "SELECT * FROM vor_notify WHERE status='unread'";
            
            $unread_result = mysql_query($undread_sql) or die(mysql_error());

              $unread = mysql_num_rows($unread_result);
              
            ?>   
              <!-- notification dropdown start-->
              
              <li id="header_notification_bar" class="dropdown">
                  <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                      <i class="fa fa-bell-o"></i>
                      <span class="badge bg-success"><?php  echo $unread; ?></span>
                  </a>
                  <ul class="dropdown-menu extended notification">
                      <div class="notify-arrow notify-arrow-green"></div>
                      <li>
                          <p class="green">You have <?php echo $unread; ?> new notifications</p>
                      </li>
                      <?php 

                      
                              $sql_n = "SELECT * FROM vor_notify";
                             $results = mysql_query("SELECT * FROM vor_notify ORDER BY id DESC LIMIT 6");
                              while ($row = mysql_fetch_array($results)) {
                            
                             
                             
                       ?>
                      <li>
                          <a href="#">
                              <span class="label label-<?php echo $row['class']; ?>"><i class="fa fa-bolt"></i></span>
                              <?php echo $row['content']; ?>
                              <br>
                              <span class="small italic"><?php echo $row['time']; ?></span>
                          </a>
                      </li>
                     
                    <?php 
                  }
                  

                     ?>
                     
                      <li>
                          <a href="notification">See all notifications</a>
                      </li>
                  </ul>
              </li>

              <?php }} ?>