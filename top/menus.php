<div class="navbar-content">
				<!-- start: SIDEBAR -->
				<div class="main-navigation navbar-collapse collapse">
					<!-- start: MAIN MENU TOGGLER BUTTON -->
					<div class="navigation-toggler">
						<i class="clip-chevron-left"></i>
						<i class="clip-chevron-right"></i>
					</div>
					<!-- end: MAIN MENU TOGGLER BUTTON -->
					<!-- start: MAIN NAVIGATION MENU -->
					<ul class="main-navigation-menu">
						<li class="active open">
							<a href='#index'><i class="clip-home-3"></i>
								<span class="title"> Dashboard </span><span class="selected"></span>
							</a>
						</li>
						<?php 
						

												
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
						
						
						
						
						
						
						
						foreach($menus as $g=>$more){
							echo "<li>";
							if(is_array($more)){
								?>
								<a href="javascript:void(0)"><i class="clip-<?=isset($icons[$g])? $icons[$g] : 'puzzle-4'?>"></i>
									<span class="title"> <?=rx($g)?> </span><i class="icon-arrow"></i>
									<span class="selected"></span>
								</a>
								<ul class="sub-menu">
								<?php
								foreach($more as $m){
									?>
										<li>
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