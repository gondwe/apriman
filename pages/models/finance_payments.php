
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->

<style>
.alert {background:none; border-right:none; border-left:none}
span#red.tag {background:#fbd221;}
span#green.tag {background: #cde69c;}
span.tag {border: 1px solid #a5d24a;-moz-border-radius: 2px;-webkit-border-radius: 2px;display: block;float: left;padding: 5px;text-decoration: none;color: #638421;margin-right: 5px;margin-bottom: 5px;font-family: helvetica;font-size: 13px;}
span.tag a {font-weight: bold;color: #82ad2b;text-decoration: none;font-size: 11px;}
#ta {text-align:right}
#te {text-align:center}
.t {font-weight:bold}
#tb #ta{color:green}
#tc #ta{color:red}
.circle {-moz-border-radius: 2px;-webkit-border-radius: 2px;display: block;float: left;padding: 5px;text-decoration: none;margin-right: 5px;font-family: helvetica;font-size: 13px;    margin-top: 5px;padding-bottom: 2px; background-color:#ddd}
#g.circle {border-bottom: 2px solid greenyellow;}
#r.circle {border-bottom: 2px solid red;}
#finance_payment {margin-top: 80px;}
#finance_payment #submitbtn { float: right;}

</style>




<div class="page-header">
<?php 
$t = $_GET["t"] = 'finance_payments';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);

$dv = isset($_SESSION[$ndk]['adm_search']) ? $_SESSION[$ndk]['adm_search'] : null;
if(is_string($dv)){
	$class = fetch("select classes.names from students left join classes on classes.id = students.class where adm_no = '$dv' and sid = '$sid'");
	$stream = fetch("select streams.names from students left join streams on streams.id = students.stream where adm_no = '$dv' and sid = '$sid'");
}
 ?>
<h1> <?=rx(mx($t))?> <span style='font-size:24	px'><?php info( $dv==null? 'new' : (fetch("select names from students where adm_no = '$dv' and sid = '$sid'")." | ".rx($class)." ".rx($stream)),2)?></span></h1>
</div>
</div>
</div>

<?php




include_once("nav.php");

if($dv !== null){
echo "<div class='col-sm-12' style='padding-top:10px;border-top:1px solid grey;border-bottom:1px solid grey' >";
echo "<div class='col-sm-5 pull-right' >";
echo "<a  href='#finance_feeclass' class='btn btn-squared btn-primary pull-right' style='margin-left:5px'>FeeClass</a>";
echo "<a  onclick='promoteme(1)' class='btn btn-squared btn-success pull-right' style='margin-left:5px'>Promote</a>";
echo "<a  onclick='promoteme(2)' class='btn btn-squared btn-success pull-right'>Demote</a>";
//form_cbo_("fee_class",namelist("finance_feeclasses"),fetch("select feeclass from finance_fdata where adm_no='$dv' and scode = '$sid' and fyear = '$cyr'"));
echo "</div>";
}
// spill($_SERVER);
echo "<div class='col-sm-7' >";
form_open_("finance_admsearch","adm_no","text",$dv,"SEARCH");
echo "</div>";
echo "</div>";
if(isset($_SESSION[$ndk]["xstudent"]["adm_search"])){error($_SESSION[$ndk]["xstudent"][$_SESSION[$ndk]["adm_search"]]);}

if($dv !== null){
	include_once("studentclass.php");
	$p = new fee($dv);
	$class = $p->classs;
	$v = $p->voteheadslist(); $x = $p->tvme();$pt = $p->terms;$p->balance();$paid = $p->ypay;$bal = $p->ydebt;
	
	echo "<div class='col-md-4'>";
	form_open("finance_payment");
	form_input("amount");
	form_cbo_("mode",getlist("select id, vdat from vdata where vprop ='paymodes' and xdat = '$sid'"),fetch("select id, vdat from vdata where vprop ='paymodes' and xdat = '$sid' and vdat = 'bank'"));
	form_cbo_("bank",getlist("select id, names from finance_banks where scode = '$sid'"));
	form_input("bank_charges");
	form_close(1,"PAY");
	form_open("finance_recs");
	// form_button( "RECEIPTS", 1,"receipts");
	// echo "<div class='col-md-12 pull-right' >";
	// linkbutton( "new", "receipts", "RECEIPTS ");
	// echo "</div>";
	// echo "<div class='col-md-12 pull-right' >";
	// linkbutton( "new", "finance_arrears", "ARREARS ");
	// echo "</div>";
	
	
	$paybk = getlist("select distinct bkid from finance_payments where adm_no = '$dv' and scode = '$sid' and year(date) = year(current_timestamp)");
	echo "<div class='row'><hr>";
	$pk = array();
	foreach($paybk as $p=>$k){
		$pk[$k] = getlist("select id, amount from finance_payments where bkid = '$k' and adm_no = '$dv' and scode = '$sid' and class = '$class'  and year(date) = year(current_timestamp)");
		if(empty($pk[$k])) unset($pk[$k]);
	}

	foreach($pk as $pp=>$paydays){
		$col = count($paydays)>1? (array_sum($paydays)>0? 'g' : 'r') : "";
		echo "<span  class='circle' >";
			foreach($paydays as $bk=>$p){
				$color = $p > 0 ? "green" : "red";
				$link = '#new/receipts';
				?><span  onclick="fredir_receipt('<?=$pp?>','<?=$link?>')" class="tag" id="<?=$color?>"><?=addcommas($p,0)?>&nbsp;&nbsp;</span><?php
			}
		?><a href="javascript:void(0)" onclick="rollback('<?=$pp?>')" title="cancel payment">x</a><?php
		echo "</span>";
	}
	
	echo "</div>";
	form_close(0,"PAY");
	echo "</div>";
	echo "<div class='col-md-8'>";
	


	
	
	
	/* table showing payments */include_once("finance_ptable.php");echo "</div>";
	
	$_SESSION[$ndk]['bkdownid'] = fetch("select max(bkid) from finance_payments where adm_no = '$dv' and scode = '$sid'");
}


?>
<script>
	function promoteme(opt){
		$.post("pages/xhr/promoteme.php", {"opt":opt,});
		window.location.reload("true");
	}
</script>