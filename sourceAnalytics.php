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
                Source Analytics​ 
            </h1>
            <ol class="breadcrumb">
              <li class="active">
                <i class="fa fa-dashboard"></i> Source Analytics​
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
                      <span class="fsize">Source Analytics​ Chart</span>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-lg-3">
                      <select class="select-b form-control select-class select-status" id="status-type">
                        <option value="">Select status type</option>
                        <option value="destination">Destination</option>
                        <option value="state">State</option>
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
          url: "/iNocAEP/backend/RestAPI.php?type=connection_piechart",
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
    });
      </script>