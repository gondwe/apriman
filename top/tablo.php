

<?php 

class tablo {
	protected $db;
	protected $table;
	protected $data;
	protected $columns;
	protected $cbodata;
	protected $id;
	private $types = 
	[
		3=>"number",
		253=>"text",
		252=>"textarea",
	];	
	
	public $query;
	public $where;
	public $combos;
	public $aliases ;
	public $pictures = [];
	public $passwords = [];
	public $ucase = [];
	public $disabled=[];
	public $values=[];
	public $readonly=["sid","scode"];
	public $optional=[];
	public $hide = ["id","date","password",];
	
	
	public $editset;
	public $deleteset;
	protected $custom;
	public $morecols = [];
	public $morecolsdata = [];
	public $orient = "P";
	public $addnew = true;
	
	
	private $canadd;
	private $canedit;
	private $candelete;
	
	function __construct($i, $id=null, $qrs=null){
		global $ndk;
		$this->db = db();
		$this->table = $i;
		$this->id = $id;
		$this->query = $qrs;
		$this->scoding($i);
		$_SESSION[$ndk]['GET']['t'] = $i;
		$_SESSION[$ndk]['GET']['i'] = $id;
		$_SESSION[$ndk]["thead"] = rx($i);
		$this->editset = $qrs==null? true :false;
		$this->deleteset = $qrs==null? true :false;
		$this->canedit = cr_access("update");
		$this->candelete = cr_access("delete");
		$this->canadd = cr_access("add");
		$this->canview = cr_access("views");
	} 
	
	function scoding($me){
		global $sid;
		$roaming_tables = 
		[
			"settings",
			"unlisted",
			"menunames",
			"menugroups",
			"menusubgroups",
			"students",
			"vote_candidates",
			"crud",
			"vdata",
		];
		$excempted = (in_array($me, $roaming_tables)) ? false : true;
		if($excempted){ 
		$this->values["scode"] = $sid;	
		$this->where["scode"] = $sid;	
		}
	}
	
	public function newform()
	{

	$operation  = $this->realid($this->id) == null ? $this->canadd : $this->canedit;
	if($operation){
		$this->data =  $this->get();
	if(!empty($this->columns)){
		$xhrpage = $this->realid($this->id) == null ? "insertdata.php" : "savedata.php";
		echo "<form id='".$this->table."_form"."' class='form-horizontal' role='form' name='$this->table' action='$xhrpage' method='POST' enctype='multipart/form-data'>";
		foreach ($this->columns as $i=>$j)
		{
			if(!in_array($j->name,$this->hide)){
				echo "<div class='form-group'>";
					$this->label($j->name,$j->type);
					$this->input($j->name,$j->type);
				echo "</div>";
			}
		}
	}
	
	$this->getsubmit($this->realid($this->id));
	}else{
		error("N?A Module Access Error");
	}
		
		echo "</form>";
	
	}
	
	
	public function dtable($new=1){ 
		$this->data =  $this->get($this->query);
		$this->gettable($new);
	}
	
	function update(){$this->newform();}
	private function label($i,$j) { if(!in_array($i, $this->readonly)){ $i = isset($this->aliases[$i])? $this->aliases[$i] : $i; echo("<label class='col-sm-2 control-label'>".rx($i,1)."</label>"); } }	 
	private function getsubmit($i){echo("<div  class='form-group' ><div  class='col-sm-2' ></div><div  class='col-sm-9' ><input type='submit' id='submitbtn' class=' btn btn-sm btn-success pull-right' value='SAVE'></div></div></div>");}
		
	private function input($i,$j)
	{
		echo "<div class='col-sm-9'>";
		if(isset($this->combos[$i])){
			$this->getcombos($i);
		}elseif(in_array($i,$this->pictures)){
			$this->uploader($i);
		}else{
			$required = in_array($i, $this->optional)? null : "required";
			$disabled = in_array($i, $this->disabled)? "disabled" : null;
			$type =  in_array($i, $this->passwords)? "password" : (in_array($i, $this->readonly)? "hidden"  : (isset($this->types[$j])? $this->types[$j]: "text"));
			$value = isset($this->values[$i])? $this->values[$i] : (($this->realid() == null) ? null : $this->data[0][$i]);
			$otag = $type == "textarea" ? "textarea" : "input";$ctag = $type == "textarea" ? "</textarea>" : null;
			if($type == "textarea"){ $ctag = $value.$ctag; $value = null; }
			echo("<$otag id='form-field-11' value='$value' class='form-control' $required  type='$type' name='".$i."' >".$ctag);
		}
		echo "</div>";
	}
	
	
	
