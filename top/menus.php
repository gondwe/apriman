<div class="navbar-content">
				<!-- start: SIDEBAR -->
				<div class="main-navigation navbar-collapse collapse" style='position:fixed'>
					<!-- start: MAIN MENU TOGGLER BUTTON -->
					<div class="navigation-toggler">
						<i class="clip-chevron-left"></i>
						<i class="clip-chevron-right"></i>
					</div>
					<!-- end: MAIN MENU TOGGLER BUTTON -->
					<!-- start: MAIN NAVIGATION MENU -->
					<ul class="main-navigation-menu sidebar" id='menuitems'>
						<li class="active open">
							<a href='#index'><i class="clip-home-3"></i>
								<span class="title"> Dashboard </span><span class="selected"></span>
							</a>
						</li>
						<?php 
						
						
						if(is_admin()){
							/* add additional menus for admin */
							$menus["admin"] = $menus["admin"] + getlist("select id, names from menunames where names = 'access_control'");
							
						}
												
						$badges = [];
						$icons = [
							"students"=>"users-3",
							"admin"=>"settings",
							"stores"=>"truck",
							"finance"=>"banknote",
							"school"=>"home-2",
							"voting"=>"balance",
							"library"=>"book",
							"exams"=>"file-plus",
						];
						
						
						$uripath = $_SERVER["REQUEST_URI"];
						$uri_segments =  explode("#", $uripath);
						$segment = isset($_SESSION[$ndk]["GET"]["t"])?$_SESSION[$ndk]["GET"]["t"]:null;
						
						
						
						
						foreach($menus as $g=>$more){
							
							// if(!is_array($more)) die("Add Menu Groups");

							if(is_array($more)){
							$cl = in_array($segment,$more) ? 'open' : null;
							$disp = in_array($segment,$more) ? 'block' : "none";
							echo "<li class=".$cl." id='mengroup' > ";
								?>
								<a href="javascript:void(0)"><i class="clip-<?=isset($icons[$g])? $icons[$g] : 'puzzle-4'?>"></i>
									<span class="title"> <?=rx($g)?> </span><i class="icon-arrow"></i>
									<span class="selected"></span>
								</a>
								<ul class="sub-menu" style="display:<?=$disp?>">
								<?php
								foreach($more as $m){
									?>
										<li  id='sub_<?=$m?>'>
											<a href='#new/<?=$m?>' >
												<span class="title"><?=rx(mx($m))?></span>
												<span class="badge badge-new"><?=isset($badges[$m])? $badges[$m] : null?></span>
											</a>
										</li>
								<?php } ?>
									</ul>
								<?php
							}else{
								?>
							<li class="title">
								<a href='#<?=$more?>'><i class="clip-<?=isset($icons[$more])? $icons[$more] : "puzzle-3"?>"></i>
									<span class="title"> <?=rx($more)?> </span><span class="selected"></span>
								</a>
							</li>
								<?php
							}
							echo "</li>";
						}
						?>
						<li>
							<a href='#maps'><i class="clip-location"></i>
								<span class="title">Maps</span>
								<span class="selected"></span>
							</a>
						</li>
						</ul>
						
							
					<!-- end: MAIN NAVIGATION MENU -->
				</div>
				<!-- end: SIDEBAR -->
			</div>	


<?php 

?>			

<script>
	function urihash(){
		$.post("pages/xhr/uripath.php", function(data){
			console.log( data);
		})
	}
</script>