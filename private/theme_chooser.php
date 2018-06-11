<?php 
session_start();
if (!$_SESSION['isLoggedIn']){
    header('Location: login.php');
}
include('../_CONFIG.php');
include('../_THEME.php');

if ($_POST){
    $f = fopen('../_THEME.php', 'w') or die("can't open file");
    fwrite($f, '<?php define("BOOTSTRAP_THEME","' . htmlspecialchars($_POST['theme_val']) . '");');
    fclose($f);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Interactive Decision Tree - Admin</title>
<link href="../public/css/editor.css" rel="stylesheet" type="text/css" />
<link href="../public/bower_components/bootstrap/dist/css/<?php echo BOOTSTRAP_THEME; ?>" rel="stylesheet">
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
      <li><a class="active" href="theme_chooser.php">Themes</a></li>
      <li><a href="referral_sources.php">Referral Sources</a></li>
      <li><a href="reports.php">Reports</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
<div class="container">
<h1>Themes</h1>
<p class="lead">Please select a theme.</p>
<select id="themeChooser">
<?php

if ($handle = opendir('../public/bower_components/bootstrap/dist/css')) {

    while (false !== ($entry = readdir($handle))) {
        $theme_parts = explode('.', $entry);
        $theme_name = ucFirst($theme_parts[0]);
        if ($entry === BOOTSTRAP_THEME){
            echo "<option value='$entry' selected=selected>$theme_name</option>";
        } else {
            echo "<option value='$entry'>$theme_name</option>";
        }
    }

    closedir($handle);
}
?>
</select>
</div>
<script type="text/javascript" src="../public/js/jquery.min.js"></script>
<script type="text/javascript" src="../public/js/editor.js"></script>
<script type="text/javascript" src="../public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../public/bower_components/bootstrap/js/tooltip.js"></script>
<script type="text/javascript" src="../public/bower_components/bootstrap/js/popover.js"></script>
</body>
<html>
