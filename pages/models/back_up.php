
<!-- @author:gondwe 2017 -->
<div class="page-header">
<?php $t = $_GET["t"] = "backup";?>
<h1> <?=rx(mx($t))?> <small>add New</small></h1>
</div>
</div>
</div>


	
	<form class='form container'  action="backup">
		<button class='btn btn-success' type='submit'>Create Backup</button>
	</form>
	
	<?php 



$backups = opendir("./backups");
$bk = readdir($backups);

// spill($backups);
echo "<h2>Previous Backups</h2><ol>";
while($j = readdir($backups))
{
	if(!is_dir($j)){
		$bb[] = explode("-",$j)[2];
		$file = "pages/backups/".$j;
		?><li style='margin:2px'><a  href='<?=$file?>'><?=$j?></a><button class='btn-red' onclick="deleteFile('<?=$file?>')">x</button></li><?php 
	}
}
echo "</ol>";



?>






