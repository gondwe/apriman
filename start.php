<?php 

	 require("top/functions.php");
	 require("pages/ways.php");

	 if(empty($_POST)) $_SESSION[$ndk]["erc"] = FALSE;
	 if($_SESSION[$ndk]["erc"]) echo "<div class='btn btn-danger text-center col-md-4 col-md-offset-4'>Wrong User/Password.!</div>";

	 

?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Apriman | Home</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap -->
    <link href="assets2/plugins/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Font Awesome -->
  <link href="assets2/plugins/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link href="assets2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- iCheck -->
  <link rel="stylesheet" href="assets2/plugins/iCheck/square/blue.css">
    
  <!-- Custom Theme Style -->
  <link href="assets2/css/AdminLTE.css" rel="stylesheet">			
  <link href="assets2/css/redactor.css" rel="stylesheet" type="text/css" />
  <link href="assets2/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  <link href="assets2/css/custom.css" rel="stylesheet" type="text/css" />
    
  <!-- jQuery 2.0.2 -->
  <script src="assets2/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="assets2/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
  <script src="assets2/plugins/bootstrap/bootstrap.min.js" type="text/javascript"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <span><b>Apriman</b> | Management System</span>
  </div>
  
  <!-- /.login-logo -->
  <div class="login-box-body">
        <p class="login-box-msg">Sign In</p>
    <div id="login-box">
        <form action="" method="post">
          <div class="form-group has-feedback">
			
			<input type="text" name="user" value="" id="identity" class="form-control" placeholder="Email/Username"  />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
			
			<input type="password" name="password" value="" id="password" class="form-control" placeholder="Password"  />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
			  <a href=""></a>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
				
             <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
    </div>

    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- iCheck -->
<
</body>
</html>
     