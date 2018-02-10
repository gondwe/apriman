
<?php require_once ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php 

$t = $_GET["p"];
$_SESSION[$ndk]["route"] = $route = "maps";

?>
<h1> <?=rx($t)?> <small>Worker file</small></h1>

</div>
</div>
</div>

<?php

error_reporting(-1);

function newhttpauth(){
	
// getkey();
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
} else {
    echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
    echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
}


}

$dp = fetch("select vdat  from vdata where vprop = 'appmode' and xdat = '$sid'");

?>

<form action="devops" method="post">
<div class="option-group">
	<label class="btn btn-secondary">
	<input type="radio" name="dev" class="m-3" id="option1" value="1" <?=$dp=='d'? 'checked' : null?> >Development</input>
	</label>
	<label class="btn btn-secondary">
	<input type="radio" name="dev" class="m-3" id="option2" value="0"  <?=$dp=='p'? 'checked' : null?> >Production</input>
	</label>
	<input type="submit" value="RELOAD">
</div>
</form>

<?php







function orderid(){
$sql = "";
$max = fetch("select max(id) from finance_payments");
for($x = $max; $x > 427; $x--){
	$new = $x+1;
	$sql .= "update finance_payments set id = '$new' where id ='$x';";
}
db()->multi_query($sql);
}

function setnullpayments(){
	$sql = "select id, ( ";
	foreach(getvoteheads() as $k=>$vv){ $v[$k] = fetch("select repdot2('$vv') as v");}
	$sql .= " ifnull( ".implode(", 0 ) + ifnull( ", $v).",0 )) as tot from finance_payments group by id";
	// $data = process($sql);
	spill($sql);
}




function gettxid(){
	/* get txid */
	$sql = "";
	$f2 = getlist("select id, substr(txid,9) as tc from obb.payments");
	foreach($f2 as $id=>$txid) { $sql .= "update obb.payments set txid = '$txid' where id = '$id';"; }
	db()->multi_query($sql);
	spill(explode(";",$sql)); 	
}
	
function transferpayments(){
	/* transfer payments */
	$sql = "";
	foreach(getvoteheads() as $k=>$vv){ $v[$k] = fetch("select repdot2('$vv') as v");}
	$s = "";
	$s .= "insert into cliposts.finance_payments ( adm_no, term, date, amount, bkid, scode, class, pmode, bnk, bnkc, ";
	$s .= implode(", ",$v);
	$s .= " ) ";

	$s .= "( select payments.stud_id, payments.term, payments.date, payments.paid, payments.txid, 4, students.stud_class, 28, 32, 0,  ";
	$s .= implode(", ",$v);
	$s .= " from obb.payments left join obb.students on obb.students.adm_no = obb.payments.stud_id";
	$s .= " )";
	process($s);
	spill($s);
}

function setnulls($sql = ""){
	/* set null voteheads */
	foreach(getvoteheads() as $k=>$vv){ $v[$k] = fetch("select repdot2('$vv') as v");}
	foreach($v as $vv){
		$sql .= "update finance_payments set `$vv` = NULL where `$vv` = 0 ;";
	}
	db()->multi_query($sql);
}





function play(){
	
function ucase($var){
	$a = strtoupper($var) ;
	return $a;
}

$a = ["aBout","Me"];
$a = array_map("strtolower",$a);
spill($a);

spill(range(1,5));

$an_array = array(
     'item1' => 0,
     'item2' => 0,
     'item3' => 0,
     'item4' => 0,
     'item5' => 0,
 );

$items_to_modify = array('item1', "item3");

  array_map(function ($value) use (&$an_array ) {
      $an_array [$value] = "new".$an_array [$value];   //example operation:
  }, $items_to_modify);
  
  spill($an_array);
  
}