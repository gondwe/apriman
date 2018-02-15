
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["p"];?>
<h1> <?=rx(mx($t))?> <small>developers - @nardtec </small></h1>
</div>
</div>
</div>

<link rel="stylesheet" href="assets/plugins/select2/select2.css">
<script> 
function appmode(f=0){ ajpost(f, "pages/xhr/appmode.php",1,0); } 
function call_akc(){var p = prompt("Secure Page !","pwd");$.ajax({url:"pages/xhr/apriman.php",data:"p="+p,type:"post"}).done( function (msg){ document.getElementById("memos").innerHTML = $.trim(msg); } ); start(); }
</script> 
<?php 

include("../nav.php");



if(isset($_SESSION[$ndk]["dev"])){
	echo "<h2>Libraries</h2>"	;
	$unlisted = getlist("select menunames.id, menunames.names from unlisted left join menunames on menunames.id = unlisted.names");
	echo "<b>Modules </b>";
	$mods_ = getlist("select menunames.id, vdata.vdat from vdata left join menunames on menunames.names = vdata.vdat where vdata.vprop ='module'");
	foreach($mods_ as $k=>$mod){
		$checked = in_array($mod, $unlisted)? null : "checked";
		?><input onclick='modactivate(<?=$k?>);' type='checkbox' <?=$checked?>  ><?=$mod?></input><?php
	}
	$appmode = fetch("select vdat from vdata where xdat = '$sid' and vprop = 'appmode'");
	$pchecked = $appmode == 'p' ? "checked" : null;
	$dchecked = $appmode == 'd' ? "checked" : null;
	echo '<br><b>Application Mode</b>
		<label class="radio-inline">
			<input type="radio" value="" '.$dchecked.' onchange=appmode() name="optionsRadios" class="grey">
			Development
		</label>
		<label class="radio-inline">
			<input type="radio" value="" '.$pchecked.' onchange=appmode() name="optionsRadios" class="grey">
			Production
		</label>';
	
	
	
	
	echo "<h2>Schema Diff</h2>"	;
	form_open_("schema_compare","db_name");
	if(isset($_SESSION[$ndk]["diff"])){
		
		$db = $_SESSION[$ndk]["diff"];
		
		
		$tables_ = getlist("show tables in `$db`");
		if(!empty($tables_)){
			echo "<h3>Table DIff</h3>";
			$tables = getlist("show tables");
			error("in $db ").spill(array_diff($tables_,$tables));
			error("in Current").spill(array_diff($tables,$tables_));
			
			
			$foundtbls = array_intersect($tables_, $tables);
			echo "<h3>Structure DIff</h3>";
			foreach($foundtbls as $tbl){
				$strx_ = array_column(getlist("describe `$db`.`$tbl`"),"Field");
				$strx = array_column(getlist("describe `$tbl`"),"Field");
				$str_ = array_diff($strx_,$strx);
				$str = array_diff($strx,$strx_);
				 empty($str_) ? null : error($db." ".$tbl).spill($str_);
				 empty($str) ? null : error($tbl).spill($str);
				 
			}
			echo "<h3>Row DIff</h3>";
			foreach($foundtbls as $tbl){
				$strx_ = fetch("select count(*) from $db.$tbl");
				$strx = fetch("select count(*) from $tbl");
				($strx_ > $strx) ? error($db." ".$tbl." == ".$strx_) : null;
				($strx_ < $strx) ? error($tbl." == ".$strx) : null;
			}
				 
			
			
			echo "<h3>Procedure DIffs</h3>";
			// foreach($foundtbls as $tbl){
				$strx_ = array_column(getlist("show procedure status where db ='$db' "),"Name");
				$strx = array_column(getlist("show procedure status where db ='".database."'"),"Name");
				$str_ = array_diff($strx_,$strx);
				$str = array_diff($strx,$strx_);
				 empty($str_) ? error("$db : no difference") : error($db." : ").spill($str_);
				 empty($str) ? error("Current : no difference"): error("Current : ").spill($str);
			// }	 


			echo "<h3>Function DIffs</h3>";
			// foreach($foundtbls as $tbl){
				$strx_ = array_column(getlist("show function status where db ='$db' "),"Name");
				$strx = array_column(getlist("show function status where db ='".database."'"),"Name");
				$str_ = array_diff($strx_,$strx);
				$str = array_diff($strx,$strx_);
				  empty($str_) ? error("$db : no difference") : error($db." : ").spill($str_);
				 empty($str) ? error("Current : no difference") : error("Current : ").spill($str);
				 
			// }	 
			
		}
		
		
	}

	
	
	
	
	
	
}else{ echo "<script>call_akc();</script>"; ?> <?php } ?>
	
