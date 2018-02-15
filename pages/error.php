<?php 

require ("../top/functions.php");

?>
<div class="col-sm-12 page-error" style='margin-top:3%'>
							<div class="error-number teal">
								404
							</div>
							<div class="error-details col-sm-6 col-sm-offset-3">
								<h3>Oops! <span style='color:red'><?=$_GET["p"]?></span> not found</h3>
								<p>
									Unfortunately the page you were looking for could not be found.
									<br>
									It may be temporarily unavailable, moved or no longer exist.
									<br>
									Check the URL you entered for any mistakes and try again.
									<br>
									<a href="#index" class="btn btn-teal btn-return btn-squared">Back</a>
									<a href="#build/<?=$_GET['p']?>" class="btn btn-green btn-squared">Build</a>
									</p>

							</div>
						</div>
						
						<?php 

						
						?>