<?php
error_reporting(0);
include('data.php');

//Overview
$overview = getAllDataOverview();
$TotalCases = number_format($overview['cases']);
$TotalRecovered = number_format($overview['recovered']);
$TotalDeaths = number_format($overview['deaths']);
$LastUpdate = getTime(substr($overview['updated'], 0, -3));

if(isset($_GET[1])){
    $DataOverview = getOverviewCountry($_GET[1]);
    if($DataOverview == null) exit();

    $QName = $DataOverview['country'];
    $QFlag = $DataOverview['countryInfo']['flag'];
    $QCase = number_format($DataOverview['cases']);
    $QTodayCases = number_format($DataOverview['todayCases']);
    $QDeath = number_format($DataOverview['deaths']);
    $QTodayDeath = number_format($DataOverview['todayDeaths']);
    $QRecovered = number_format($DataOverview['recovered']);
    $QActive = number_format($DataOverview['active']);
    $QCritical = number_format($DataOverview['critical']);

    $percent1 = round((filter_var($QDeath, FILTER_SANITIZE_NUMBER_INT)/filter_var($QCase, FILTER_SANITIZE_NUMBER_INT)) * 100, 2);
    $percent2 = round((filter_var($QRecovered, FILTER_SANITIZE_NUMBER_INT)/filter_var($QCase, FILTER_SANITIZE_NUMBER_INT)) * 100, 2);
    $percent3 = round((filter_var($QCritical, FILTER_SANITIZE_NUMBER_INT)/filter_var($QCase, FILTER_SANITIZE_NUMBER_INT)) * 100, 2);
    $percent4 = round( (filter_var($QTodayCases, FILTER_SANITIZE_NUMBER_INT) / (filter_var($QCase, FILTER_SANITIZE_NUMBER_INT) - filter_var($QTodayCases, FILTER_SANITIZE_NUMBER_INT))) * 100, 2);
    $percent5 = round( (filter_var($QTodayDeath, FILTER_SANITIZE_NUMBER_INT) / (filter_var($QDeath, FILTER_SANITIZE_NUMBER_INT) - filter_var($QTodayDeath, FILTER_SANITIZE_NUMBER_INT))) * 100, 2);
}
                
