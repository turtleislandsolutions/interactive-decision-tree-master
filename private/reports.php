<?php 
session_start();
if (!$_SESSION['isLoggedIn']){
    header('Location: login.php');
}
include('../_CONFIG.php');
include('../_THEME.php');

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Interactive Decision Tree - Admin</title>
<link href="../public/css/editor.css" rel="stylesheet" type="text/css" />
<link href="../public/bower_components/bootstrap/dist/css/<?php echo BOOTSTRAP_THEME; ?>" rel="stylesheet">
<link href="../public/bower_components/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
<link href="../public/bower_components/DataTables/media/css/dataTables.bootstrap.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="editTree.php">Interactive Decision Tree</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
      <li><a href="editTree.php">Trees</a></li>
      <li><a href="theme_chooser.php">Themes</a></li>
      <li><a href="referral_sources.php">Referral Sources</a></li>
      <li><a class="active" href="reports.php">Reports</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
<div class="container">
<h1>Reports</h1>
    <div class="rep-head">
        <form class="form-inline" role="form">
            <div class="form-group">
                <label for="reportType">Report Type</label>
                <select class="form-control" name="type" id="reportType">
                    <option value="by_referrals_totals" selected=selected>Clicks by Referral</option>
                    <!-- TODO <option value="by_referral">All Clicks</option> -->
                    <option value="by_tree">Clicks Per Tree</option>
                </select>
            </div>
            <div class="form-group">
                <label for="reportStart">Start Date</label>
                <input class="datepicker sm-input form-control" name="start" id="reportStart"  data-date-format="mm/dd/yyyy" value="<?php echo  date( 'm/d/Y', strtotime('-30 days'));?>">
            </div>
            <div class="form-group">
                <label for="reportEnd">End Date</label>
                <input class="datepicker form-control sm-input" name="end" id="reportEnd"  data-date-format="mm/dd/yyyy" value="<?php echo date('m/d/Y');?>">
            </div>
            <div class="form-group">
                <button class="report-go">Go</button>
            </div>
        </form>
    </div>
    <div class="rep-container">
        <table id="repTable" class="table table-hover">

        </table>
    </div>

</div>
<script type="text/javascript" src="../public/js/jquery.min.js"></script>
<script type="text/javascript" src="../public/js/reports.js"></script>
<script type="text/javascript" src="../public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../public/bower_components/bootstrap/js/tooltip.js"></script>
<script type="text/javascript" src="../public/bower_components/bootstrap/js/popover.js"></script>
<script type="text/javascript" src="../public/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../public/bower_components/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../public/bower_components/DataTables/media/js/dataTables.bootstrap.js"></script>
</body>
<html>
