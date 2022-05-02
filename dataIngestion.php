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
                    Data Ingestion 
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Data Ingestion
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
  
        <div class="row">
            <div class="row">
                <div class="col-lg-12 grid-margin">
                    <div class="card overflow-hidden dashboard-curved-chart">
                        <div class="card-body mx-3">
                            <div class="card-title col-lg-12 mb-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <span class="fsize">Data Ingestion Chart</span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6">
                                        <select class="select-b form-control select-class select-status" id="status-type">
                                            <option value="">Select Metrics Operation</option>
                                            <option value="batchcount">Batch count</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <input placeholder="Enter Dataset Id" class="select-class select-b form-control" type="text" id="datasetid" name="datasetid">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <input placeholder="From" class="select-class select-b form-control" type="datetime-local" id="from" name="from">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <input placeholder="To" class="select-class select-b form-control" type="datetime-local" id="to" name="to">
                                    </div>
                                    <div class="col-lg-3 mt-2">
                                        <button type="button" class="btn btn-primary" id="filter-chart">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 85px 0px 0px 100px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
  
        <?php
            include 'layouts/footer.php';
        ?>

    <!-- <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script> -->

    <script type="text/javascript">
        // $(document).ready(function(){
            var url = window.location.href;
            url = url.slice(0, url.lastIndexOf('/'));
            $('#filter-chart').on('click', function () {
                var status_type = $('#status-type').val();
                var dataset_id = $('#datasetid').val();
                var from_date = $('#from').val();
                var to_date = $('#to').val();

                if(status_type == "" || status_type == null){
                    alert("Metric operation is required");
                    return;
                }
                if(dataset_id == "" || dataset_id == null){
                    alert("Dataset id is required");
                    return;
                }
                if(from_date == "" || from_date == null){
                    alert("Start date is required");
                    return;
                }
                if(to_date == "" || to_date == null){
                    alert("End date is required");
                    return;
                }

                drawChart(status_type, dataset_id, from_date, to_date);

            });

            function drawChart(status_type, dataset_id, from_date, to_date) {
                var data = {
                    status_type: status_type,
                    dataset_id: dataset_id,
                    from_date: from_date,
                    to_date: to_date
                }

                var chartData = $.ajax({
                    url:url + "/backend/RestAPI.php?type=bar_chart_metrics",
                    method: 'POST',
                    dataType: "json",
                    data: data,
                    async: false
                }).responseText;

                var data = JSON.parse(chartData);
                // console.log(chartData);
                // return;
                if(data.status == true){

                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Data Injestion Listing'
                        },
                        xAxis: {
                            categories: data.year,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Data Injestion'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                        '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series: data.year_value,
                        // series: [{
                        //     color: '#641E16',
                        //     name: 'PageRank',
                        //     data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
                        // } 
                        // // {
                        // //   color: '#B9770E',
                        // //   name: 'Snapshots',
                        // //   data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

                        // // }, 
                        // // {
                        // //   color: '#154360',
                        // //   name: 'Experimental Search',
                        // //   data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

                        // // }, 
                        // // {
                        // //   color: '#D35400',
                        // //   name: 'Google Books',
                        // //   data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

                        // // }
                        // ]
                    });
                }
            }
        // });
      </script>
