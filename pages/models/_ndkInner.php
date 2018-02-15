
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<div class="page-header">
<?php $_SESSION[$ndk]["route"] = $route = $_GET['t']; $t = $_GET["t"] = 'Inner Template'; ?>
<h1> <?=rx(mx($t))?> <small>new</small></h1>
</div>
</div>
</div>

<?=linkbutton( "views", $t, "View ".rx(mx($t)), $anchor)?>
<?php
