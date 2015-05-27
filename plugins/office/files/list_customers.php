                 
                      <section class="panel">
                          <header class="panel-heading">
                              Customer List
                          </header>
                          <div class="panel-body">
                                <div class="adv-table">
                                    <table  class="display table table-bordered table-striped" id="example">
                                      <thead>
                                      <tr>
                                          <th>Customer Number</th>
                                          <th>Customer Name</th>
                                          <th>Phone</th>
                                          <th>Address</th>
                                          <th>City</th>
                                          <th>State</th>
                                          <th>Postal Code</th>
                                          <th>County</th>


                                      </tr>
                                      </thead>
                                      <tbody>
                                      <?php




                                   $hostm = HOST;
                                   $userm = USER;
                                   $passm = PASS;

                                   try {

                                    $dbm = new PDO("mysql:host=$hostm;dbname=classicmodels", $userm, $passm);
                                    

                                    $sql = "SELECT * FROM customers";

                                    foreach($dbm->query($sql) as $row)
                                    {
                                      
                              


                                      ?>
                                     
                                      <tr class="gradeX">
                                          <td><?php echo $row[0]; ?></td>
                                          <td><?php echo $row[1]; ?></td>
                                          <td><?php echo $row[6]; ?></td>
                                          <td><?php echo $row[7]; ?></td>
                                          <td><?php echo $row[9]; ?></td>
                                          <td><?php echo $row[10]; ?></td>
                                          <td><?php echo $row[11]; ?></td>
                                          <td><?php echo $row[12]; ?></td>
                                          
                                      </tr>
                                      <?php

                                            }
                                   }  
                                  catch(PDOException $msg)
                                  {
                                    echo $msg->getMessage();
                                  }


                                        ?>
  
                                      </tbody>
                                      <tfoot>
                                      <tr>
                                         <th>Customer Number</th>
                                          <th>Customer Name</th>
                                          <th>Phone</th>
                                          <th>Address</th>
                                          <th>City</th>
                                          <th>State</th>
                                          <th>Postal Code</th>
                                          <th>Country</th>


                                      </tr>
                                      </tfoot>
                          </table>
                                </div>
                          </div>
                          </section>