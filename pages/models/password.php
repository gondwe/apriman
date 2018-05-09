

<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<?php require ("../../top/functions.php"); ?>
<div class="page-header">
<?php $t = $_GET["p"];?>
<h1> <?=ucfirst($t)?> <small>add New</small></h1>
</div>
</div>
</div>
<?=linkbutton( "sprofile", "", "My Profile")?>

<?php


?>

<form id='savepass' role='form' class='form-horizontal' method="post" action='changepass.php'>
<div class='form-group'>
<label class='col-sm-2 control-label'>Current Password</label>
<div class='col-sm-9'>
<input id='form-field-11' type='password' required class='form-control' name='cp' >
</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>New Password</label>
<div class='col-sm-9'>
<input id='form-field-11' type='password' required class='form-control' name='np' >
</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>Repeat Password</label>
<div class='col-sm-9'>
<input id='form-field-11' type='password'  required class='form-control' name='npw' >
</div>
</div>


<div class='form-group'>
<label class='col-sm-2 control-label'></label>
<div class='col-sm-9'>
<input type='submit' id='submitbtn' class='col-sm-2 btn btn-primary pull-right' value='SAVE' >
</div>
</div>

</form>