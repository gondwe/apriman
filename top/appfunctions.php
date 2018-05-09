<?php 

$cyr = date("Y");
function table_close($foot = 1){echo "</table>";echo "</div>";echo "</div>"; if($foot) { ?><script>jQuery(document).ready(function() {TableExport.init();});</script><?php }}
function table_foot(){?><script>jQuery(document).ready(function() {TableExport.init();});</script><?php }


/* application specific functions */
function terms(){ global $sid; return getlist("select id, vdat from vdata where vprop = 'terms' and xdat = '$sid'");}
function getvoteheads(){ global $sid; return getlist("select id, names from finance_votehead_names where id in (select votehead from finance_voteheads where scode = '$sid' and vhyear = year(current_timestamp))");}
function inmenu($arr){echo '<div class="col-sm-12">';foreach($arr as $a){$b = explode("/",$a);$slug = isset($b[1])? $b[1] : $b[0] ;linkbutton2(  $b[0], ($slug == $b[0]? null : $b[1]), rx(mx($slug),1) );}echo "</div>";}
function namelist($tbl){ global $sid; return getlist("select id, names from `$tbl` where scode='$sid'");}
function getfullvoteheads($yr = null){
	fix999();
	return feeclass_voteheads("999",$yr);
}


function feeclass_voteheads($fcv,$yr=null){
	global $sid;
	$yr = is_null($yr)? " and fv.vhyear = year(current_timestamp) " : " and fv.vhyear = ".$yr;
	$sql = "SELECT fv.id, fvn.names as votehead, 
					ucase(cl.names) as class, format(fv.amount,2)as amount, fv.position, vdata.vdat as term, 
					fa.names as 'account' 
					from finance_voteheads as fv
					inner join finance_feeclasses as feeclasses on fv.feeclass = feeclasses.id
					left join finance_votehead_names as fvn on fv.votehead = fvn.id
					left join finance_accounts as fa on fv.account = fa.id
					left join vdata on fv.term = vdata.id and vdata.vprop = 'terms'
					left join classes as cl on cl.id = fv.class
					where fv.feeclass = '$fcv'
					and fv.scode = '$sid' $yr
					";
	return get($sql);
}

function fix999(){
	global $sid;
	$check = fetch("select scode from finance_feeclasses where id = 999");
	if($check !== $sid){
		process("update finance_feeclasses set scode = '$sid' where id  = 999");
	}
}

