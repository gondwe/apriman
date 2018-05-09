

<div class="page-header">
<?php $t = $_GET["t"] = 'finance_list';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
?>
<h1> Payments <?=rx(mx($alias))?> <small>view</small></h1>
</div>
</div>
</div>

<?php include("nav.php") ?>
<?php 

include ("../top/tablo.php");

$p = new tablo("finance_payments");
$p->editset = false;
$p->query = "select id, concat('S',id) as serial, amount, adm_no, class, year(date) as year from finance_payments order by date desc";
// include ("sets.php");
$p->dtable();
