<div class="row">
                  <div class="col-md-12">
                      <section class="panel tasks-widget">
                          <header class="panel-heading">
                              All Notifications
                          </header>
                          <div class="panel-body">
                              <div class="task-content">
                                  <ul id="sortable" class="task-list">
                                    

                                     <?php 
                                     $results = mysql_query("SELECT * FROM vor_notify ORDER BY id DESC");
                                      while ($row_foot = mysql_fetch_array($results)) {
                                      ?>
                                    
                                      <li class="list-info">
                                          
                                        
                                          <div class="task-title">
                                              <span class="task-title-sp"><b>[+] </b> <?php echo $row_foot['content'] ?> <span> <b>Time</b> : <?php echo $row_foot['time']; ?></span>   [+] <span class="badge badge-sm label-<?php echo $row_foot['class'];?>"> <?php echo $row_foot['status']; ?> </span></span>
                                              
                                              <div class="pull-right hidden-phone">
                                                  <button class="btn btn-success btn-xs fa fa-check"></button>
                                                  
                                                  <button class="btn btn-danger btn-xs fa fa-trash-o"></button>
                                              </div>
                                          </div>
                                      </li>
                                      <?php 
                                    }
                                       ?>

                                  </ul>
                              </div>
                             
                          </div>
                      </section>
                  </div>
              </div>