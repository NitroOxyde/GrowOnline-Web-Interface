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
    <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="plugins/ionicons/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="plugins/select2/select2.min.css">

    <link rel="stylesheet" href="dist/css/main.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
          <a href="#" class="sidebar-toggle" onclick="toggleSidebar()" data-toggle="offcanvas" role="button">
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
                    <a href="editUserProfile.php?id=<?php echo($data["id"])?>" class="btn btn-default btn-flat">Edit</a>
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

            <div class="col-md-6 col-xs-12">
              <!-- interactive chart -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">Temperature</h3>
                </div>
                <div class="box-body">
                  <div id="temperature_chart" style="height: 300px;"></div>
                </div><!-- /.box-body-->
              </div><!-- /.box -->

            </div><!-- /.col -->

            <div class="col-md-6 col-xs-12">
              <!-- interactive chart -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">Humidity</h3>
                </div>
                <div class="box-body">
                  <div id="humidity_chart" style="height: 300px;"></div>
                </div><!-- /.box-body-->
              </div><!-- /.box -->

            </div><!-- /.col -->

          <div class="col-md-6 col-xs-12">



                <!-- Info Boxes Style 2 -->
                <div class="info-box bg-yellow">
                  <a onclick="updateSelect();" class="info-box-icon" style="cursor: pointer;"><i class="fa fa-link" style="color: white;"></i></a>
                  <div class="info-box-content">
                    <span class="info-box-text">Current Profile</span>
                    <div class="form-group">
                    <select onchange="onSelectChange();" id="select" class="form-control select2" style="width: 75%;">
                      <?php include("api/getProfilesList.php");?>
                    </select>
                    <a href="edit.php" style="display: inline-block;"><button class="btn btn-default">Edit</button></a>
                  </div><!-- /.form-group -->
                    <!--<span class="info-box-number" id="currentProfile"></span>-->

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
                  <a onclick="trigger('lamp');" class="info-box-icon" style="cursor: pointer;"><i class="ion ion-android-sunny" style="color: white;"></i></a>
                  <div class="info-box-content">
                    <span class="info-box-text">Lamp</span>
                    <span class="info-box-number" id="lamp"></span>
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-maroon">
                  <a onclick="trigger('fan');" class="info-box-icon" style="cursor: pointer;"><i class="ion ion-load-b" style="color: white;"></i></a>
                  <div class="info-box-content">
                    <span class="info-box-text">Fan</span>
                    <span class="info-box-number" id="fan"></span>
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

          </div>

          <div class="col-md-6 col-xs-12">


                <div class="info-box bg-orange">
                  <a onclick="trigger('heater');" class="info-box-icon" style="cursor: pointer;"><i class="glyphicon glyphicon-fire" style="color: white;"></i></a>
                  <div class="info-box-content">
                    <span class="info-box-text">Heater</span>
                    <span class="info-box-number" id="heater"></span>
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-aqua">
                  <a onclick="trigger('waterPump');" class="info-box-icon" style="cursor: pointer;"><i class="ion ion-waterdrop" style="color: white;"></i></a>
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

    <script src="plugins/select2/select2.full.min.js"></script>

    <script src="dist/js/main.js"></script>

  </body>
</html>
