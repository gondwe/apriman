
<!-- @author:gondwe 28th Sept 2017 -->
<div class="page-header">
<?php $_SESSION[$ndk]["route"] = $route = $t = $_GET["t"] = 'receipts'; 
include("finance_rcstyles.php");$dv = isset($_SESSION[$ndk]['adm_search']) ? $_SESSION[$ndk]['adm_search'] : null;
if(is_string($dv)){$class = fetch("select abbr from students as s left join classes as c on c.id = s.class where adm_no = '$dv' and s.sid = '$sid'");
$stream = fetch("select abbr from students left join streams on streams.id = students.stream where adm_no = '$dv'");}?>
<h1> <?=rx("Print ".$t)?> <small><small><?=$dv==null? 'Search by RegNo & Date' : (fetch("select names from students where adm_no = '$dv'  and sid = '$sid'")." | ".$class." ".$stream)?></small></small></h1></div></div></div><?php if(is_string($dv)){$px = fetch("select count(id) from finance_payments where adm_no= '$dv' and scode = '$sid'");
if(!($px)){error(fetch("select names from students where adm_no = '$dv' and sid = '$sid'")." HAS NOT MADE ANY PAYMENTS IN THE INSTITUTION !");}}include("nav.php"); form_open_("search_receipt","receipt no","text", "", "search");

if(is_string($dv)){

/* lets begin *//* assume the most recent payment as a fallback */
$instdata = getlist("select * from settings where id = '$sid'");
$lbkid = isset($_SESSION[$ndk]['bkdownid']) ? $_SESSION[$ndk]['bkdownid'] : fetch("select max(bkid) from finance_payments where adm_no = '$dv' and scode = '$sid'");
$rdata = get("select * from finance_payments where bkid = '$lbkid' and adm_no = '$dv' ");
$person = getlist("select s.names, s.class, st.abbr as stream, cl.abbr as class from students as s left join streams as st on st.id = s.stream left join classes as cl on cl.id = s.class where s.adm_no = '$dv' and s.sid = '$sid'");
$tx = getlist("select id, vdat from vdata where vprop = 'terms'");include("studentclass.php");$p = new fee($dv);$vh = $p->voteheadslist();foreach($tx as $t=>$x){$balances[$t] = $p->balance($t);}$balance_stream = $p->bal_stream();$vb = $p->ydebt;$bals = $balance_stream["b"]; $arrs = $balance_stream["r"];$rec = "";

foreach($rdata as $k=>$rd){
$html = "";$rr = $rd["id"]; $rid = "rec".$rr;if($rd["amount"]=='0'){echo '<style>#'.$rid.'{background-image: url("assets/images/cancelled.png");background-repeat: no-repeat;background-position: center;}</style>';}$rcno = $rd["rcno"] == null ? null : $rd["rcno"];if(is_numeric($rd['arrid'])){$j = new fee($dv);$arr = $j->arrears();}$vbal = isset($bals[$rd['term']][$rd['id']]) ? $bals[$rd['term']][$rd['id']] : $vb[$rd["term"]];$dummy = 13 - count($vh);

$rec .= "<div class='text-center'><a href='javascript:printme($rr);' class='btn btn-success hidden-print' alt='print this page' id='print-button'>Print</a></div>";
$rec .=  "<div id='".$rid."' class='receipt'>";
$rec .=  "<table id='rchead' class='' ><tr>";
$rec .=  "<td id='' class=''><img width='150px' src='".getimage("settings/".($instdata["logo"]))."' ></td>";
$rec .=  "<td class='rcnames ' >";
$rec .=  "<div id='name'>".rx($instdata["name"])."</div>";
$rec .=  "<div id='box'>P.O. Box ".$instdata["pobox"]."-".$instdata["postal_code"].", ".$instdata["location"]."</div>";
$rec .=  "<div id='tel'>Tel : +254 ".$instdata["pnumber"]."</div>";
$rec .=  "<div id='email'>e-mail : ".$instdata["email"]."</div>";
$rec .=  "<div id='official'><b>OFFICIAL RECEIPT</b></div>";
$rec .=  "</td>";
$rec .=  "</tr>";
$rec .=  "</table>";

$rec .=  breakdiv();

$rec .=  "<div id='mid'>";
$rec .=  "<div id='rcperson'>";
$rec .=  "<table class='rcperson'>";
$rec .=  "<tr><td id='rcp1' class=''><b>Receieved from : </b>".$person["names"]."</td><td class=''><b>Date: </b>".date_format(date_create($rd['date']),'d/m/Y')."</td></tr>";
$rec .=  "<tr><td id='rcp2' class=''><b>Reg No : </b>".$dv."<b>  Class : </b>".rx($person['class'])."</td><td class=''><b>Term : </b>".rx($tx[$rd['term']])."</td></tr>";
// $rec .=  "<tr><td id='rcp2' class=''></td><td class=''></td></tr>";
$rec .=  "<tr><td id='rcp3' colspan='2'><b>The Sum of Kshs. </b>".rx(conv( intval($rd['amount'])))." Shillings Only</td></tr>";
// $rec .=  "<tr><td id='rcp1' class=''></td></tr>";
$rec .=  "</table>";
$rec .=  "</div>";

$rec .=  breakdiv();

$rec .=  "<table class='rcbreakdown' width='100%' cellspacing=0 >";
$rec .=  "<thead class='bktitle'>";
$rec .=  "<tr><th id='' class=''>Being Payment of </th><th id='shst' class='moneys'>Shs</th><th id='ctst' class='moneys'>Cts</th></tr>";
$rec .=  "</thead><tbody>".rec_voteheads($rd,$vh).mapengo($dummy,$rd);
$rec .= "<tr id='bkd' class='tots' ><td id='bkd' class=''><span><b>E&0.E No </b>".sprintf("%05d", $rd['id'])."
			</span><span class='sum' style='float: right;padding-right:5px;'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTOTAL : </span></td><td id='shs' class=''>".addcommas($rd['amount'],0)."</td><td id='cts' class=''>00</td></tr>";
$rec .=  "</tbody></table></div>";
$rec .=  "</div>";

$rec .=  "<div class='rcfooter '>";
$rec .=  "<div id='orderno'>".recmods($rd);
$rec .= "<div class='recno ' id='rcno".$rid."' onclick='frecno(".$rd['id'].",this.id)'># ".$rcno."</div><div class=''></div><br>";
$rec .= "</div>";
$rec .= "</div>";


$rec .=  "<table class='balances'><tr><td id='fbal' class='' ><b>Fee Balance : </b>".addcommas($vbal)."</td>";
$rec .=  "<td id='farr' class='' >"; if(is_numeric($rd['arrid'])){ $rec .= "<b>Arrears : </b>".addcommas($arrs[$rd['term']][$rd['id']]);} 
$rec .= "</td></tr>";

$rec .=  "<tr><td id='sby'  class='' ><b>You were served by : </b>".rx($user['names'])."</td>";
$rec .=  "<td id='sign' class='' ><b>Receivers Sign : </b>.................</td></tr>";
$rec .=  "</table>";

$rec .=  "</div>";




}


echo($rec) ;

}