	function getcombos($i)
	{
		$a = $this->cbodata($i);
		$k = $this->id  == null ? $this->getSelection($i) : $this->data[0][$i];
		echo("<select id='form-field-select-1' class='form-control' name='".$i."' >");
			foreach($a as $b=>$c){
				$selected = $k == null ? null : ($k == $b ? "selected=TRUE" : null);
				echo "<option $selected value='$b'>".rx($c,1)."</option>";
			}
		echo("</select>");
		
	}
	
	
	public $kselected=[];
	public $vselected=[];
	
	function getSelection($i){
		$i = strtolower($i);
		return isset($this->vselected[$i])?  $this->vselected[$i] : ( isset($this->kselected[$i])?  $this->kselected[$i] : null);
	}
	
	
	private function cbodata($i)
	{
		$j =  $this->cbodata[$i] = is_array($this->combos[$i])?  $this->combos[$i] : getlist($this->combos[$i]);
		return $j;
	}
	
	public function hide($i){$a = explode(",",$i);foreach($a as $b){$this->hide[] = $b;}}
	public function readonly($i){$a = explode(",",$i);foreach($a as $b){$this->readonly[] = $b;}}
	public function values($i){$a = explode(",",$i);foreach($a as $b){$this->values[] = $b;}}
	public function disabled($i){$a = explode(",",$i);foreach($a as $b){$this->disabled[] = $b;}}
	public function pictures($i){$a = explode(",",$i);foreach($a as $b){$this->pictures[] = $b;}}
	public function optional($i){$a = explode(",",$i);foreach($a as $b){$this->optional[] = $b;}}
	public function ucase($i){$a = explode(",",$i);foreach($a as $b){$this->ucase[] = $b;}}
	public function aliases($i){foreach($i as $a=>$b){$this->aliases[$a] = $b;}}
	public function where($i){foreach($i as $a=>$b){$this->aliases[$a] = $b;}}
	
	function uploader($i){
		$v = $this->id == null ? "" : $this->data[0][$i];
		if($this->id !== null){
			// spill($this->table. DS .$v);
			echo "<img class='col-sm-2' style='max-width:150px' src = '".getimage($this->table. DS .$v)."' >";
		}
		echo("<input class='btn btn-default' value='$v' type='file' name='".$i."' />");}
	
	function getwh(){
		$where = strpos($this->id,'=') !== false? ' where '.$this->id : " where id = ".$this->id;
		$where = $this->id == null ? null : $where;
		$ww = [];
		$www = '';
		// spill($this->where);
		if(!empty($this->where)){
			$wv = $where == null ? " where " : " and ";
			foreach($this->where as $k=>$v){$ww[] = $k." = '".$v."' ";}
			$www = $wv.implode(" and ",$ww);
		}
		// $ww;
		return $where.$www;
	}

	function realid(){
		$w =  $this->id == null ? null : $this->id;
		$w =  strpos($w,'=') !== false? null : $this->id;
		return $w;
	}

	protected function get($custom = null)
	{
		$w = $this->getwh();
		$sql = is_null($custom) ? "select * from ".$this->table.$w : $custom;
		$l = [];$lk = [];
		if($j = $this->db->query($sql)){
		if($j = $this->db->query($sql)){while($k = $j->fetch_assoc()){$l[] = $k;}$this->columns = $j->fetch_fields();	}
		if($j = $this->db->query($sql)){while($k = $j->fetch_object()){$lk[] = $k;}$this->columns = $j->fetch_fields();	}
		$this->dataobj = $lk;
		foreach($this->columns as &$a){$a->name = strtolower($a->name);}
		$l = array_change_key_case_recursive($l);
		}else{	error(rx($this->db->error));}
		
		// spill($this->hide);
		return $l;
	}
	

