<?php
include("api/config.php");
session_start();
if(empty($_SESSION["login"])){
  header("location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Grow Online</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
      $(function() {
        // We use an inline data source in the example, usually data would
        // be fetched from a server
        var data = [],
          totalPoints = 300;
        function getRandomData() {
          if (data.length > 0)
            data = data.slice(1);
          // Do a random walk
          while (data.length < totalPoints) {
            var prev = data.length > 0 ? data[data.length - 1] : 50,
              y = prev + Math.random() * 10 - 5;
            if (y < 0) {
              y = 0;
            } else if (y > 100) {
              y = 100;
            }
            data.push(y);
          }
          // Zip the generated y values with the x values
          var res = [];
          for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]])
          }
          return res;
        }
        // Set up the control widget
        var updateInterval = 30;
        $("#updateInterval").val(updateInterval).change(function () {
          var v = $(this).val();
          if (v && !isNaN(+v)) {
            updateInterval = +v;
            if (updateInterval < 1) {
              updateInterval = 1;
            } else if (updateInterval > 2000) {
              updateInterval = 2000;
            }
            $(this).val("" + updateInterval);
          }
        });
        var plot = $.plot("#placeholder", [ getRandomData() ], {
          series: {
            shadowSize: 0 // Drawing is faster without shadows
          },
          yaxis: {
            min: 0,
            max: 100
          },
          xaxis: {
            show: false
          }
        });
        function update() {
          plot.setData([getRandomData()]);
          // Since the axes don't change, we don't need to call plot.setupGrid()
          plot.draw();
          setTimeout(update, updateInterval);
        }
        update();
        // Add the Flot version string to the footer
        $("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
      });
    </script>
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="dashboard.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>G</b>O</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Grow</b>Online</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <!--<span class="label label-info">10</span>-->
                </a>
                <ul class="dropdown-menu">
                  <li class="header">No notifications</li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                      <!--<li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>--><!-- end notification -->
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>              
              <!-- User Account: style can be found in dropdown.less -->

<?php
try{
  $bdd = new PDO("mysql:host=" . $configHostBdd . ";dbname=" . $configNameBdd .";charset=utf8", $configUserBdd, $configPassBdd);
}
catch (Exception $e){
  die($e->getMessage());
}

$request = $bdd->prepare('SELECT * FROM users WHERE id = :id');
$request ->execute(array(
    'id' => $_SESSION["id"]
    ));

$data = $request->fetch();

if(empty($data["avatar"])) $avatar = "dist/img/user2-160x160.jpg";
else $avatar = $data["avatar"];

