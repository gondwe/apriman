<?php 
include("../../top/functions.php");


$users = getlist("select ucase(username) from users");

?>

		
		
		<?php foreach($users as $u) { ?>
		<div class='form-group'>
		<label class='col-sm-2 control-label'></label>
		<div class='col-sm-3'><input class='form-control' value='<?=$u?>'></div>

		
		<div id="change-color-switch" class="make-switch switch-large has-switch" data-on="default" data-off="primary">
										<div class="switch-off switch-animate"><input checked="" type="checkbox"><span class="switch-left switch-large switch-default">ON</span><label class="switch-large">&nbsp;</label><span class="switch-right switch-large switch-primary">OFF</span></div>
									</div>
		</div>

		
		<?php } ?>
		<div class="form-group">
		<div class='col-sm-8'></div>
		<a href='javascript:void(0)' id='submitbtn' class='col-sm-2 btn btn-primary' type='submit' onclick='proc("mods")'>Go!</a>
		</div>


