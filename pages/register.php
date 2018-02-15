<?php require ("../top/functions.php"); ?>
							
							<div class="page-header">
								<h1>License <small>register/renew </small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
					<div class="row">
					
					<!-- our homepage stuff comes here -->
					
					</div>

		<?php 
		
		$me = $_SESSION[$ndk]["user"]["scode"];
		$instdata = getlist("select * from settings where id = '$me'");
		
		
		?>
		
		
		<style>
			.action { border-right:1px solid red; display:block}
			.action .btn { margin:30px auto; display:block}
			#results .btn { float:right}
			#smx {font-size:20px}
		</style>
		
		<div class='details col-sm-5'>
		<h3><b>Product Registered to : </b></h3>
		<small><h3 id='smx'><?=$instdata["name"]?>
		<br>P.O. Box <?=$instdata["pobox"]?>, <?=$instdata["location"]?>
		<br>Tel : +254 <?=$instdata["pnumber"]?></h3></small>
		</div>
		<div class='action col-sm-2'>
		<a href='javascript:register(0)' class='btn btn-teal'>Renew</a>
		<a href='javascript:register(1)' class='btn btn-primary'>Register</a>
		</div>
		<div id='results' class='col-sm-5'>
		</div>
		
		
		
		<script>
		
		
		function register(id){
			$.ajax(
			{url:"pages/xhr/rearm.php",type:"POST",data:"id="+id}
			).done( function(msg){
				 document.getElementById("results").innerHTML = $.trim(msg);
			});
		}
		
		
		
		</script>
		
		