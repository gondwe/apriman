
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<!--<style>.alert {background:none; border-right:none; border-left:none}</style>-->
<div class="page-header">
<?php 
$t = $_GET["t"] = 'vote_student_leaders';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
 ?>
<h1> <?=rx(mx($t))?> <small>new</small></h1>
</div>
</div>
</div>

<?php

$av_yrs = getlist("select distinct year(date) from vote_student_leaders where sid = '$sid'");
spill($av_yrs);