	function gettable($new)
	{
		
		if($this->canview){
		$haliases = [$this->pictures]; 
		$a = [];
		foreach($haliases as $ha){foreach($ha as $h){if(isset($this->aliases[$h])){$a[] = $this->aliases[$h];}}}
		
		// spill($a);
		
		$viewhidden = explode(",","scode,sid,vhyear,sign,logo,xdat") ;
		$viewhidden = array_merge($viewhidden,$a, $this->pictures);
		// spill($this->aliases);
		// spill($viewhidden);
		
		// die();
		global $route;
		if(!empty($this->columns)){
		foreach($this->columns as $b){
			if(!in_array($b->name,$this->hide) && !in_array($b->name,$this->passwords)){ $th[] = isset($this->aliases[$b->name])? $this->aliases[$b->name] :$b->name ; }
		}
		

		if(!empty($this->combos)){
			foreach($this->combos as $i=>$k){
				$this->cbodata($i);
			}
		}
		
		
		$th = array_diff( $th, $viewhidden);
		?>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12 space20">
				<?php if($new == '1'){ ?>
				<?php if($this->canadd && $this->addnew ){ ?>
					<a href="#new/<?=$route == '' ? $_GET["t"] : $route ?>" class="btn btn-xs btn-orange">
						Add New <i class="fa fa-plus"></i>
					</a>
				<?php } ?>
					<div class="btn-group pull-right">
						<?php printA4("sample-table-2",$this->orient)?>
						<button data-toggle="dropdown" class="btn btn-green dropdown-toggle">Export <i class="fa fa-angle-down"></i></button>
						<ul class="dropdown-menu dropdown-light pull-right">
							<!-- <li><a href="#" class="export-pdf" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Save as PDF </a></li> -->
							<li><a href="#" class="export-excel" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Export to Excel </a></li>
							<li><a href="#" class="export-doc" data-table="#sample-table-2" data-ignoreColumn ="3,4"> Export to Word </a></li>
						</ul>
					</div>
				<?php }	 ?>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover" id="sample-table-2">
					<thead>
						<tr>
							<?php foreach($th as $a):?>
								<th><?=rx($a)?></th>
							<?php endforeach;?>
							<?php if($this->canedit){if($this->editset){ ?><th class='hidden-print'>Edit</th><?php }} ?>
							<?php if($this->candelete){if($this->deleteset){ ?><th class='hidden-print'>Delete</th><?php }} ?>
							
							<!--additional fake columsn / contingency-->
							<?php if(!empty($this->morecols)){foreach($this->morecols as $c){ echo"<th>".(rx($c))."</th>"; }} ?>

							
						</tr>
					</thead>
					<tbody>
					<?php //$tdata = $new == '1' ? $this->data : $this->get($new) ?>
					<?php $tdata = $this->data ?>
					<?php foreach($tdata as $k=>$tr):?>
						<tr id='row<?=$tr["id"]?>'>
					<?php foreach($tr as $b=>$c): ?>
					<?php if(!in_array($b,$this->hide) && !in_array($b,$viewhidden) && !in_array($b,$this->passwords)){?>
							<?php $case = in_array($b,$this->ucase)? 1 : 0; ?>
							<td><?php echo isset($this->combos[$b])? rx((isset($this->cbodata[$b][$c])? $this->cbodata[$b][$c] : null),$case) : rx($c,$case) ?></td>
					<?php } endforeach; ?>
					<?php 
							if(!empty($this->morecols)){
							foreach($this->morecols as $cc){
								echo "<td>";
								if(!empty($this->morecolsdata)){echo isset($this->morecolsdata[$cc][$tr["id"]]) ? $this->morecolsdata[$cc][$tr["id"]] : null;}
								echo "</td>";
							}}
					?>
					<?php if($this->canedit){ if($this->editset){ ?><td  class='hidden-print'><a href='javascript:void()' onclick="eds('#edit/<?=$this->table?>/<?=$tr["id"]?>')"> Edit </a></td><?php }} ?>
					<?php if($this->candelete){ if($this->deleteset){ ?><td  class='hidden-print'><a href='javascript:void()' onclick="del('#delete/<?=$this->table?>/<?=$tr["id"]?>','<?=$tr["id"]?>')"> Delete </a></td><?php }} ?>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
							
		<?php
	}
	}else{
		error("N?A Module Access Error");
	}
	}

}



?>
		<script>
			jQuery(document).ready(function() {
				TableExport.init();
			});
		</script>