<?php 
require('_CONFIG.php');
require('_THEME.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="public/bower_components/bootstrap/dist/css/<?php echo BOOTSTRAP_THEME; ?>" rel="stylesheet">
    <link href="public/css/decisionTree.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div  class="container">
        <h1 class="app-title"></h1>
        <div id="tree-window" class="container">
            <div id="tree-slider" class="well">

            </div>
        </div>
        <div class="reset-container">
            <button id="tree-reset" type="button" class="btn btn-primary btn-sm"></button>
        </div>
    </div>    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
     <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="public/js/jquery.easing.1.3.js"></script>
    <script src="public/js/jquery.scrollTo-1.3.3-min.js"></script>
    <script src="public/js/decisionTree.js"></script>
    <script src="public/bower_components/jquery.cookie/jquery.cookie.js"></script>
    <script  src="public/bower_components/bootstrap/js/tooltip.js"></script>
  </body>
</html>
