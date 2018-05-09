
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<style> #smx {color:maroon;font-size:18px } #sml {font-size:17px } #mony {}</style>
<div class="page-header">
<?php $t = $_GET["t"] = 'finance_stats';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
?>
<h1> <?=rx(mx($t))?> <small>new</small></h1>
</div>
</div>
</div>


<?php 
include ("nav.php");

$form = "Y-m-d";
$null = fetch("select date(current_timestamp)");
$dfrom = isset($_SESSION[$ndk]["post"]["datefrom"])?$_SESSION[$ndk]["post"]["datefrom"] : $null;
$dto = isset($_SESSION[$ndk]["post"]["dateto"])?$_SESSION[$ndk]["post"]["dateto"] : $null;

last_payment();
?>


<form  role='form' action="finance_range.php" method="post"><div class="col-sm-3"><input value="<?=$dfrom?>" required class="form-control " type="date" placeholder="Date From" name="datefrom"></div><div class="col-sm-3"><input value="<?=$dto?>" required class="form-control " type="date" placeholder="Date To" name="dateto"></div><input type="submit" class="btn btn-primary" value="SEARCH" ></form>


<?php 
 

if(is_string($dfrom)){

	$df = date($form, strtotime($dfrom));$dt = date($form, strtotime($dto));
	
	$sql = "select fp.id, fp.id as sno, date_format(fp.date, '%D %M') as date_, st.adm_no, st.names,  cl.names as class, str.abbr as str, (SELECT CASE WHEN fp.amount < 1 THEN 'CANCELLED' ELSE fp.amount END) as amount, time(fp.date) as time_ 		from finance_payments as fp 		left join students as st on fp.adm_no = st.adm_no and st.sid = '$sid' inner join classes as cl on cl.id = st.class inner join streams as str on str.id = st.stream where date(fp.date) >= '$df' and date(fp.date) <= '$dt' group by fp.id";
	$sql2 = get("select fp.id, fp.amount, date_format(fp.date, '%D %M') as date_, st.adm_no, st.names,  cl.names as class, str.abbr as str,fp.arrid from finance_payments as fp  left join students as st on fp.adm_no = st.adm_no and st.sid = '$sid' inner join classes as cl on cl.id = st.class inner join streams as str on str.id = st.stream where date(fp.date) >= '$df' and date(fp.date) <= '$dt' group by fp.id");
	
	// spill($sql2);
	$morecolsdata = [];
	foreach($sql2 as $k=>$v){ $arrears = is_null($v["arrid"]) ? "Completed" : "Arrears"; $morecolsdata[$v["id"]] = ($v["amount"] < 1 ) ? "Cancelled"  : $arrears; } 
	$range = get($sql);
	// spill($range);
	
	info("<h5><span id=''>".fetch("select date_format('$df','%D%M %Y')")." --- ".fetch("select date_format('$dt','%D%M %Y')")." </span>
			<span id=''><b> KES : </b>".addcommas(array_sum(array_column($range,"amount")))."</span></h5>");

	include ("../top/tablo.php");
	$d = new tablo("finance_payments");
	$d->query = $sql;
	$d->addnew = false;
	$d->deleteset = false;
	$d->morecols[] = "status";
	$d->morecolsdata["status"] = $morecolsdata;
	$d->editset = false;
	$d->dtable();

}
