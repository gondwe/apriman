
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["p"];?>
<h1> Vouchers<small> Print Document</small></h1>
</div>
</div>
</div>
<?php include("../nav.php") ?>
<?php 


$i = $_GET["t"];

$j = getlist("select fc.amount, fc.supplycombo as cbo, fb.cost, fc.date as paidon, fb.supply_id as supplies, fb.description, fb.date as supply_date, fa.names, fa.contacts, fa.address
				from finance_supplier_payments as fc
				left join finance_supplies as fb on fb.id = fc.supplycombo
				left join finance_suppliers as fa on fb.supplier_id = fa.id
				
				where fc.id = '$i'");
// spill($j);

$cbo = $j["cbo"];
$paidon = $j["paidon"];
$cost = $j["cost"];


$paidup = fetch("select sum(amount) as paid from finance_supplier_payments where supplycombo = '$cbo' and date <= '$paidon'");
$bal = $cost - $paidup;


// echo("BALANCE ".$bal);


?>
<style> 
	table {display:none}
	table {min-width:80%;  solid;border-spacing: 0px;margin:0px auto; margin-top:25px}
	#tablex {border:0px solid; text-align:center; margin:0px auto; width:110%}
	#tablex td{border:0px solid}
	
	#bdr {border-bottom:1px solid; border-left:1px solid; padding-left: 5px;}
	#rgt {border-right:1px solid;border-bottom:1px solid; border-left:1px solid}
	#btr {border-right:1px solid;border-bottom:1px solid; border-top:1px solid}
	#bth {border-top:1px solid;border-bottom:1px solid; border-left:1px solid; border-right:1px solid }
	#bth-rgt {border-top:1px solid;border-bottom:1px solid; border-right:1px solid }
	
	th {border-right:1px solid; border-bottom:1px solid;padding-left: 5px;border-top:1px solid;}
	#plain2 {width:100%;text-align:center;margin-bottom:0px}
	#btm {border-bottom:1px solid #333;}
</style>
<div class='row'>
<?php 

printA4("voucher","p", "<b>VOUCHER NO</b>.".$i."|<b>PAYEE NAME AND ADDRESS : </b>".rx($j["names"],2)."</u>|<b>DATE :</b> ".$j["paidon"]);
?>

</div>
<div class='row'>
<div id="" style="">

<table id='voucher' border=1>
<thead>
<tr>
	<td id='bth' rowspan=2 width=20px><strong>DATE</strong></td>
	<td id='btr' rowspan=2><strong>PARTICLUARS</strong></td>
	<td id='bth-rgt' colspan=2 style='text-align:center'><strong>AMOUNT</strong></td>
</tr>
<tr>
<td id='bdr' width=20px style='text-align:center'><strong>SHS</strong></td>
<td id='rgt' width=20px style='text-align:center'><strong>CTS</strong></td>
</tr>
</thead>
<tbody>
<tr  style='height:300px;'>
	<td id='bdr' width=15%><?=date_format(new DateTime($j["paidon"]),"d/M/Y") ?></td>
	<td id='bdr' width=65% style='padding-bottom:100px;padding:10px;'><blockquote>Being Payment for : <?=rx($j["supplies"],2)?></blockquote><br><br><br><br><br><i style='margin-top:50px'><?=$j["description"]?></i></td>
	<td id='bdr' width=15% style='text-align:right; padding-right:5px'><?=addcommas($paidup,0)?></td>
	<td id='rgt' width=5% style='text-align:center'>00</td>
</tr>
<tr id='bdr'>
	<td id='bdr'></td>
	<td id='bdr'><strong>TOTAL</strong></td>
	<td id='bdr' style='text-align:right; padding-right:5px'><strong><?=addcommas($paidup,0)?></strong></td>
	<td id='rgt' style='text-align:center'><strong>00</strong></td>
</tr>
<tr><td colspan=4 style='padding-bottom:30px'></td></tr>
<tr>
	<td colspan=4 id='btm' style='padding-left:5px'><strong>CASH/CHEQUE NO.</strong><span id='space'></span></td>
</tr>
<tr>
	<td colspan=4 id='btm' style='padding-left:5px'><strong>PAYMENT AUTHORISED BY.</strong><span id='space'></span></td>
</tr>
<tr>
	<td colspan=4 id='btm' style='padding-left:5px'><strong>HEAD TEACHER/ PRINCIPAL.</strong><span id='space'></span></td>
</tr>
<tr>
	<td colspan=4  style='padding-right:15px;text-align:right'>Clerk/ Bursar/ Secretary<span id='space'></span></td>
</tr>
<tr><td colspan=4 style='padding-bottom:10px'></td></tr>


<!--section II-->
<tr>
	<td colspan=4  style='padding-left:15px;padding-bottom:10px'><strong>SECTION II :</strong><span id='space'></span></td>
</tr>

<tr>
	<td id='bth' style='text-align:center' rowspan=2 ><strong>VOTEHEADS</strong></td>
	<td id='btr' style='text-align:center' rowspan=2><strong>DETAILS</strong></td>
	<td id='bth-rgt' style='text-align:center' colspan=2 style='text-align:center'><strong>AMOUNT</strong></td>
</tr>
<tr>
	<td id='bdr' style='text-align:center'><strong>SHS</strong></td>
	<td id='rgt' style='text-align:center'><strong>CTS</strong></td>
</tr>

<tr>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='rgt'  style='padding-bottom:15px'></td>
</tr>

<tr>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='rgt'  style='padding-bottom:15px'></td>
</tr>

<tr>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='rgt'  style='padding-bottom:15px'></td>
</tr>

<tr>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='rgt'  style='padding-bottom:15px'></td>
</tr>

<tr>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='bdr'  style='padding-bottom:15px'></td>
	<td id='rgt'  style='padding-bottom:15px'></td>
</tr>

<tr id='bdr'>
	<td id='bdr'></td>
	<td id='bdr'><strong>TOTAL</strong></td>
	<td id='bdr' style='text-align:right; padding-right:5px'><strong><?=addcommas($paidup,0)?></strong></td>
	<td id='rgt' style='text-align:center'><strong>00</strong></td>
</tr>

<tr><td colspan=4  style='padding-left:15px;padding-bottom:30px'></td></tr>

<tr><td colspan=4 id='btm' style='padding-left:5px'>Receipt for the Sum of Kshs. </td></tr>
<tr><td colspan=4 id='btm' style='padding-left:5px;padding-bottom:20px'><strong></strong></td></tr>

<tr><td colspan=4  style='padding-left:15px;padding-bottom:30px'></td></tr>

<tr>
	<td colspan=4 style='padding-left:5px;padding-bottom:15px'>
		<strong>DATE...........................</strong>
		<strong>SIGNATURE......................</strong>
		<strong>ID NO..........................</strong>
	</td>
</tr>

</tbody>
</table>

</div>
</div>