$abc = getStatistic();
$country_list = getCountryList();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>#MY/Corona - Providing a statistic about coronavirus cases</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $domain; ?>/images/favicon.png">
    <!-- Pignose Calender -->
    <link href="<?php echo $domain; ?>/plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <link href="<?php echo $domain; ?>/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="<?php echo $domain; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo $domain; ?>/css/flag.css" rel="stylesheet">
    <style>
        .dataTables_filter {
            display: none;
        }


    </style>

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="<?php echo $domain; ?>">
                    <img src="<?php echo $domain; ?>/images/logo-compact.png" class="logoss" alt="">
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            <div class="header-content clearfix">
                <div class="header-left">

                </div>
                <div class="header-right">
                    <p>Brought to you, by <b><a href="http://pgzulfaqar.com/">@pgzulfaqar</a></b></p>
                </div>
            </div>
        </div>

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-black">Overview</h3>
                                <div class="d-inline-block">
                                    <!-- CONDITION HERE !--->
                                    <?php
                                    if($_GET[1] != '') {
                                        echo '<h2 class="text-black">'.$QName.' <img src="'.$QFlag.'" width="50"/></h2>';
                                    }else{
                                        echo '<h2 class="text-black">Global <img src="'.$domain.'/images/globe.png" width="30"/></img> </h2>';
                                    }
                                    ?>
                                    <p class="text-black mb-0"><img src="<?php echo $domain; ?>/images/media/live.gif" width="20"/></img> <b>Live Now</b></p>
                                    <br/>
                                        <div class="dropdown dropright">
                                            <button type="button" class="btn btn-sm btn-outline-primary " data-toggle="dropdown" aria-expanded="false">Change country <i class="fa fa-angle-down m-l-5"></i>
                                            </button>
                                            <div id="myDropdown" class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="height:400px;overflow-y:auto;">
                                            <div class="form-group" style="padding-right:5px;padding-left:5px;margin-bottom:-3px;">
                                                <input type="text" class="form-control form-control-sm search-country" placeholder="Search country..." onkeyup="filterFunction()" id="mySearchBox">
                                            </div>
                                            <div class="dropdown-divider"></div>
                                            <?php

                                            foreach ($country_list as $test) {
                                                    $country = $test['country'];
                                                    echo '<a class="dropdown-item" href="'.$domain.'country/'.strtolower($country).'">'.$country.'</a> ';
                                                }
                                        
                                            ?>
                                            </div>
                                        </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">
                                <h3 class="card-title text-white">Total Casses</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $_GET[1] == '' ? $TotalCases : $QCase; ?></h2>
                                    <p class="text-white mb-0"> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <div class="card-body">
                                <h3 class="card-title text-white">Total Recovered</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $_GET[1] == '' ? $TotalRecovered : $QRecovered; ?></h2>
                                    <p class="text-white mb-0"> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <div class="card-body">
                                <h3 class="card-title text-white">Total Deaths</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $_GET[1] == '' ? $TotalDeaths : $QDeath; ?></h2>
                                    <p class="text-white mb-0"></p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!---- Test HERE---->
                </div>



                <div class="row">
                        <?php
                        if($_GET[1] == ''){
                            $percent2 = round((filter_var($TotalRecovered, FILTER_SANITIZE_NUMBER_INT)/filter_var($TotalCases, FILTER_SANITIZE_NUMBER_INT)) * 100);
                            $percent3 = round((filter_var($TotalDeaths, FILTER_SANITIZE_NUMBER_INT)/filter_var($TotalCases, FILTER_SANITIZE_NUMBER_INT)) * 100);
                        ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="card card-widget">
                                <div class="card-body" stle="color:#000;">
                                    <h5 class="text">Today's Overview </h5>
                                    <p class="text">Last Update on: <br/><span><b><?php echo $LastUpdate; ?> (GMT+8)</b></span> </p>
                                    <div class="mt-4">
                                        <h4><?php echo $TotalCases; ?></h4>
                                        <h6>Active Cases <span class="pull-right"></span></h6>
                                        <div class="progress mb-3" style="height: 7px">
                                            <div class="progress-bar bg-primary" style="width: 100%;" role="progressbar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h4><?php echo $TotalRecovered; ?></h4>
                                        <h6>Total Recovered <span class="pull-right"><?php echo $percent2; ?>%</span></h6>
                                        <div class="progress mb-3" style="height: 7px">
                                            <div class="progress-bar bg-success" style="width: <?php echo $percent2; ?>%;" role="progressbar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h4><?php echo $TotalDeaths; ?></h4>
                                        <h6>Total Deaths<span class="pull-right"><?php echo $percent3; ?>%</span></h6>
                                        <div class="progress mb-3" style="height: 7px">
                                            <div class="progress-bar bg-warning" style="width: <?php echo $percent3; ?>%;" role="progressbar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <?php
                        }else{
                        ?>
                        <div class="<?php echo (strtolower($_GET[1]) == 'malaysia') ? 'col-lg-3 col-md-6' : 'col-lg-6 col-md-12'; ?>">
                            <div class="card card-widget">
                                <div class="card-body" stle="color:#000;">
                                    <h5 class="text">Today's Overview </h5>
                                    <p class="text">Last Update on: <br/><span><b><?php echo $LastUpdate; ?> (GMT+8)</b></span> </p>
                                    <h5 class="mt-4"><span class="label label-info">+<?php echo $QTodayCases;
                                    echo ' ('.$percent4.'%)'; ?></h5>
                                    <p>New cases</p>
                                    <h5 class="mt-4"><span class="label label-danger">+<?php echo $QTodayDeath;
                                    echo ' ('.$percent5.'%)'; ?></span></h5>
                                    <p>New death cases</p>
                                    <div class="mt-4">
                                        <h4><?php echo $QActive; ?></h4>
                                        <h6>Active Cases <span class="pull-right"></span></h6>
                                        <div class="progress mb-3" style="height: 7px">
                                            <div class="progress-bar bg-primary" style="width: 100%;" role="progressbar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h4><?php echo $QRecovered; ?></h4>
                                        <h6>Total Recovered <span class="pull-right"><?php echo $percent2; ?>%</span></h6>
                                        <div class="progress mb-3" style="height: 7px">
                                            <div class="progress-bar bg-success" style="width: <?php echo $percent2; ?>%;" role="progressbar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h4><?php echo $QCritical; ?></h4>
                                        <h6>Total Critical<span class="pull-right"><?php echo $percent3; ?>%</span></h6>
                                        <div class="progress mb-3" style="height: 7px">
                                            <div class="progress-bar bg-warning" style="width: <?php echo $percent3; ?>%;" role="progressbar">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h4><?php echo $QDeath; ?></h4>
                                        <h6>Total Deaths<span class="pull-right"><?php echo $percent1; ?>%</span></h6>
                                        <div class="progress mb-3" style="height: 7px">
                                            <div class="progress-bar bg-danger" style="width: <?php echo $percent1; ?>%;" role="progressbar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <?php
                        }

                        if(strtolower($_GET[1]) == 'malaysia'){
                        ?>

                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-0">
                                    <h4 class="card-title px-4 mb-3">Latest by KKM</h4>
                                    <a data-tweet-limit="1" class="twitter-timeline" href="https://twitter.com/KKMPutrajaya?ref_src=twsrc%5Etfw"></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Most Infected Country</h4>
                                    <p>Top 10 Country</p>
                                     <div class="table-responsive">
                                    <table class="table header-border">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Country</th>
                                                <th>Total Casses</th>
                                                <th>Total Recovered</th>
                                                <th>Total Deaths</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            foreach ($abc as $item) {
                                                $no = $count + 1;

                                                if($count != 10){
                                                    $country = $item['country'];
                                                    $total_case = number_format($item['cases']);
                                                    $deaths = number_format($item['deaths']);
                                                    $recovered = number_format($item['recovered']);
                                                    $flag = $item['countryInfo']['flag'];
                                                    echo ' <tr>
                                                <td><a href="javascript:void(0)">'.$no.'</a></td>
                                                <td><span class="text-bold"><img src="'.$flag.'" width="25"/> <a href="'.$domain.'country/'.$country.'">'.$country.'</a></span></td>
                                                <td><span class="label label-info rounded">'.$total_case.'</span></td>
                                                <td><span class="label label-success rounded">'.$recovered.'</span></td>
                                                <td><span class="label label-danger rounded">'.$deaths.'</span></td>
                                                </tr>';
                                                    
                                                    $count++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            
                        </div>    
                    </div>

                    <?php
                    if($_GET[1] != ''){

                    ?>
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body pb-0 d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-1"><img src="<?php echo $QFlag; ?>" width="40"/> <?php echo $QName;?> CoronaVirus Cases</h4>
                                            <p>Coronavirus History Growth</p>
                                        </div>
                                    </div>
                                    <div class="chart-wrapper">
                                        <div id="line-chart-tooltips" class="ct-chart ct-golden-section"></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="statistic" width="100%" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Date</th>
                                                                <th>Total Cases</th>
                                                                <th>Total Recovered</th>
                                                                <th>Total Deaths</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            $data = getDataView($_GET[1]);
                                                            
                                                            $dataR = array_reverse($data);
                                                            $i = 0;
                                                            for($i =0; $i < count($dataR);$i++){
                                                                $count = $i+1;
                                                                echo '<tr>
                                                                <td>'.$count.'</td>
                                                                <td>'.$dataR[$i][0].'</td>
                                                                <td>'.number_format($dataR[$i][1]).'</td>
                                                                <td>'.$dataR[$i][2].'</td>
                                                                <td>'.number_format($dataR[$i][3]).'</td>
                                                                </tr>';
                                                                }
                                                                ?>
                                                        </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <!-- #/ container -->
        </div>

        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Developed by <a href="https://instagram.com/pgzulfaqar">Pg Zulfaqar</a>. Designed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> <?php echo date("Y"); ?></p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="<?php echo $domain; ?>/plugins/common/common.min.js"></script>
    <script src="<?php echo $domain; ?>/js/custom.min.js"></script>
    <script src="<?php echo $domain; ?>/js/settings.js"></script>
    <script src="<?php echo $domain; ?>/js/gleek.js"></script>
    <script src="<?php echo $domain; ?>/js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="<?php echo $domain; ?>/plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="<?php echo $domain; ?>/plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="<?php echo $domain; ?>/plugins/d3v3/index.js"></script>
    <script src="<?php echo $domain; ?>/plugins/topojson/topojson.min.js"></script>
    <script src="<?php echo $domain; ?>/plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="<?php echo $domain; ?>/plugins/raphael/raphael.min.js"></script>
    <script src="<?php echo $domain; ?>/plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="<?php echo $domain; ?>/plugins/moment/moment.min.js"></script>
    <script src="<?php echo $domain; ?>/plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="<?php echo $domain; ?>/plugins/chartist/js/chartist.min.js"></script>
    <script src="<?php echo $domain; ?>/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>
    <script src="<?php echo $domain; ?>/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $domain; ?>/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo $domain; ?>/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>


    <script src="<?php echo $domain; ?>/js/dashboard/dashboard-1.js"></script>

    <script>
            new Chartist.Line('#line-chart-tooltips', {
            labels: [<?php
                        for($i =0; $i < count($data);$i++){
                            $count = $i+1;
                            echo "'".$count."', ";
                        }
                    ?>],
            series: [
              {
                name: 'Total Cases',
                data: [<?php
                        for($i =0; $i < count($data);$i++){
                            echo "'".$data[$i][1]."', ";
                        }
                    ?>]
              },
              {
                name: 'Total Deaths',
                data: [<?php
                        for($i =0; $i < count($data);$i++){
                            echo "'".$data[$i][3]."', ";
                        }
                    ?>]
              },
             {
                name: 'Total Recovered',
                data: [<?php
                        for($i =0; $i < count($data);$i++){
                            echo "'".$data[$i][2]."', ";
                        }
                    ?>]
              }
            ]
          },
              {
            plugins: [
              Chartist.plugins.tooltip()
            ]
          }
          );
          
          var $chart = $('#line-chart-tooltips');
          
          var $toolTip = $chart
            .append('<div class="tooltip"></div>')
            .find('.tooltip')
            .hide();
          
          $chart.on('mouseenter', '.ct-point', function() {
            var $point = $(this),
              value = $point.attr('ct:value'),
              yvalue = $point.attr('y2'),
              seriesName = $point.parent().attr('ct:series-name');
            $toolTip.html(seriesName + '<br>' + value).show();
          });
          
          $chart.on('mouseleave', '.ct-point', function() {
            $toolTip.hide();
          });
          
          $chart.on('mousemove', function(event) {
            $toolTip.css({
              left: (event.offsetX || event.originalEvent.layerX) - $toolTip.width() / 2 - 10,
              top: (event.offsetY || event.originalEvent.layerY) - $toolTip.height() - 40
            });
          });

    function filterFunction() {
      var input, filter, ul, li, a, i;
      input = document.getElementById("mySearchBox");
      filter = input.value.toUpperCase();
      div = document.getElementById("myDropdown");
      a = div.getElementsByTagName("a");
      for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          a[i].style.display = "";
        } else {
          a[i].style.display = "none";
        }
      }
    }


          /** TABLES **/
    $(document).ready(function() {
        $('#statistic').DataTable();
    } );
    </script>
</body>

</html>