function recmods($id){$rcm = ["ca"=>"cash","ch"=>"cheque","mo"=>"money order","ps"=>"pay-in slip","po"=>"postal order","mp"=>"Mpesa",];
$rc = "&nbsp";foreach($rcm as $k=>$r){$b=null;$bb=null;if($id["rcpmode"] == $r){$b = "<b><u>"; $bb = "</u></b>";}
$rc .= "<span id='".$k."'  onclick='frcpmode(".'"'.$r.'"'.",".$id['id'].")' > ".$b.rx($r).$bb." / </span>";}
return  $rc."</div>";}

function rec_voteheads($rd, $vh){$rec = '';foreach($vh as $v){
	$amt = '--'; $cts = '-';
if(is_null($rd["arrid"])){
if(isset($rd[$v])) $amt = addcommas($rd[$v],0);
if(isset($rd[$v])) $cts = "00"; 
}
$rec .= "<tr id='bkd'><td id='vh' class=''>".rx(repdot($v),1)."</td><td id='shs' class=''>".$amt."</td><td id='cts' class=''>".$cts."</td></td>";}
return $rec;}
function mapengo($dummy,$rd){ 
$arrid = $rd["arrid"]; $rec = '';while($dummy > 1){
$rec .= "<tr id='bkd'><td id='' class=''>--</td><td id='shs' class=''>--</td><td id='cts' class=''>--</td></td>";$dummy--;}
$ARCAN = $rd["amount"] < 1 ? "CANCELLED" : "ARREARS";
$specify = is_null($arrid)? " SPECIFY " : "<strong> $ARCAN </strong>";
$newsh = is_null($arrid)? "--" : addcommas($rd['amount'],0);
$newcts = is_null($arrid)? "--" : "00";
$rec .= "<tr id='bkd'><td id='' class=''>OTHER ($specify)</td><td id='shs' class=''>".$newsh."</td><td id='cts' class=''>".$newcts."</td></tr>";
$rec .= "<tr id='bkd'><td id='' class=''>--</td><td id='shs' class=''>--</td><td id='cts' class=''>--</td></td>";
return $rec;
}

function breakdiv(){return "<div style='float:none;clear:both'>";}

?>
