<?php 

require('../_CONFIG.php');
require('../_THEME.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Interactive Decision Tree - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="../public/bower_components/bootstrap/dist/css/<?php echo BOOTSTRAP_THEME; ?>" rel="stylesheet">
    <link href="../public/css/decisionTree.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
</body>
<nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">Interactive Decision Tree - Login</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
      <li><a class="active" href="#">Login</a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
<div class="container">
<div class="alert alert-danger login-error"></div>
<form role="form">
  <div class="form-group">
    <label for="idtUser">Username</label>
    <input type="text" name="username" class="form-control" id="idtUser" placeholder="Enter Username">
  </div>
  <div class="form-group">
    <label for="idtPass">Password</label>
    <input type="password" name="password" class="form-control" id="idtPass" placeholder="Password">
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox" name="rememberMe"> Remember Me
    </label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../public/js/login.js"></script>
<script src="../public/bower_components/jquery.cookie/jquery.cookie.js"></script>
</body>
</html>
