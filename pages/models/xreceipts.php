
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $_SESSION[$ndk]["route"] = $route = $t = $_GET["t"] = 'receipts'; 
include("finance_rcstyle.php");$dv = isset($_SESSION[$ndk]['adm_search']) ? $_SESSION[$ndk]['adm_search'] : null;if(is_string($dv)){$class = fetch("select abbr from students left join classes on classes.id = students.class where adm_no = '$dv'");$stream = fetch("select abbr from students left join streams on streams.id = students.stream where adm_no = '$dv'");}?><h1> <?=rx("Print ".$t)?> <small><small><?=$dv==null? 'Search by RegNo & Date' : (fetch("select names from students where adm_no = '$dv'")." | ".$class." ".$stream)?></small></small></h1></div></div></div><?php if(is_string($dv)){$px = fetch("select count(id) from finance_payments where adm_no= '$dv'");if(!($px)){error(fetch("select names from students where adm_no = '$dv'")." HAS NOT MADE ANY PAYMENTS IN THE INSTITUTION !");}}include("nav.php"); form_open_("search_receipt","receipt no","text", "", "search");

if(is_string($dv)){

/* lets begin *//* assume the most recent payment as a fallback */
$instdata = getlist("select * from settings where id = '$sid'");$lbkid = isset($_SESSION[$ndk]['bkdownid']) ? $_SESSION[$ndk]['bkdownid'] : fetch("select max(bkid) from finance_payments where adm_no = '$dv'");$rdata = get("select * from finance_payments where bkid = '$lbkid' and adm_no = '$dv' ");$person = getlist("select s.names, s.class, st.abbr as stream, cl.abbr as class from students as s left join streams as st on st.id = s.stream left join classes as cl on cl.id = s.class where s.adm_no = '$dv'");$tx = getlist("select id, vdat from vdata where vprop = 'terms'");include("studentclass.php");$p = new fee($dv);$vh = $p->voteheadslist();foreach($tx as $t=>$x){$balances[$t] = $p->balance($t);}$balance_stream = $p->bal_stream();$vb = $p->ydebt;$bals = $balance_stream["b"]; $arrs = $balance_stream["r"];$rec = "";

foreach($rdata as $k=>$rd){
$html = "";$rr = $rd["id"]; $rid = "rec".$rr;if($rd["amount"]=='0'){echo '<style>#'.$rid.'{background-image: url("assets/images/cancelled.png");background-repeat: no-repeat;background-position: center;}</style>';}$rcno = $rd["rcno"] == null ? null : $rd["rcno"];if(is_numeric($rd['arrid'])){$j = new fee($dv);$arr = $j->arrears();}$vbal = isset($bals[$rd['term']][$rd['id']]) ? $bals[$rd['term']][$rd['id']] : $vb[$rd["term"]];$dummy = 15 - count($vh);

$rec .= "<a href='javascript:printme($rr);' class='btn btn-success col-md-offset-6 hidden-print' alt='print this page' id='print-button'>Print</a>";
$rec .=  "<div id='".$rid."' class='receipt'>";
$rec .=  "<div id='rchead' class='row' >";
$rec .=  "<div id='rclogo' class='col-sm-4'><img src='".getimage("settings/".($instdata["logo"]))."' ></div>";
$rec .=  "<div class='rcnames col-sm-8' >";
$rec .=  "<div id='name'>".rx($instdata["name"])."</div>";
$rec .=  "<div id='box'>P.O. Box ".$instdata["pobox"]."-".$instdata["postal_code"].", ".$instdata["location"]."</div>";
$rec .=  "<div id='tel'>Tel : +254 ".$instdata["pnumber"]."</div>";
$rec .=  "<div id='email'>e-mail".$instdata["email"]."</div>";
$rec .=  "<div id='official'>OFFICIAL RECEIPT</div>";
$rec .=  "</div>";
$rec .=  "</div>";
$rec .=  "<div class='rcperson row'>";
$rec .=  "<div id='rcp1' class='col-sm-9'></div><div class='col-sm-3'><b>Date: </b>".date_format(date_create($rd['date']),'d/m/Y')."</div>";
$rec .=  "<div id='rcp2' class='col-sm-9'><b>Receieved from : </b>".$person["names"]."</div><div class='col-sm-3'><b>Class : </b>".rx($person['class'])."</div>";
$rec .=  "<div id='rcp3' class='col-sm-9'><b>Reg No : </b>".$dv."</div><div class='col-sm-3'><b>Term : </b>".rx($tx[$rd['term']])."</div>";
$rec .=  "<div id='rcp1' class='col-sm-9'><b>The Sum of Kshs. </b>".rx(conv( intval($rd['amount'])))." Shillings Only</div>";
$rec .=  "</div>";
$rec .=  "<div class='rcbreakdown row'>";
$rec .=  "<div id='bktitle'>";
$rec .=  "<div id='' class='col-sm-8'>Being Payment of </div><div id='' class='col-sm-3'>Shs</div><div id='' class='col-sm-1'>Cts</div>";
$rec .=  "</div>".rec_voteheads($rd,$vh).mapengo($dummy,$rd["arrid"]);
$rec .= "<div id='bkdrow' class='total'><div  class='col-sm-8'><span>E&0.E No ".sprintf("%05d", $rd['id'])."</span><span class='pull-right'>TOTAL : </span></div><div id='' class='col-sm-3'>".addcommas($rd['amount'])."</div><div id='' class='col-sm-1'>00</div></div>";
$rec .=  "</div>";

$rec .=  "<div class='rcfooter row'>";
$rec .=  "<div id='orderno'>".recmods($rd);
$rec .= "<div class='recno col-sm-4' id='rcno".$rid."' onclick='frecno(".$rd['id'].",this.id)'># ".$rcno."</div><div class='col-sm-8'>";
$rec .= "</div>";
$rec .=  "<div class='col-sm-12 row'><div id='fbal' class='col-sm-7' ><b>Fee Balance : </b>".addcommas($vbal)."</div>";
$rec .=  "<div id='farr' class='col-sm-5' >"; if(is_numeric($rd['arrid'])){ $rec .= "<b>Arrears : </b>".addcommas($arrs[$rd['term']][$rd['id']]);} 
$rec .= "</div>";
$rec .= "</div>";
$rec .=  "<div id='sby'  class='col-sm-6' ><b>You were served by : </b>".rx($user['names'])."</div>";
$rec .=  "<div id='sign' class='col-sm-6' ><b>Receiver's Sign : </b>............................</div>";
$rec .=  "</div>";

$rec .=  "</div>";




}


echo($rec) ;

}