function last_payment(){
	global $sid;
	$lp = getlist("select format(fp.amount,2) as amount, date_format(fp.date, '%W %D %M, %Y') as date, str.abbr as stream,  concat(st.names, '( REGNO:',st.adm_no,') ') as student, cl.names as class, u.names as bywho
				from finance_payments as fp left join students as st on fp.adm_no = st.adm_no and st.sid = '$sid'
				inner join classes as cl on cl.id = st.class
				inner join streams as str on str.id = st.stream
				inner join users as u on u.id = fp.uid
				where fp.id = (select max(id) from finance_payments where scode = '$sid')
				");
				if(!empty($lp)){
					
					info(
	'
	Last Invoice >> 
	KES.'.$lp["amount"].' <div id="">'.rx($lp["student"]).$lp["class"].' '.$lp["stream"].' On '.$lp["date"].' by '.rx($lp["bywho"]).'</div>
	'
			);	}
}

function get_exp_paylog($exp_id){
	global $sid;
	$x =1;
	$names = rx(fetch("select names from finance_expenditure_names where id = '$exp_id'"));
	$pay = get("select fep.id, fen.names as item, fvn.names as votehead, fep.amount, fep.date
				from finance_exp_payments as fep left join finance_votehead_names as fvn on fvn.id = fep.votehead
				left join finance_expenditure_names as fen on fen.id = fep.expenditure
				where fep.expenditure = '$exp_id' and fep.scode = '$sid'");
	echo "<hr>";
		table_open('p',"<h4>Recent Payments : $names</h4>");
		echo "<thead>";
			echo "<tr>";
			echo "<th>Sno</th>";
			echo "<th>Item</th>";
			echo "<th>Votehead</th>";
			echo "<th>Amt Paid</th>";
			echo "<th>Date</th>";
			echo "<th>Action</th>";
			echo "</tr>";
		echo "</thead>";
		
		echo "<tbody>";
		foreach($pay as $pp){
			echo "<tr id='row".$pp['id']."'>";
			echo "<td>$x</td>";
			echo "<td>".rx($pp['item'])."</td>";
			echo "<td>".rx($pp['votehead'])."</td>";
			echo "<td style='text-align:right'>".addcommas($pp['amount'])."</td>";
			echo "<td>".date_format(date_create($pp['date']),'dS M, Y')."</td>";
			echo "<td><a href='#exp_payment_voucher/".$pp['id']."'>PRINT VOUCHER</a> | <a href='javascript:cancelexppay(".$pp['id'].")'>CANCEL</a></td>";
			echo "</tr>";
			$x++;
		}
		echo "</tbody>";
		table_close();
}

function get_supplier_paylog($supplier_id){
		$pay = get("select fc.id, fc.amount, fc.supplycombo as cbo, fb.cost, fc.date as paidon, fb.supply_id as supplies, fb.description, fb.date as supply_date, fa.names, fa.contacts, fa.address
				from finance_supplier_payments as fc
				left join finance_supplies as fb on fb.id = fc.supplycombo
				left join finance_suppliers as fa on fb.supplier_id = fa.id
				where fc.supplycombo in (select id from finance_supplies where supplier_id  = '$supplier_id')
				group by fc.id
				order by paidon desc
				");
				// spill($pay);
		
		$x =1;
		$names = rx(fetch("select names from finance_suppliers where id = '$supplier_id'"));
		echo "<hr>";
		table_open('p',"<h4>Recent Payments : $names</h4>");
		echo "<thead>";
		echo "<tr>";
		echo "<th>Sno</th>";
		echo "<th>Item</th>";
		echo "<th>Amt Paid</th>";
		echo "<th>Bal</th>";
		echo "<th>Date</th>";
		echo "<th>Action</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		foreach($pay as $pp){
			$cbo = $pp["cbo"];
			$paidon = $pp["paidon"];
			$paid = fetch("select sum(amount) from finance_supplier_payments where supplycombo = '$cbo' and date <= '$paidon'");
			$bal = $pp["cost"] - $paid;
			echo "<tr id='row".$pp['id']."'>";
			echo "<td>$x</td>";
			echo "<td>".rx($pp['supplies'])."</td>";
			echo "<td style='text-align:right'>".addcommas($pp['amount'])."</td>";
			echo "<td style='text-align:right'>".addcommas($bal)."</td>";
			echo "<td>".date_format(date_create($pp['paidon']),'dS M, Y')."</td>";
			echo "<td><a href='#finance_payment_voucher/".$pp['id']."'>PRINT VOUCHER</a> | <a href='javascript:cancelpay(".$pp['id'].")'>CANCEL</a></td>";
			echo "</tr>";
			$x++;
		}
		echo "</tbody>";
		table_close();
}




/* form functions */
function linkbutton($a,$b,$c, $d=null){if($d == null){?><a class="btn btn-sm btn-orange" style='margin:10px;' href="#<?=$a?>/<?=$b?>"><?=$c?> <i class="fa fa-arrow-circle-right"></i></a><?php }}
function linkbutton2($a,$b,$c){ ?><a class="btn btn-teal btn-xs pull-right" style='margin:10px 0px 10px 5px;' href="#<?=$a?><?=$b==""?null:"/" ?><?=$b?>"><?=$c?> <i class="clip clip-bubble-paperclip"></i></a><?php }
function form_open($n){echo "<form id='".$n."' role='form' class='form-horizontal' method='post' action='".$n.".php'>";}
function form_open_($n,$i,$t="text",$dv="", $v="SAVE"){ ?>
	<form id='<?=$n?>' role='form' class='form-horizontal' method='post' action='<?=$n?>.php'>
	<div class='form-group'>
	<label class='col-sm-2 control-label'><?=mx(rx($i))?></label>
	<div class='col-sm-3'>
	<input id='form-field-11' type='<?=$t?>' required class='form-control' name='<?=$i?>' value='<?=$dv?>'>
	</div>
	
	<div class='col-sm-3'>
	<input type='submit' id='submitbtn' class='btn btn-sm btn-primary ' value='<?=$v?>' >
	</div>
	
	</div>
	</form>
	<?php
	}
	
function form_input($n, $t="text"){ ?>
	<div class='form-group'>
	<label class='col-sm-3 control-label'><?=rx(mx($n))?></label>
	<div class='col-sm-8'>
	<input id='form-field-11' type='<?=$t?>' required class='form-control' name='<?=$n?>' >
	</div>
	</div>
	<?php
}

function form_close($callbutton = 1, $n="SAVE"){ if($callbutton){form_button($n);}?></form><?php }


function form_button($n,$link=0,$dest=''){
		?>
	<div class='form-group'>
	<div class='col-sm-12'>
	<?php if($link){ ?>
	<a href='#<?=$dest?>' class=' btn btn-success' ><?=rx(mx($n,1))?></a>
	<?php }else{ ?>
	<input type='submit' id='submitbtn' class=' btn btn-success pull-right' value='<?=mx(rx($n,1))?>' >
	<?php } ?>
	</div>
	</div>
	<?php
}

function form_cbo_($i, $a, $s=null){
	echo ("
		<div class='form-group'>
		<label class='col-sm-3 control-label'>".rx(mx($i))."</label>
		<div class='col-sm-8'>
		");
	?><select id='<?=$i?>' class='form-control' name='<?=$i?>' onchange='cbo_change("<?=$i?>",this.value)'>")<?php
		foreach($a as $b=>$c){
			$selected = $s == null ? null : ($s == $b ? "selected=TRUE" : null);
			echo "<option $selected value='$b'>".rx($c,1)."</option>";
		}
	echo("</select>");
	echo("</div>");
	echo("</div>");
}


function table_open($orient,$title = null, $tid=1){ global $ndk; $_SESSION[$ndk]["pdftitle"] = "<br><small>".strip_tags($title)."</small>";  ?>
<div class="panel-body">
			<div class="row">
				<div class="col-md-12 space20">
				<div class="pull-left"><?=$title?></div>
					<div class="btn-group pull-right">
						<button data-toggle="dropdown" class="btn btn-sm btn-green dropdown-toggle">Export <i class="fa fa-angle-down"></i></button>
						<?php printA4("sampletable".$tid,$orient) ?>
						
						<ul class="dropdown-menu dropdown-light pull-right">
							<li><a href="#" class="export-pdf" data-table="#sampletable<?=$tid?>" > Save as PDF </a></li>
							<li><a href="#" class="export-excel" data-table="#sampletable<?=$tid?>" > Export to Excel </a></li>
							<li><a href="#" class="export-doc" data-table="#sampletable<?=$tid?>" > Export to Word </a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover table-bordered table-full-width" id="sampletable<?=$tid?>">
	<?php
}


function bswitch ($v,$r,$c) {
	$dis = isadmin() ? null : "disabled" ;
	$dv = $v == 0 ? null : "checked" ;
	$data = "'".$v."','".$r."','".$c."'";
	return 
	'<div id="cr'.$r.$c.'"  class="make-switch" data-on="primary" data-off="info">
		<input onchange="crudify('.$data.')" type="checkbox"  '.$dis.' '.$dv.' >
	</div>';
}

function isadmin(){
	global $ndk;
	$i = fetch("select lcase(names) as name from user_types where id = '".$_SESSION[$ndk]["user"]["usertype"]."'");
	return $i == 'admin' ? true : false;
}

function printA4($print_id,$orient,$titles = ""){
	global $ndk;
	$_SESSION[$ndk]["mpdforient"] = strtolower($orient) == 'p' ? "P" : "L";
	?><a href='javascript:printmeA4("<?=$print_id?>", "<?=$titles?>");' 
			style='margin:10px;margin-top: 0px;'
			class='btn btn-sm btn-red pull-right hidden-print' 
			alt='print this page' 
			id='print-button'>Print PDF</a><?php
}



function bank_details(){
	global $sid;
	$banks = get("select * from finance_banks where scode = '$sid'");
	echo "<div><strong>SCHOOL BANK ACCOUNT DETAILS</strong></div>";
	echo "<div>all School fees to be deposited in any of the school accounts below :</div><br>";
	// echo "<table border=0>";
	echo "<tr><br>";
	$xx = 3;
	foreach($banks as $ba=>$nk):
	echo "<td style='border:0px;text-align:center; ' colspan='$xx'>";
	echo "<div style='float:left; width:45%;text-align:center;'>";
	echo "<div><strong>".$nk["names"]."</strong></div>";
	echo "<div>".$nk["acc_name"]."</div>";
	echo "<div>AC/No : ".$nk["acc_no"]."</div>";
	echo "<div>BRANCH : ".$nk["branch"]."</div>";
	echo "</div>";
	echo "</td>";
	$xx--;
	endforeach;
	echo "</tr><br>";
	// echo "</table>";
	echo "<div style='float:none; clear:both;'><br>";
	echo "</div>";

}


function panela($i=NULL, $d=NULL){
	$d = $d==NULL? "none" : "block";
	?><div class="panel panel-default"><div class="panel-heading"><i class="fa fa-external-link-square"></i><?=$i?>
<div class="panel-tools"><a class="btn btn-xs btn-link panel-collapse expand" href="#"></a>
</div></div><div class="panel-body" style="display:<?=$d?>"><?php
}

function panelb(){
	echo "</div>";
	echo "</div>";
}














	class bswiz {
		protected $titles = [];
		public $wiztits = [];
		protected $stages;
		
		
		function wiz(){
			$this->stages = count($this->titles);
			if($this->stages > 1){
				echo '<form action="" role="form" class="smart-wizard form-horizontal" id="form" method="post" enctype="multipart/form-data">';
				echo '<div id="wizard" class="swMain">';
				$this->setsteps();
				$this->setdivs();
				// $this->savediv();
				
				echo '</div>';
				echo '</form>';
			}
		}

		
		function setsteps(){
			echo "<ul>";
			foreach($this->titles as $k=>$t){				
				$t = rx($t);
				echo '<li>
						<a href="#step-'.$k.'"><div class="stepNumber">'.$k.'</div>
							<span class="stepDesc"> Step '.$k.' <br />
								<small>'.$t.'</small> </span>
						</a>
					</li>';
				
			}
			echo "</ul>";
			echo '
				<div class="progress progress-striped active progress-sm">
					<div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-success step-bar">
						<span class="sr-only"> 0% Complete (success)</span>
					</div>
				</div>';
		}
		
		protected $ft;
		protected $aliases;
		
		private function splitme($i){
			$j = str_replace(" ,",",",$i); return explode(",",$j);
		}
		
		protected $imagefields;
		function filetypes($i){
			if(is_string($i)){
				$j = $this->splitme($i);$this->ft[$j[0]] = $j[1];
				if(strtolower($j[1]) == 'file'){$this->imagefields[] = $j[1]; }
			}else{
				
			}
		}
		
		function titles($i){
			$this->titles = explode(",",$i);
		}
		
		function wizdata($i){			
			$this->wiztits = $i;
		}
		
		function aliases($i){
			if(is_string($i)){
				$j = $this->splitme($i);$this->aliases[$j[0]] = $j[1];				
			}else{
				
			}
		}
		
		function setdivs(){
			
			foreach($this->titles as $k=>$w){				
				echo '<div id="step-'.$k.'"><h2 class="StepTitle" style="margin-left:1%;">'.rx($w).'</h2>';
				$j = $this->wiztits;
				
				
				foreach($j[$w] as $i){
				$type = isset($this->ft[$i])? $this->ft[$i] : "text";
				$m = isset($this->aliases[$i]) ? $this->aliases[$i] : $i;
				$rq = trim($type) == 'file' ? NULL : 'required=TRUE';
					echo 
					'<div class="form-group">
						<label class="col-sm-3 control-label">
							'.rx($m).' <span class="symbol required"></span>
						</label>
						<div class="col-sm-7">
							<input type="'.trim($type).'" '.$rq.' class="form-control" id="'.$i.'" name="'.$i.'" placeholder="Text Field">
						</div>
					</div>
					';
				}
				
				$this->get_nav($k);
				
				echo "</div>";
				
			}
			
		}
		
		function save($a, $tbl){
			$db = forge_db();				
			if(!empty($_FILES)){
				foreach($_FILES as $k=>$arr){
					$p[$k] = end(explode("//",save_pic($_FILES, $tbl, $k)));
				}
				
				$a = array_merge($a,$p);					
				//die(echo2($a));
			}
			$j = insertdata($a,$tbl);
				
			if($db->query($j)){
				// do an green alert here
			}else{
				// do an red alert here
				echo2($db->error);
			}
		}
		
		
		function get_nav($i){
			echo '<div class="form-group">';
			
			if($i>0) { 
			echo 	'<div class="col-sm-2 col-sm-offset-3">
						<button class="btn btn-light-grey back-step btn-block">
							<i class="fa fa-circle-arrow-left"></i> Back
						</button>
					</div>';
			}
			if($i < count($this->titles)-1) { 
			echo '
					<div class="col-sm-2 col-sm-offset-3">
						<button class="btn btn-blue next-step btn-block">
							Next <i class="fa fa-arrow-circle-right"></i>
						</button>
					</div>';
			}else{
			echo '
					<div class="col-sm-2 col-sm-offset-3">
						<input type="submit" class="btn btn-green btn-block" value="Save" />						
					</div>';				
			}
			echo '</div>';
		}
		
	}


function info($i,$div=1){
	$ds = $div == 1 ? "div" : "span";
	echo "<$ds    class='alert-success' style ='padding:10px 5px 5px 15px;border-radius:5px; margin-top:5px'>";
	echo $i;
	echo "</$ds>";
}