<?php 
	class student {
		
		protected $adm;
		protected $sdata;
		protected $_adw;
		protected $_asw;
		protected $scode;
		protected $user;
		
		public $terms;
		public $classs;public $classname;
		public $stream;public $streamname;
		public $dorm;public $dormname;
		
		
		function __construct($i, $j){
			$this->adm = $i;
			$this->init();
			$this->_adw = " where adm_no = '".$this->adm."'";
			$this->_asw = $this->_adw." and scode = '".$this->scode."'";
		}
		
		private function init(){
			global $sid, $ndk;
			$this->scode = $sid;
			$this->fyear = date("Y");
			$d = get("select * from students where adm_no = '$this->adm' and sid = '$this->scode'");
			$this->terms = terms();
			$this->sdata = isset($d[0])? $d[0] : null;
			if(!empty($this->sdata)){
				$this->classs = $this->sdata["class"];
				$this->stream = $this->sdata["stream"];
				$this->dorm = $this->sdata["dorm"];
				$this->classsname = $this->levels("class");
				$this->streamname = $this->levels("stream");
				$this->dormname = $this->levels("dorm");
			}
			$this->user = $_SESSION[$ndk]["user"];
		}
		
		function levels ($level){$b = ["class"=>"classes","stream"=>"streams","dorm"=>"dorms",]; return  fetch("select cl.abbr from students as st left join `".$b[$level]."`  as cl on cl.id = st.`".$level."` ".$this->_adw);}
		
		function err($code){
			$r = null;
			switch($code){
				case 1 : $r = "adm no not found !"; break;
				case 2 : $r = "voteheads not found !";break;
				case 3 : $r = "Transaction Successful";break;
				case 4 : $r = "Full Year Cleared. ";break;
				case 5 : $r = "Voteheads not in order.";break;
				case 6 : $r = "Feeclass yields no voteheads.";break;
			}
			return $r;
		}

	}
	
	
	
	
	
	class fee extends student{
		
		protected $amount;
		protected $received;
		protected $balance;
		protected $arrears = [];
		protected $feeclass;
		protected $paysql = '';
		protected $bkid;
		protected $pmode;
		protected $bnk = null;
		protected $bnkc = 0;
		
		
		public $fyear;
		public $ydebt = [];
		public $ypay = [];
		public $voteheadnames = [];
		
		protected $voteheads = [];
		// protected $vpay = ['id','admno','amount','date',];
		
		private $tvp = [];
		private $tvpx = [];
		private $tvme = [];
		private $dfc = '999';
		
		function __construct($i=null, $j=null){
			parent:: __construct($i, $j);
			$this->received = $j;
			if($i !== null) { $this->init(); }
		}
		
		function prepare($a,$b,$c){
			$this->pmode = $a;
			$this->bnk = $b;
			$this->bnkc = $c;
			
		}
		
		private function init(){
			$this->amount = $this->received;
			$this->feeclass = $this->feeclass();
			$maxid = fetch("select max(id) from finance_payments where scode = '$this->scode'");  
			$this->bkid = $maxid == 0 ? 1 : $maxid; 
			// $this->pmode = fetch("select id from vdata where vdat = 'cash' and vprop = 'paymodes'");

		}	

		
		
		function refund($f,$t){$i = $t == $this->endterm && $f == $this->endvote ? true : false;if($i){ if($this->amount > 0 ){ process("insert into finance_refunds (adm_no, amount, scode) values ('$this->adm','$this->amount','$this->scode')");error($this->err(4));error( "Kshs.".$this->amount." in refunds");}}return $i;}

		function pay(){
			global $ndk;
			$this->voteheads();
			$this->tvp();
			$this->tvme();
			if(is_array($this->tvp)){
			$j = array_keys($this->tvp); $this->endterm = end($j);
			$k = array_keys($this->voteheads[$this->endterm]);$this->endvote =  fetch("select repdot2('".end($k)."')");
			if(array_sum($this->ydebt) > array_sum($this->ypay)){
			
			if($this->amount > 0){
			
			/* check arrears */
			$arr = $this->arrears();
			
			$inarrears = ($arr > 0) ? true : false;
			
			// spill($arr);
			// die();
			foreach($this->tvp as $term=>$pv){
					$this->received = $this->amount;
					
					$bal = $inarrears ?  $arr : $this->balance($term);
					$payable = $this->amount > $bal ? $bal : $this->amount;
					
					if($payable > 0){
					
					if($inarrears){
						$arrid =  array_keys($this->arrears)[0];
						process("insert into finance_payments (`adm_no`, `term`, `amount`, `bkid`,`pmode`,`bnk`, `bnkc`,`class`,`arrid`,`scode`,`uid`) values ('".$this->adm."','".$term."', '".$payable."', '".$this->bkid."', '".$this->pmode."', '".$this->bnk."', '".$this->bnkc."', '".$this->classs."', '".$arrid."', '".$this->scode."', '".$this->user['id']."')");
					}else{
						process("insert into finance_payments (`adm_no`, `term`, `amount`, `bkid`,`pmode`,`bnk`, `bnkc`, `class`, `scode`,`uid`) values ('".$this->adm."','".$term."', '".$payable."', '".$this->bkid."', '".$this->pmode."', '".$this->bnk."', '".$this->bnkc."', '".$this->classs."', '".$this->scode."', '".$this->user['id']."')");
					}
						
						
					
					$field_id = fetch("select max(id) from finance_payments where scode = '$this->scode'");
					foreach($pv as $a=>$b){
						if($this->amount > 0){
							$vref = $this->tvpx[$term][$a];
							$vbal = $this->voteheads[$term][$vref] - $this->tvme[$term][$vref];
													
							if($vbal > 0){ $this->payslot($vref, $term, $vbal, $field_id);}
							if($this->refund($vref,$term)){ $this->amount = 0; break 2; }
						}else{ break 2;  }
					}
					}
			}
			}
				success($this->err(3));
				$_SESSION[$ndk]['bkdownid'] = $this->bkid;
			}else{ error($this->err(4)); }
			} //else{ error($this->err(5)); }
		}
		
		
		private function payslot($field, $term, $bal, $fid){
			$slotsum = $this->amount > $bal ? $bal : $this->amount ;
			$this->amount = $this->amount > $bal ? ($this->amount - $bal) : 0 ;
			$this->tvme();
			process("update finance_payments set `$field` = '$slotsum' where id = '$fid' and scode = '$this->scode'");
		}
		
		function balance($t=null){
			$b = $this->voteheads();
			$a = $this->tvme();
			if($t == null){
				$i =  array_sum($this->ydebt) - array_sum($this->ypay);}else{
					$yd = isset($this->ydebt[$t])? $this->ydebt[$t] : 0;
					$yp = isset($this->ypay[$t])? $this->ypay[$t] : 0;
					$i =  $yd - $yp;
				}
			return $i;
		}

		
		

		
		function bal_stream(){
			$this->balance();	
			$bdata = [];
			$paid_amts = get("select id, term, amount, arrid from finance_payments ".$this->_asw." and year(date) = year(current_timestamp)");
			foreach($paid_amts as $a=>$b){
				$_paid_amts[$b["id"]] = $b;
			}
			
			$arrears = fetch("select amount from finance_arrears ".$this->_asw." and year(date) = year(current_timestamp)"); 

			foreach($this->terms as $t=>$tt){$bdata[$t] = [];
			foreach($paid_amts as $k=>$l){
				if($l["term"] == $t) $bdata[$t][$l["id"]] = $l["amount"];}}
				
			// spill($bdata);
			$preps = [];
			$rpreps = [];
			foreach($bdata as $t=>$data){
				$amt = isset($this->ydebt[$t])? $this->ydebt[$t] : 0;
				foreach($data as $k=>$d):
					if(is_null($_paid_amts[$k]["arrid"])){
						$bd = $d; $preps[$t][$k] = ($amt - $bd);$amt = $amt - $bd;
					}else{
						$ad = $d;$rpreps[$t][$k] = ($arrears - $ad);$arrears = $arrears - $ad;
					}
				endforeach;
			}
			
			return ["b"=>$preps,"r"=>$rpreps,];
		}
		
		
		
		
		function arrears(){
			$cmb = [];
			// $paid = getlist("
			// select sum(amount) from finance_payments 
			// where adm_no = '".$this->adm."' and `class` = '".$this->classs."' and arrid > 0 group by arrid 
			// ");
			
			$sql = "
			select fa.id, fa.amount, sum(fp.amount) as paid 
			from finance_arrears as fa 
			left join finance_payments as fp on fp.arrid = fa.id  and fp.arrid > 0 and fp.`class` = '$this->classs' and fp.scode = '$this->scode'
			where fa.adm_no = '$this->adm' 
			and fa.arryear < '$this->fyear' 
			group by fp.arrid
			";
			
			// spill($sql);
			$comb = get($sql);
			
			foreach($comb as $k=>$m){
				$cmb[$m["id"]] = $m["amount"] > $m["paid"] ? $m["amount"] - $m["paid"]  : 0;
			}
			
			$this->arrears = $cmb;
			return array_sum($cmb);
		}
		
		
		function acol($arr,$i){
			
		}
		
		
		function voteheads(){
			if(is_null($this->sdata)){error($this->err(1));}else{ 

				$d = $this->voteheadnames();
				$tv = [];
				// spill($d);
				if(empty($d)){error($this->err(2)); }else{
					foreach($this->terms as $t=>$n){ 
						foreach($d as $k=>&$v){
							if($v["term"] == $t){
								$vname = $v['names'];
								$tvs[$t][$v["names"]] = $v["amount"]; 
								$tv[$t][$v["id"]] = $v["amount"]; 
								unset($d[$k]);
							}
							$this->ydebt[$t] = array_sum($tv[$t]);
						}
					}
					$this->voteheads = $tvs;
				}
			}
			
			return $this->voteheads;
		}		
		
		
		function tvp(){
			$tvp = [];$tvpx = [];

				$d = $this->voteheadnames();
				if(!empty($d)){
					foreach($this->terms as $t=>$n){ 
						foreach($d as $k=>&$v){
							if($v["term"] == $t){
								
								$tvp[$t][$v["position"]] = $v["amount"]; 
								$tvpx[$t][$v["position"]] = $v["names"]; 
								unset($d[$k]);
							}
							ksort($tvp[$t]);
						}
					}
				}
			
			$this->tvp = $tvp; $this->tvpx = $tvpx;
			return $this->tvp;
		}
		
		function tvme(){
			$d = $this->voteheadnames();
			$tvme = [];
			if(!empty($d)){
					foreach($this->terms as $t=>$n){ 
						foreach($d as $k=>&$v){
							if($v["term"] == $t){
								$vname = $v['names'];
								$tvme[$t][$v["names"]] = fetch("select sum($vname) from finance_payments ".$this->_asw." and term = '$t' and `class` = '".$this->classs."' and arrid is null and year(date) = year(current_timestamp)"); 
								unset($d[$k]);
							}
							$this->ypay[$t] = array_sum($tvme[$t]);
						}
					}
				}
				$this->tvme = $tvme;
				return $tvme;
		}
		
		function voteheadnames(){
			$sql = "select fvn.id, repdot2(fvn.names) as names, fv.amount, fv.term, fv.position from finance_voteheads as fv left join finance_votehead_names as fvn on fvn.id = fv.votehead where fv.feeclass = '$this->feeclass' and fv.class = '".$this->classs."' and fv.vhyear = '$this->fyear' and fv.scode = '$this->scode'";
			$d =  getlist($sql);
			// spill($d);
			$x= array_column($d,'names');
			// spill($x);
			if( empty($x)) die(error('AT LEAST 2 VOTEHEADS REQIRUED FOR INVOICING'));
			
			if(!empty($d)){
			$zero = array_unique(array_column($d,'names'));	
			
			$this->voteheadnames = array_combine(range(1, count($zero)), array_values($zero));
			
			$this->checkmissing_voteheads();
			$d =  getlist("select fvn.id, repdot2(fvn.names) as names, fv.amount, fv.term, fv.position from finance_voteheads as fv left join finance_votehead_names as fvn on fvn.id = fv.votehead where fv.feeclass = '$this->feeclass' and fv.class = '".$this->classs."' and fv.vhyear = '$this->fyear' and fv.scode = '$this->scode'");
			}
			
			return $d;
		}
		
		function checkmissing_voteheads(){
			$plist = array_column(getlist("describe finance_payments"),'Field');
			$missv = array_diff($this->voteheadnames,$plist);
			foreach($missv as $b){process("alter table finance_payments add `$b` float(10,2) ");}
		}
		
				
		function feeclass(){
			$fcr = fetch("select feeclass from finance_fdata ".$this->_adw." and scode = '$this->scode' and fyear = '$this->fyear'");
			if($fcr == null ){
				$sql = "insert into finance_fdata (`adm_no`, `feeclass`, `class`, `scode`, `fyear`) values('$this->adm','$this->dfc','$this->classs','$this->scode','$this->fyear')";process($sql);
				$fcr = fetch("select feeclass from finance_fdata ".$this->_adw." and class  = '$this->classs' and scode  = '$this->scode' and fyear = '$this->fyear'");
			}
			$testfc = fetch("select count(id) from finance_voteheads where feeclass = '$fcr' and scode = '$this->scode' and vhyear = '$this->fyear' and class= '$this->classs'");
			if(!$testfc){ error($this->err(6)); }
			return $fcr;
		}

		function voteheadslist(){$this->voteheadnames();return $this->voteheadnames;}


		
	}
	