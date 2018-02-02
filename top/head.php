<?php 

?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<title>ndk :: 2.21</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="nardtec ims" name="description" />
		<meta content="gondwe" name="author" />

		<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/fonts/style.css">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/main-responsive.css">
		<link rel="stylesheet" href="assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
		<link rel="stylesheet" href="assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="assets/css/theme_navy.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="assets/css/print.css" type="text/css" media="print"/>
		
		<link rel="stylesheet" href="assets/plugins/ladda-bootstrap/dist/ladda-themeless.min.css">
		<link rel="stylesheet" href="assets/plugins/bootstrap-switch/static/stylesheets/bootstrap-switch.css">
		<link rel="stylesheet" href="assets/plugins/bootstrap-social-buttons/social-buttons-3.css">
		<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2.css" />
		<link rel="stylesheet" href="assets/plugins/DataTables/media/css/DT_bootstrap.css" />
		

		<link rel="stylesheet" href="assets/plugins/fullcalendar/fullcalendar/fullcalendar.css">
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
<?php 
require("functions.php");

if(!isset($_SESSION[$ndk]["user"]) && ($_GET["p"]!== "ways")){ header("location:start.php");}else{
	$user = $_SESSION[$ndk]["user"];
}