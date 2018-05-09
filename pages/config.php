
<?php require ("../top/functions.php"); ?>
<div class="page-header">
<?php $t = $_GET['t'];?>
<h1> Config <small>admin only</small></h1>
</div>
</div>
</div>

<?php

inmenu(["new/menusubgroups","new/menugroups","new/menunames"]);



?>




		
<form method='post' action='' class='form-horizontal' role='form' id='conf'>
<!--fix user allocations-->
<div class='form-group'>
	<label class='col-sm-2 control-label'>USR ALLOC</label>
	<div class='col-sm-6'>
		<select  id='form-field-select-1' class='form-control' name='tcodes'>
			<option value='1'>Permissions Entries</option>
			<option value='2'>Modulation</option>
		</select>
	</div>
	<a href='javascript:void(0)' id='submitbtn' class='col-sm-2 btn btn-primary' type='submit' onclick='proc("conf")'>Go!</a>
</div>
</form>


<form method='post' action='' class='form-horizontal' role='form' id='mods'>
<!--assign modules-->
<div class='form-group'>
	<label class='col-sm-2 control-label'>MODULES</label>
	<div class='col-sm-3'>
		<select  id='form-field-select-1' class='form-control' name='tcodes' onchange='mod("mods")'>
			<?php foreach($mods as $m): ?><option value='<?=$m?>'><?=rx($m)?></option><?php endforeach ?>
		</select>
	</div>
	
	</div>
	</div>
	<div id='modcontent' ><script>mod()</script></div>


</form>






