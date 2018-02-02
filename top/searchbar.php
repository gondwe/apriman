							<ol class="breadcrumb">
										<span id='notice' class='col-sm-5'></span>
										<span id='notice2' class='col-md-6'></span>
								
								<li>
									<div id='redlight'></div>
								</li>
								<li class="search-box">
									<form class="sidebar-search">
										<div class="form-group">
											<input type="text" placeholder="Start Searching...">
											<button class="submit">
												<i class="clip-search-3"></i>
											</button>
										</div>
									</form>
								</li>
							</ol>
							
							<style>
								#notice { color:red; font-weight:bold; }
								#notice2 { color:red; font-weight:bold; }
							</style>
							
							<?php 
							
	
function countdown($d){ ?><script>document.getElementById("redlight").innerHTML = '<div id="pulsate-regular" onclick="actify()">Activate : <?=$d?> left'</script><?php }
function boot_strap(){ global $sid, $ndk; $name = fetch("select name from settings where id = '$sid'"); $cname = fetch("select lcase(vdat) from vdata where vprop = 'keyfile' and xdat = '$sid'"); $hash = array_chunk(str_split(md5($name.date("Y")),4),3)[1]; $hash = implode("-",$hash); if($cname !== $hash){ if(($period = grace_period()) < 1 ){ $_SESSION[$ndk]["dirty"] = true; }else{ countdown($period); } } } 
function grace_period(){ $d1 = new DateTime(date("Y").'-3-1');$d2 = new DateTime('now');$interval = $d2->diff($d1);return $interval->format('%R%a days'); }
	?>