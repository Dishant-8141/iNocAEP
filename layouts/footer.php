<!-- /.container-fluid -->
<footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright &copy; 2018 GAAC. All rights reserved.</span>
          </div>
        </footer>
    </div>

  </div> 
</div>  

    <!-- /#page-wrapper -->
 
  </div>

  </div>
  <!-- /#wrapper -->
  

</body>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>
$('ul#menu-main .sub-menu').hide();
$('ul#menu-main li a').click(function(e) {
  if ($(this).next('ul.sub-menu').children().length !== 0) {
      e.preventDefault();
  }
  $(this).siblings('.sub-menu').slideToggle('slow');
});
</script>
</html>