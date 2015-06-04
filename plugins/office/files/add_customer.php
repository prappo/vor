<div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Add new Customer
                          </header>
                          <div class="panel-body">
                              <form class="form-horizontal tasi-form" method="post">
                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Customer Name</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control" name="customerName">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Phone</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control" name="phone">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Address</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control" name="address">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">City</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control" name="city">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">State</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control" name="state">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Postal Code</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control" name="postalCode">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Country</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control" name="county">
                                      </div>
                                  </div>
                                  <button type="submit" class="btn btn-info" name="add"><i class="fa fa-plus"></i> Add new customer</button>
                                  </div>
                                  </form>
                                  </div>
                                  </section>
                                  </div>
                                  </div>


                                <script>
                                  function added(){
                                  swal({ 
                                    title: "Success", 
                                    text: "New customer Added", 
                                    type: "success",   
                                    confirmButtonText: "Ok" , timer: 2000 });
                                  }

                                </script>

                                <?php
                                $id = rand(1000,9999);
                                $name = $_POST['customerName'];
                                $phone = $_POST['phone'];
                                $address = $_POST['address'];
                                $city = $_POST['city'];
                                $state = $_POST['state'];
                                $postalCode = $_POST['postalCode'];
                                $county = $_POST['county'];
                                $host_name = HOST;
                                $user_name = USER;
                                $password = PASS;


                                if(isset($_POST['add']))
                                {
                                  if($name=='')
                                  {
                                    echo "<div><script>alert('Please enter customer name');</script></div>";
                                  }
                                  else 
                                  {

                                  mysql_connect($host_name, $user_name, $password) or die ("unable to connect with server");
                                  mysql_select_db('classicmodels');
                                  $sql = "INSERT INTO customers(customerNumber, name, phone, address, city, state, postalCode, country)VALUES('$id', '$name', '$phone', '$address', '$city', '$state', '$postalCode', '$county')";
                                  $query = mysql_query($sql);
                                  if($query)
                                  {
                                    echo "<div><script>added();</script></div>";
                                  }
                                  else
                                  {
                                    echo "<div><script>alert('something went wrong');</script></div>";
                                    echo mysql_error();
                                  }
                                
                                    

                                  
                                    
                                  }

                                }

                                  ?>
