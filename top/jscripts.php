		
		
		<script>
			const docroot = "http://localhost/sites/ober/";
			
			function eds(url){window.location= url;}
			function ajaxdel(url, node){ $.ajax({ url:"pages/delete.php",type:"POST",data:"id="+url}).done( function(msg){var m = $.trim(msg); console.log(m); if(m.indexOf("Error") < 0){ $("#row"+node).hide("slow"); }else{ } document.getElementById('memos').innerHTML = m;});}			
			function del(url,node){ if(confirm('You are about to delete 1 row?')){ajaxdel(url, node);} }
			function vsavel(url){ if(confirm('This will replace the Current years student leaders data. Proceed ?')){ajpost(url, "pages/xhr/vote_saveleaders.php");}}
			function rollback(url){ if(confirm('Cancel Payment ? This action cannot be Undone !')){deltxn(url);}}
			

			function proc(f){ ajpost(f, "pages/xhr/proc.php"); }	
			function mod(f){ ajpost(f, "pages/xhr/modkeys.php",'modcontent'); }	
			function vcheck(f){ajpost(f, "pages/xhr/vote_votercheck.php");}	
			function vout(f){ajpost(f, "pages/xhr/vote_signout.php");}	
			function vsavecan(f){ajpost(f, "pages/xhr/vote_savecandidate.php");}	
			function vsavel(f){ajpost(f, "pages/xhr/vote_saveleaders.php");}	
			function fchngfcl(f){ajpost(f, "pages/xhr/finance_chfclass.php",1);}	
			function vloadcandidate(f){ajpost(f, "pages/xhr/vote_loadcandidate.php", 1, 0, "candidates");}	
			function deltxn(f){ajpost(f, "pages/xhr/finance_rollback.php",1);}	
			function fredir_receipt(f,g){ajpost(f, "pages/xhr/finance_receipt.php",1,0,"memos",g);}	
			function frecno(f,g){
				var recno = prompt("Please enter Receipt No.");
				if (recno != null) {
					document.getElementById(g).innerHTML = "<p># "+ recno+"</p>";
					ajpost(f+'/'+recno, "pages/xhr/finance_receiptno.php",1,0);
				} 
			}	
			function frcpmode(f,id){ajpost(f+'/'+id, "pages/xhr/finance_rcpmode.php",1);}
			function adm_search(f){ ajpost(f, "pages/xhr/adm_search.php",1,0); }
			function farrears(f=0){ajpost(f, "pages/xhr/finance_arrears.php", 1, 0, "notice");}	
			function frefunds(f=0){ajpost(f, "pages/xhr/finance_refunds.php", 1, 0, "notice2");}	
			function ftranfervh(f){ajpost(f, "pages/xhr/finance_vhtransfer.php", 1, 0, "memos");}	
			function fpreceipts(f){ajpost(f, "pages/xhr/finance_print_rec.php", 1, 0, "memos", docroot+"pages/models/finance_preceipt.php");}	
			function fpdocs(f,t){ajpost(f=[f,t], "pages/xhr/finance_print.php", 1, 0, "memos",  docroot+"pages/models/documentprint.php");}	//
			function fvhclear(f){if(confirm('Clear '+f+' ? This action cannot be Undone !')){ajpost(f, "pages/xhr/finance_vhclear.php", 1, 0, "memos");}}
			function modactivate(f){ajpost(f, "pages/xhr/modact.php",1);}
			function crudify(f,g,h){ajpost(f=[f,g,h], "pages/xhr/crudify.php",1,1);}	

			function arrearsdata(f){ ajpost(f, "pages/xhr/finance_arrears_det.php",1,0,"arrdata"); }

	
			
			function ajpost(f,xh, direct='0', refresh='1', area='memos', redir=''){
				var dat = direct == 1? 'dat='+f : $("#"+f).serialize();
				$.ajax(
					{url:xh,type:"POST",data:dat}
					).done( function(msg){
					if(refresh == 1) { start(area); }
					if(refresh == 2) { document.getElementById(area).reload(); }else{
						if(redir == ''){ document.getElementById(area).innerHTML = $.trim(msg);}
						else{ window.location = redir; }
					}
					});
			}			
		</script>

		<script src="assets/plugins/jQuery-lib/jquery-3.2.1.min.js"></script>
		

		
		<script src="assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
		<script src="assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="assets/plugins/less/less-1.5.0.min.js"></script>
		<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
		<script src="assets/js/main.js"></script>
		
		<script src="assets/plugins/ladda-bootstrap/dist/spin.min.js"></script>
		<script src="assets/plugins/ladda-bootstrap/dist/ladda.min.js"></script>
		<script src="assets/plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>
		<script src="assets/js/ui-buttons.js"></script>
		
		<script src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
				
		<script type="text/javascript" src="assets/plugins/jquery-mockjax/jquery.mockjax.js"></script>
		<script type="text/javascript" src="assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>

		<script src="assets/plugins/tableExport/tableExport.js"></script>
		<script src="assets/plugins/tableExport/jquery.base64.js"></script>

		<script src="assets/plugins/tableExport/jspdf/libs/sprintf.js"></script>
		<script src="assets/plugins/tableExport/jspdf/jspdf.js"></script>
		<script src="assets/plugins/tableExport/jspdf/libs/base64.js"></script>
		<script src="assets/js/table-export.js"></script>
		<script src="assets/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>
		
		<script src="assets/plugins/bootstrap-paginator/src/bootstrap-paginator.js"></script>
		<script src="assets/plugins/jquery.pulsate/jquery.pulsate.min.js"></script>
		<script src="assets/plugins/gritter/js/jquery.gritter.min.js"></script>
		<script src="assets/js/ui-elements.js"></script>
		
		<script src="assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
		<script src="assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
		<script src="assets/js/ui-modals.js"></script>

		<?php boot_strap();	?>
		
		<script>
			
			$(document).on("submit", "form", function(event)
			{
				event.preventDefault(); 
				actionpage = $(this).attr("action");
				if(actionpage.indexOf(".php") < 0){
					actionpage = actionpage  + ".php";
				}
				$.ajax({
					url: "pages/xhr/"+actionpage,
					type: $(this).attr("method"),
					data: new FormData(this),
					processData: false,
					contentType: false,
					success: function (data, status)
					{$("#pagecontent").load("pages/loading.php"); start(); document.getElementById("memos").innerHTML = $.trim(data);},
					error: function (xhr, desc, err){/* console.log(err); */}
				});   
			});
			


			$(window).on('hashchange', function() { 
				
				start(); 
				document.getElementById('memos').innerHTML = '';
				document.getElementById('notice').innerHTML = '';
				document.getElementById('notice2').innerHTML = '';
				
				});
			
			function start(){
				var h = window.location.hash;
				var s = h.split('/'); a = s[0]; b = s[1]; c = s[2];
				var ab = a.substring(1,a.length);
				var p = 'p='+ab+",t="+b+",i="+c
				const pagecontent = "#pagecontent";
				var bigboys = [
					"finance_stats",
					"vote_results",
					"voter_summary",
					"finance_fee_structure",
					"finance_payments",
					"receipts",
					"students",
					"crud",
					];
				if($.inArray(b,bigboys) > 0 || $.inArray(ab,bigboys) > 0 ){$(pagecontent).load("pages/loading.php");}
				
				
				$.ajax(
					{
						url:"pages/handler.php",
						type:"GET",
						data:'d='+p
					}
					
					).done( function(msg){
						$(pagecontent).load(msg);
					});
			}
			
			
			
			function cbo_change(i,d){
				switch(i) {
					case 'fee_class': fchngfcl(d); break;
					case 'finance_name': ajpost([i,d], "pages/xhr/form_combo.php",1,0,"finance_order"); ajpost(d, "pages/xhr/finance_supplier_paylog.php",1,0,"paylog");  document.getElementById("supply_details").innerHTML = null; break;
					case 'finance_order': ajpost([i,d], "pages/xhr/form_combo.php",1,0,"supply_details");  break;
				}
			}
			
			
			function actify(){
				prompt("Enter Application Renewal Code");
			}

			
			
			
		</script>

		<script>
		
			jQuery(document).ready(function() {
				Main.init();
				UIButtons.init();
				UIElements.init();
				start();
			});
		
		
			function printme(rcdiv){
				var x = escape('<div id="'+rcdiv+'" class="receipt">'+$("#rec"+rcdiv).html()+"</div>");
				fpreceipts(x);
			}
			
			function printmeA4(rcdiv,titles){
				var x = escape('<table class="table table-striped table-hover table-bordered table-full-width" id="'+rcdiv+'">'+$("#"+rcdiv).html()+"</table>");
				fpdocs(x, titles);
			}
			
			
			
		</script>