function recmods($id){$rcm = ["ca"=>"cash","ch"=>"cheque","mo"=>"money order","ps"=>"pay-in slip","po"=>"postal order","mp"=>"Mpesa",];$rc = "&nbsp&nbsp&nbsp";foreach($rcm as $k=>$r){$b=null;$bb=null;if($id["rcpmode"] == $r){$b = "<b><u>"; $bb = "</u></b>";}$rc .= "<span id='".$k."'  onclick='frcpmode(".'"'.$r.'"'.",".$id['id'].")' > ".$b.rx($r).$bb." / </span>";}return  $rc."</div>";}
function rec_voteheads($rd, $vh){$rec = '';foreach($vh as $v){$amt = '--'; $cts = '-';if(isset($rd[$v])) $amt = addcommas($rd[$v],0);if(isset($rd[$v])) $cts = "00"; $rec .= "<div id='bkdrow'><div id='' class='col-sm-8'>".rx(repdot($v),1)."</div><div id='' class='col-sm-3'>".$amt."</div><div id='' class='col-sm-1'>".$cts."</div></div>";}return $rec;}
function mapengo($dummy,$arrid){$rec = '';while($dummy > 0){$rec .= "<div id='bkdrow'><div id='' class='col-sm-8'>--</div><div id='' class='col-sm-3'>--</div><div id='' class='col-sm-1'>--</div></div>";$dummy--;}$specify = is_null($arrid)? " SPECIFY " : "<strong> Paid on Arrears </strong>";$rec .= "<div id='bkdrow'><div id='' class='col-sm-8'>OTHER ($specify)</div><div id='' class='col-sm-3'>--</div><div id='' class='col-sm-1'>--</div></div>";return $rec;}


?>
<script>
function printme(rcdiv){
	fpreceipts($("#rec"+rcdiv).html() );
}
</script>