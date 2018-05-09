
<?php require ("../../top/functions.php"); $anchor = null; ?>
<!-- Page Content -->
<!-- @author:gondwe 2017 -->
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
.circle {-moz-border-radius: 2px;-webkit-border-radius: 2px;display: block;float: left;padding: 5px;text-decoration: none;margin-right: 5px;font-family: helvetica;font-size: 13px;border-radius: 15px;}
#g.circle {border-bottom: 2px solid greenyellow;}
#r.circle {border-bottom: 2px solid red;}
#finance_payment {margin-top: 80px;}
#finance_payment #submitbtn { float: right;}

</style>

<div class="page-header">
<?php 
$t = $_GET["p"]; 
$dv = $_SESSION[$ndk]["adm_search"];
$cfc = fetch("select feeclass from finance_fdata where adm_no='$dv' and scode = '$sid' and fyear = '$cyr'");
$cfcn = fetch("select names from finance_feeclasses where id = $cfc and scode = '$sid'");
$me = fetch("select names from students where adm_no = '".$dv."' and sid = '$sid'");
?>
<h1><?=linkbutton( "new", "finance_payments", "Back to Payments ", $anchor)?><?=$me." >> ".$cfcn ?></h1>
</div>
</div>
</div>
<?php //include("../nav.php"); ?>
<!--</div>-->
<?php 


echo "<div class='col-md-12'>";
form_open("finance_chfclass");
echo "<div class='col-md-6 pull-right'>";form_button("change");echo "</div>";
echo "<div class='col-sm-6 pull-right'>";form_cbo_("change_fee_class",namelist("finance_feeclasses"),$cfc);echo "</div>";
form_close(0,"Change");
echo "</div>";

echo "<div class='col-md-12' style='float:none; clear:both'>";

echo "<h4>Feeclass Details  </h3>";

include("studentclass.php");
$d = new fee($dv);
$pt = terms();
$x = $d->voteheads();
$ve = $d->tvp(); $f= [];
foreach($ve as $v=>$e){ $f[$v] = array_sum($e);} 
$v = $d->voteheadslist();
$paid = $f;
// spill($v);

/* table showing payments */include_once("finance_ptable.php");echo "</div>";
