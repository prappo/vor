<div class="col-md-6 col-md-offset-3">
    <div class="login-panel panel panel-default">
      <div class="panel-body">
        <form role="form" enctype="multipart/form-data" method="post" action="">
          <h2 align="center">Database Export and Import center</h2><br>
          <div align="center"><input type="button" id="btn-export" class="btn btn-outline btn-success" value="Export DB">
          <input type="button" id="btn-import" class="btn btn-outline btn-success" value="Import DB"></div>
          <br><br>
           <div align="center" id="preloader">
          
          </div>
          <div id="import">
         
        </di>
        </form>
      </div>
    </div>
    <div class="text-center">
          </div>
  </div>
  
  <script type="text/javascript" charset="utf-8">
  
      $(document).ready(function(){
          $("#import").hide();
          
      });
      
      $("#btn-import").click(function(){
         
         $("#import").html(" <div align='center'><input type='file' name='zip_file'> </div><br><div align='center'><input type='button'  id='btn-import-submit' class='btn btn-outline btn-success' value='Go'></div>");
      
          $("#import").show(200); 
          alert("Importing Database is not available right now , please wait for next version of VOR or try manually");
      });
      
      $("#btn-export").click(function(){
         
          $("#preloader").html("<img src='img/Preloader.gif'></img>");
          $("#preloader").delay(500).show(0);;

          window.location.replace("lib/backup_action.php?action=export");
          $("#preloader").hide(100);

      });
      
  </script>
  