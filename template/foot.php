      <footer class="site-footer">
          <div class="text-center">
              <?php if(head_settings('foot')==''){ echo "2015 &copy; Trino Lab.";} else { echo head_settings('foot');} ?>
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
       <script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="js/respond.min.js" ></script>
    
    <script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
  <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
    <script src="js/jquery.stepy.js"></script>
    <script src="js/tasks.js" type="text/javascript"></script>
     
    <!--script for this page only-->

      <script type="text/javascript" charset="utf-8">
          $(document).ready(function() {
              $('#example').dataTable( {
                  "aaSorting": [[ 4, "desc" ]]
              } );
          } );
      </script>

        <script>

      //step wizard

      $(function() {
          $('#default').stepy({
              backLabel: 'Previous',
              block: true,
              nextLabel: 'Next',
              titleClick: true,
              titleTarget: '.stepy-tab'
          });
      });
  </script>

  <?php
      $plugin_dir = "./plugins/";
      $js_files   = glob($plugin_dir."*/*.js");
      $js_files1  = glob($plugin_dir."*/*/*.js");
      
      foreach($js_files as $js_file)
      {
        echo '<script src="'.$js_file.'" type="text/javascript"></script>';
      }

      foreach($js_files1 as $js_file1)
      {
        echo '<script src="'.$js_file1.'" type="text/javascript"></script>';
      }
  ?>

  </body>
</html>