<?php
  include 'layouts/sidebar.php';
?>
<div class="container-fluid">
  <style>
    #filter-chart{
      font-size: medium;
      width: 150px;
      background-color: #3276b1 !important;
      border-color: #3276b1 !important;
    },
  </style>
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Flow Details 
            </h1>
            <ol class="breadcrumb">
              <li class="active">
                <i class="fa fa-dashboard"></i> Flow Details
              </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <!-- <div class="content-wrapper"> -->
        <div class="row">
          <div class="col-lg-12 grid-margin">
            <div class="card overflow-hidden dashboard-curved-chart">
              <div class="card-body mx-3">
                <div class="card-title col-lg-12 mb-0">
                  <div class="row">
                    <div class="col-lg-12">
                      <span class="fsize">Flow Service Chart</span>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-lg-3">
                      <select class="select-b form-control select-class select-status" id="status-type">
                        <option value="">Select status type</option>
                        <option value="flow">Flow</option>
                        <option value="last_dataflow_run">Last Dataflow Run Status</option>
                        <option value="error">Error</option>
                      </select>
                    </div>
                    <div class="col-lg-3">
                      <input placeholder="From" class="select-class select-b form-control" type="datetime-local" id="from" name="from">
                    </div>
                    <div class="col-lg-3">
                      <input placeholder="To" class="select-class select-b form-control" type="datetime-local" id="to" name="to">
                    </div>
                    <div class="col-lg-3">
                      <button type="button" class="btn btn-primary" id="filter-chart">Submit</button>
                    </div>
                  </div>
                </div>
                <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 85px 0px 0px 100px;">
                  <div id="piechart" style="width: 900px; height: 500px;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- </div> -->
    </div>
  </div>


<?php
  include 'layouts/footer.php';
?>

<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function (params) {
      google.charts.load('current', {'packages':['corechart']});

      $('#filter-chart').on('click', function () {
        var status_type = $('#status-type').val();
        if(status_type == "" || status_type == null){
          alert("Please select at least one status type");
          return;
        }
        var from = $('#from').val();
        var to = $('#to').val();
        var from_date = (from != "" && from != null) ? from : null;
        var to_date = (to != "" && to != null) ? to : null;

        google.charts.setOnLoadCallback(drawChart(status_type, from_date, to_date));
      })

      function drawChart(status_type, from_date, to_date) {

        var chartData = $.ajax({
          url: "/backend/RestAPI.php?type=flowservice_piechart",
          method: 'POST',
          dataType: "json",
          data: {
              'status_type': status_type,
              'from_date': from_date,
              'to_date': to_date
          },
          async: false
        }).responseText;

        // console.log(JSON.parse(chartdata));return;
        var allData = JSON.parse(chartData);
        // console.log(allData);return;
        if(allData.status == true){
          var newdata = google.visualization.arrayToDataTable(allData.data);
          console.log(newdata);

          var chartTitle = allData.data[0];
          console.log(chartTitle[0]);
          var options = {
            // title: 'Flow percentage'
            title: chartTitle[0]+' '+chartTitle[1]
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
          chart.draw(newdata, options);
        }else{
          alert(allData.message);
        }
      }
      // Highcharts.chart('container2', {
      //   chart: {
      //     plotBackgroundColor: null,
      //     plotBorderWidth: null,
      //     plotShadow: false,
      //     type: 'pie'
      //   },
      //   title: {
      //     text: 'Flow Service Chart'
      //   },
      //   tooltip: {
      //     pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      //   },
      //   plotOptions: {
      //     pie: {
      //       allowPointSelect: true,
      //       cursor: 'pointer',
      //       dataLabels: {
      //         enabled: false
      //       },
      //       showInLegend: true
      //     }
      //   },
      //   series: [{
      //     name: 'Brands',
      //     colorByPoint: true,
      //     data: [
      //     {
      //       color: '#641E16',
      //       name: 'PageRank',
      //       y: 11.84
      //     },
      //     {
      //       color: '#B9770E',
      //       name: 'Snapshots',
      //       y: 10.85
      //     },
      //     {
      //       color: '#154360',
      //       name: 'Experimental Search',
      //       y: 4.67
      //     },
      //     {
      //       color: '#D35400',
      //       name: 'Google Books',
      //       y: 4.18
      //     }
      //     ]
      //   }]
      // });
      // $( function() {
      //   var dateFormat = "mm/dd/yy",
      //   from = $( "#from" )
      //   .datepicker({
      //     defaultDate: "+1w",
      //     changeMonth: true,
      //     // numberOfMonths: 3
      //   })
      //   .on( "change", function() {
      //     to.datepicker( "option", "minDate", getDate( this ) );
      //   }),
      //   to = $( "#to" ).datepicker({
      //     defaultDate: "+1w",
      //     changeMonth: true,
      //     // numberOfMonths: 3
      //   })
      //   .on( "change", function() {
      //     from.datepicker( "option", "maxDate", getDate( this ) );
      //   });
  
      //   function getDate( element ) {
      //     var date;
      //     try {
      //       date = $.datepicker.parseDate( dateFormat, element.value );
      //     } catch( error ) {
      //       date = null;
      //     }
  
      //     return date;
      //   }
      // });
    });
      </script>