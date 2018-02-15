
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<div class="page-header">
<?php $_SESSION[$ndk]["route"] = $route = $_GET['t']; $t = $_GET["t"] = 'vote_candidates'; ?>
<h1> <?=rx(mx($t))?> <small>new</small></h1>
</div>
</div>
</div>

<?php



include("nav.php");
include ("../top/tablo.php");

$d = new tablo($t);
include ("sets.php");