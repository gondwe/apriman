<?php require("top/head.php"); ?>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body>

		<?php require("top/tools.php"); ?>
				
		
		<!-- start: MAIN CONTAINER -->
		<div class="main-container">
		<?php require("top/menus.php"); ?>
		
		<!-- start: PAGE -->
		<div class="main-content">
		<div class="container">
		<!-- start: PAGE HEADER -->
		<div class="row">
		<div class="col-sm-12" >
		<!-- start: STYLE SELECTOR BOX -->
		<!-- end: STYLE SELECTOR BOX -->

		<!-- start: PAGE TITLE & BREADCRUMB -->
		<?php include("top/searchbar.php") ?>
		<div id="pagecontent">
		<div id='loader'><center><div class="loading" src="">Loading.. Please Wait !</div></center></div>
		</div>
		
		</div>
		</div>
		</div>
			<!-- end: PAGE -->
		
		<!-- end: MAIN CONTAINER -->
		
		<!-- start: FOOTER -->
		<?php require("top/foot.php"); ?>
		<!-- end: FOOTER -->
		
		
		<!-- start: RIGHT SIDEBAR -->
		<?php //require("top/rightside.php"); ?>
		<!-- end: RIGHT SIDEBAR -->
		
		
		<?php //require("top/eventsman.php"); ?>
		<?php require("top/jscripts.php"); ?>
		
		

	</body>
	<!-- end: BODY -->
</html>