<?php 



?>

		

<script>
$("input:text[name=adm_no]").keyup(function(){adm_search(this.value);});
frefunds();
farrears();

function changeGET(){
	$.post("pages/xhr/changeGET.php", {r:'finance_refunds'});
	document.getElementById("memos").innerHTML = "";
}


</script>
