
<li class="dropdown current-user">
							<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
								<!--<img style='max-width:30px;max-height:30px' src="<?php //getimage("users/".$_SESSION[$ndk]["user"]["imagelocation"]) ?>" class="circle-img" alt="">-->
								<span class="username"><?=rx($_SESSION[$ndk]["user"]["username"])?></span>
								<i class="clip-chevron-down"></i>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="#sprofile">
										<i class="clip-user-2"></i>
										&nbsp;My Profile
									</a>
								</li>
								<!--<li>
									<a href="#">
										<i class="clip-calendar"></i>
										&nbsp;My Calendar
									</a>
								<li>
									<a href="#">
										<i class="clip-bubble-4"></i>
										&nbsp;My Messages (3)
									</a>
								</li>
								<li class="#"></li>
								<li>
									<a href="utility_lock_screen.php"><i class="clip-locked"></i>
										&nbsp;Lock Screen </a>
								</li>-->
								<li>
									<a href="#logout/index">
										<i class="clip-exit"></i>
										&nbsp;Log Out
									</a>
								</li>
							</ul>
						</li>
						<!-- end: USER DROPDOWN -->
						<!-- start: PAGE SIDEBAR TOGGLE
						<li>
							<a class="sb-toggle" href="#"><i class="fa fa-outdent"></i></a>
						</li> -->
						<!-- end: PAGE SIDEBAR TOGGLE -->
					</ul>
					<?php //spill($user)?>
					