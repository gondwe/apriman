
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->

<div class="page-header">
<?php $t = $_GET["t"] = 'finance_banks';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
?>
<h1> <?=rx(mx($alias))?> <small>new</small></h1>
</div>
</div>
</div>


<?php

include ("nav.php");
include ("../top/tablo.php");

$d = new tablo("vdata","vprop='banks'");
include ("sets.php");
$d->dtable();