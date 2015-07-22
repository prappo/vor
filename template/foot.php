      <footer class="site-footer">
          <div class="text-center">
              <?php echo (head_settings('foot') == '') ? "2015 &copy; Trino Lab." : head_settings('foot'); ?>
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>
    <!-- js placed at the end of the document so the pages load faster -->
  <script type="text/javascript" src="assets/advanced-datatable/media/js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
  <script type="text/javascript" src="js/jquery.scrollTo.min.js"></script>
  <script type="text/javascript" src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <script type="text/javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
  <script type="text/javascript" src="js/respond.min.js" ></script>
  <script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
  <?php
    set_js_footer();
  ?>
  <!--common script for all pages-->
  <script src="js/common-scripts.js"></script>
  <script src="js/jquery.stepy.js"></script>
  <script src="js/tasks.js" type="text/javascript"></script>
   
  <!--script for this page only-->
  <script>
    $(document).ready(function() {
        $('#example').dataTable( {
            "aaSorting": [[ 4, "desc" ]]
        } );
    } );
  </script>
  <!-- step wizard -->
  <script>
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
  </body>
</html>