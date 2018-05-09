
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<div class="page-header">
<?php $_SESSION[$ndk]["route"] = $route = $_GET['t']; $t = $_GET["t"] = 'vote_elections'; ?>
<h1> <?=rx(mx($t))?> <small>new</small></h1>
</div>
</div>
</div>

<?php

echo "<div id='me'>";
$found = 0;
if(isset($_SESSION[$ndk]["me"])){
$myself = fetch("select names from students where adm_no = '".$_SESSION[$ndk]["me"]."' and sid ='$sid'");
$found = $myself == "" ? $found : 1;

?>
			
<div class='col-sm-12'><h3 class='pull-right'>Welcome <?=$myself?></h3></div><div>
<h5 class='pull-right' ><a style='color:red' href='javascript:void(0)' onclick='vout("v")'>Sign Out</a></h5></div>
<hr>

<?php } ?>

<div class='col-sm-12'>
<div id='list' class='col-sm-4'>

<?php
if($found > 0){

$posts = getlist("select id, post_title from vote_posts where sid ='$sid'");
$votes = getlist("select p_id from vote_elections where v_id = '".$_SESSION[$ndk]["me"]."' and  p_id in (select id from vote_posts where sid = '$sid')");

echo "<ol>";
$_SESSION[$ndk]["dat"] = current(array_keys($posts));
foreach($posts as $p=>$k){
	$color = in_array($p, $votes)? "color:red" : "color:green"; ?>
	<li ><a href='javascript:void(0)' class='btn btn-default btn-squared' style='<?=$color?>' onclick='vloadcandidate("<?=$p?>")'><?=$k?></a></li>
	<?php
}

?>

<ol></div><div id='candidates'  class='col-sm-8'></div>


<?php }else { ?>

<form name='log' method='post' id='v' >
<input type='text' name='me' placeholder="Reg No">
<a href='javascript:void(0)' class='btn btn-success' onclick="vcheck('v')" >Login</a>
</form>

</div>


<?php 
}

?>

<script>
function vsavecan(f){ajpost(f, "pages/xhr/vote_savecandidate.php");}	
vloadcandidate("<?=$_SESSION[$ndk]["dat"]?>");
</script>