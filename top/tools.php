<?php

?>
		<!-- start: HEADER -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<!-- start: TOP NAVIGATION CONTAINER -->
			<div class="container">
				<div class="navbar-header">
					<!-- start: RESPONSIVE MENU TOGGLER -->
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="clip-list-2"></span>
					</button>
					<!-- end: RESPONSIVE MENU TOGGLER -->
					<!-- start: LOGO -->
					<a class="navbar-brand" href="#index">
						<?=abbr(fetch("select name from settings where id = '$sid'"))?>
					</a>
					<!-- end: LOGO -->
				</div>
				<div id='memos' class='col-sm-6' style="padding-top:15px;font-size:15px;color:cyan;padding-left:10px;"><?php if(isset($_SESSION[$ndk]["welcome"])) { success($_SESSION[$ndk]["welcome"]); unset($_SESSION[$ndk]["welcome"]); }?></div>
				<div class="navbar-tools">
					<!-- start: TOP NAVIGATION MENU -->
					



					<ul class="nav navbar-right">
						<!-- start: TO-DO DROPDOWN -->
						<?php // include("todolist.php") ?>
						<!-- end: TO-DO DROPDOWN-->
						<!-- start: NOTIFICATION DROPDOWN -->
						<?php // include("notifications.php") ?>
						<!-- end: NOTIFICATION DROPDOWN -->
						<!-- start: MESSAGE DROPDOWN -->
						<?php // include("messages.php") ?>
						<!-- end: MESSAGE DROPDOWN -->
						<!-- start: USER DROPDOWN -->
						<?php  include("siteusers.php") ?>
						<!-- end: TOP NAVIGATION MENU -->
				
				</div>
			</div>
			<!-- end: TOP NAVIGATION CONTAINER -->
			</div>
		<!-- end: HEADER -->