if($data["admin"] == 1) $status = "Admin";
else $status = "User";
?>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo($avatar) ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo($data["login"])?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo($avatar) ?>" class="img-circle" alt="User Image">
                    <p>
                      <?php echo($data["login"])?>
                      <small><?php echo($status) ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                    <a href="editUserProfile.php" class="btn btn-default btn-flat">Edit</a>
                    </div>
                    <div class="pull-right">
                      <a href="api/logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>

              </li>
              
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <!--<li class="header">HEADER</li>-->
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="#"><i class="fa fa-tv"></i> <span>Dashboard</span></a></li>
            <li><a href="profiles.php"><i class="fa fa-link"></i> <span>Profiles</span></a></li>
            <li><a href="settings.php"><i class="fa fa-gear"></i> <span>Settings</span></a></li>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
         
        </section>

        <!-- Main content -->
        <section class="content">

        <div class="row">
          
            <div class="col-md-8 col-xs-12">
              <!-- interactive chart -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">Temperature/Humidity</h3>
                </div>
                <div class="box-body">
                  <div id="interactive" style="height: 300px;"></div>
                </div><!-- /.box-body-->
              </div><!-- /.box -->

            </div><!-- /.col -->

          <div class="col-md-4 col-xs-12">

                <!-- Info Boxes Style 2 -->
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="fa fa-link"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Current Profile</span>
                    <span class="info-box-number" id="currentProfile">Floraison</span>
                    <a href="edit.php"><button class="btn btn-default">Edit</button></a>
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="ion ion-leaf"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Environnement</span>
                    <span class="info-box-number" id="temperature"></span>                    
                    <span class="info-box-number" id="humidity"></span>      
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="ion ion-android-sunny"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Lamp</span>
                    <span class="info-box-number" id="lamp"></span>                    
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-maroon">
                  <span class="info-box-icon"><i class="ion ion-load-b"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Fan</span>
                    <span class="info-box-number" id="fan"></span>                    
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-aqua">
                  <span class="info-box-icon"><i class="ion ion-waterdrop"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Water Pump</span>
                    <span class="info-box-number" id="waterPump"></span>                    
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-purple">
                  <span class="info-box-icon"><i class="fa fa-tv"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Uptime</span>
                    <span class="info-box-number" id="uptime"></span>                    
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

          </div>

        </div> <!--/.row-->
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
    <!--  <footer class="main-footer">
        <!-- To the right -->
        <!--<div class="pull-right hidden-xs">
          Anything you want
        </div>
        <!-- Default to the left -->
        <!--<strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.
      </footer>-->

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js"></script>     
     <!-- FLOT CHARTS -->
    <script src="plugins/flot/jquery.flot.min.js"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="plugins/flot/jquery.flot.resize.min.js"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="plugins/flot/jquery.flot.pie.min.js"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="plugins/flot/jquery.flot.categories.min.js"></script>
    
        <!-- Page script -->
    <script>
      $(function () {
        /*
         * Flot Interactive Chart
         * -----------------------
         */
        // We use an inline data source in the example, usually data would
        // be fetched from a server
        var data = [], totalPoints = 100;
        function getRandomData() {

          if (data.length > 0)
            data = data.slice(1);

          // Do a random walk
          while (data.length < totalPoints) {

            var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;

            if (y < 0) {
              y = 0;
            } else if (y > 100) {
              y = 100;
            }

            data.push(y);
          }

          // Zip the generated y values with the x values
          var res = [];
          for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]]);
          }

          return res;
        }

        var interactive_plot = $.plot("#interactive", [getRandomData()], {
          grid: {
            borderColor: "#f3f3f3",
            borderWidth: 1,
            tickColor: "#f3f3f3"
          },
          series: {
            shadowSize: 0, // Drawing is faster without shadows
            color: "#3c8dbc"
          },
          lines: {
            fill: true, //Converts the line chart to area chart
            color: "#3c8dbc"
          },
          yaxis: {
            min: 0,
            max: 100,
            show: true
          },
          xaxis: {
            show: true
          }
        });

        var updateInterval = 500; //Fetch data ever x milliseconds
        var realtime = "on"; //If == to on then fetch data every x seconds. else stop fetching
        function update() {

          interactive_plot.setData([getRandomData()]);

          // Since the axes don't change, we don't need to call plot.setupGrid()
          interactive_plot.draw();
          if (realtime === "on")
            setTimeout(update, updateInterval);
        }

        //INITIALIZE REALTIME DATA FETCHING
        if (realtime === "on") {
          update();
        }
        //REALTIME TOGGLE
        $("#realtime .btn").click(function () {
          if ($(this).data("toggle") === "on") {
            realtime = "on";
          }
          else {
            realtime = "off";
          }
          update();
        });
        /*
         * END INTERACTIVE CHART
         */


        /*
         * LINE CHART
         * ----------
         */
        //LINE randomly generated data

        var sin = [], cos = [];
        for (var i = 0; i < 14; i += 0.5) {
          sin.push([i, Math.sin(i)]);
          cos.push([i, Math.cos(i)]);
        }
        var line_data1 = {
          data: sin,
          color: "#3c8dbc"
        };
        var line_data2 = {
          data: cos,
          color: "#00c0ef"
        };
        $.plot("#line-chart", [line_data1, line_data2], {
          grid: {
            hoverable: true,
            borderColor: "#f3f3f3",
            borderWidth: 1,
            tickColor: "#f3f3f3"
          },
          series: {
            shadowSize: 0,
            lines: {
              show: true
            },
            points: {
              show: true
            }
          },
          lines: {
            fill: false,
            color: ["#3c8dbc", "#f56954"]
          },
          yaxis: {
            show: true,
          },
          xaxis: {
            show: true
          }
        });
        //Initialize tooltip on hover
        $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
          position: "absolute",
          display: "none",
          opacity: 0.8
        }).appendTo("body");
        $("#line-chart").bind("plothover", function (event, pos, item) {

          if (item) {
            var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);

            $("#line-chart-tooltip").html(item.series.label + " of " + x + " = " + y)
                    .css({top: item.pageY + 5, left: item.pageX + 5})
                    .fadeIn(200);
          } else {
            $("#line-chart-tooltip").hide();
          }

        });
        /* END LINE CHART */

        /*
         * FULL WIDTH STATIC AREA CHART
         * -----------------
         */
        var areaData = [[2, 88.0], [3, 93.3], [4, 102.0], [5, 108.5], [6, 115.7], [7, 115.6],
          [8, 124.6], [9, 130.3], [10, 134.3], [11, 141.4], [12, 146.5], [13, 151.7], [14, 159.9],
          [15, 165.4], [16, 167.8], [17, 168.7], [18, 169.5], [19, 168.0]];
        $.plot("#area-chart", [areaData], {
          grid: {
            borderWidth: 0
          },
          series: {
            shadowSize: 0, // Drawing is faster without shadows
            color: "#00c0ef"
          },
          lines: {
            fill: true //Converts the line chart to area chart
          },
          yaxis: {
            show: false
          },
          xaxis: {
            show: false
          }
        });

        /* END AREA CHART */

        /*
         * BAR CHART
         * ---------
         */

        var bar_data = {
          data: [["January", 10], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9]],
          color: "#3c8dbc"
        };
        $.plot("#bar-chart", [bar_data], {
          grid: {
            borderWidth: 1,
            borderColor: "#f3f3f3",
            tickColor: "#f3f3f3"
          },
          series: {
            bars: {
              show: true,
              barWidth: 0.5,
              align: "center"
            }
          },
          xaxis: {
            mode: "categories",
            tickLength: 0
          }
        });
        /* END BAR CHART */

        /*
         * DONUT CHART
         * -----------
         */

        var donutData = [
          {label: "Series2", data: 30, color: "#3c8dbc"},
          {label: "Series3", data: 20, color: "#0073b7"},
          {label: "Series4", data: 50, color: "#00c0ef"}
        ];
        $.plot("#donut-chart", donutData, {
          series: {
            pie: {
              show: true,
              radius: 1,
              innerRadius: 0.5,
              label: {
                show: true,
                radius: 2 / 3,
                formatter: labelFormatter,
                threshold: 0.1
              }

            }
          },
          legend: {
            show: false
          }
        });
        /*
         * END DONUT CHART
         */

      });

      /*
       * Custom Label formatter
       * ----------------------
       */
      function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
                + label
                + "<br>"
                + Math.round(series.percent) + "%</div>";
      }

      function updateData(){
        //alert("test");
        $.ajax({
            url : 'api/getStatus.php',
            type : 'GET',
            data : '',
            dataType : 'html',
            success : function(result, status){
              if(result == "403"){
                alert("You must be connected.");
                window.location.href = "index.php";


              }
              if(result != "false"){
                var array = result.split(";");
                $("#currentProfile").html(array[0]);
                $("#temperature").html("Temperature: " + array[1] + "°C");
                $("#humidity").html("Humidity: "  + array[2]  + "%");
                $("#lamp").html(array[3]);
                $("#fan").html(array[4]);
                $("#waterPump").html(array[5]);
                $("#uptime").html(array[6]);
              }
            },

            error : function(result, statut, error){
              $("#currentProfile").html("N/A");
              $("#temperature").html("Temperature: N/A");
              $("#humidity").html("Humidity: N/A");
              $("#lamp").html("N/A");
              $("#fan").html("N/A");
              $("#waterPump").html("N/A");
              $("#uptime").html("N/A");
            }

          });
        setTimeout(updateData,2000);
      }
      updateData();
    </script>

  </body>
</html>