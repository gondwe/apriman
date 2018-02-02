
<!-- Page Content -->
<!-- @uthor:gondwe 2017 -->
<style>.alert {background:none; border-right:none; border-left:none}</style>
<div class="page-header">
<?php 
$t = $_GET["t"] = 'student_settings';
$_SESSION[$ndk]["route"] = $route = $t; 
$_SESSION[$ndk]["alias"] = $alias = mx($t);
 ?>
<h1> <?=rx(mx($t))?> <small>new</small></h1>
</div>
</div>
</div>

<?php


?>
<div class='col-sm-12 panel panel-default'>
<h3>Promote / Demote</h3>
<?php 
	form_open("promote_students");
	// echo "<div class='col-sm-4'>"; form_cbo_("class",getlist("select id, names from classes")); echo "</div>";
	echo "<div class='col-sm-4'>"; form_cbo_("action",[1=>"PROMOTE",2=>"DEMOTE",]); echo "</div>";
	echo "<div class='col-sm-4'>"; form_button("PROCESS"); echo "</div>";
	form_close(0);
?>
<div>
<hr>