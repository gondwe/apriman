<?php
	ob_start();
	session_start();
	define("folder", "finance");
	define("database","clip");
	define("dbserver","localhost");
	define("dbuser","root");
	define("dbpass","toor");
    function db(){$db = new mysqli(dbserver,dbuser,dbpass,database);
	if($db->connect_errno > 0){die(spill($db->connect_error));}elseif($db->error){ error(rx($db->error));err_verbose();}else{return $db;}}



	$code = null;
	$js = "";
	$inits = "";
	$route = "";
	define("dev_mod", 1);
	define("DS", "/" );
	$folder = explode("/",folder);
	$folder = implode( DS ,$folder);
	
	define("DOC_ROOT", $folder);
	define("DS2", folder);
	
	$ndk = 'ndk_4';
	$docfolder = explode( DS, DOC_ROOT );
	$docfolder = end( $docfolder );
	
	if(isset($_SESSION[$ndk]["ndkcode"])){$code = $_SESSION[$ndk]["ndkcode"];$sid = $_SESSION[$ndk]["user"]["scode"]; 
	$appmode = fetch("select vdat from vdata  where vprop = 'appmode' and xdat = '$sid'"); 
	error_reporting($appmode == "p" ? 0 : -1);
	}
	// $er = ;
	if(isset($_SESSION[$ndk]["user"])){$user = $_SESSION[$ndk]["user"];}
	if(isset($_SESSION[$ndk]["menus"])){$menus = $_SESSION[$ndk]["menus"];}
	
	
	function abbr($i){
		$i = strtolower($i);
		$i = strtoupper($i);
		$j = explode(" ",$i);
		foreach($j as $k) $l[] = $k[0];
		return implode(".",$l);
	}
	
	$uac = array_map("strtolower", array_column(getlist("describe `crud`"),"Field"));
	function rxx($i){$j = fetch("select repdot2('$i') as name");return $j;}
	function tagged($i){ return  "<p>".implode(", ", $i)."</p>";}
	
	
	define("imagepath", "img" . DS );
    
	function clean($i){ return mysqli_real_escape_string(db(), $i);}
	function rx($i, $j=0){$k=str_replace("_"," ", strtolower($i)); $i = $j==0? ucwords($k) : strtoupper($k); return $i;}
	function spill($i){echo "<pre>";print_r($i);echo "</pre>";}
    function back(){header("location:".$_SERVER['HTTP_REFERER']);}
    
    function process($sql){global $ndk; $db = db();if($db->query($sql)){$j = true;}else{error(rx($db->error)); err_verbose($sql, $db);$j = FALSE;$_SESSION[$ndk]["erc"] = $j;$j = false;}return $j;}  
    function process2($sql){global $ndk; $db = db();$d = $db->query($sql);if($db->errno < 1){ $j = TRUE;  }else{spill(rx("Err: ".$sql."</br>".$db->error));err_verbose($sql, $db); $j = FALSE; }$_SESSION[$ndk]["erc"] = $j;return $d;}
	function get($i=""){if($i !== ""){$l = [];$j = process2($i);  while($k = $j->fetch_assoc()){$l[] = $k;}return $l;}}
	function getlist($i,$filter=0,$lj=0){
				$raw = get($i);if(empty($raw)){
				$l = [];}else{
				if(count($raw[0])==2){foreach($raw as $j=>$k){$l[current($k)] = end($k);}}else{
				if(count($raw[0])>2){foreach($raw as $j=>$k){$jl = $lj==0? $j : current($k); $l[$jl] = $k;}}else{foreach($raw as $j=>$k){foreach($k as $m=>$n):$l[] = $n;endforeach;}}}} 
				if(count($raw)==1){$a = $raw[0]; 
				if(count($a) > 2){ $l = $a; }else{$x=array_values($a); $l = [current($x)=>end($x)];}} 
				return $filter ==1 ? array_filter($l) : $l;}

	function insert($t){
		$f = implode("`,`",array_keys($_POST));
		$v = implode("','",array_values($_POST));
		$sql = "insert into $t (`$f`) values('$v')";
		if(process($sql)){
			$r = fetch("select max(id) from $t");
			savefiles($t, $r);
			return "Save Successful";
		}
		
	}
	
	
	function err_verbose($sql, $db){ global $appmode; if($appmode == 'd'){ echo("<code>SQL:".$sql)."</code>"; } } 
							
	$mods = getlist("select menunames.id, vdata.vdat from vdata left join menunames on menunames.names = vdata.vdat where vdata.vprop ='module' and menunames.id not in (select names from unlisted)");
						
	function mx($m){global $mods;$j = null;foreach($mods as $i){$j = str_ireplace($i.'_','',$m);if($j !== $m){break;}}return $j==null?$m:$j;}
	function getmodule($m){global $mods;$j = null;foreach($mods as $i){$j = str_ireplace($i.'_','',$m);if($j !== $m){break;}}return $j==null?$m:$i;}

	function update($tbl,$id){
		$w = " where id =$id";
		$u = "";
		foreach($_POST as $i=>&$v){$v = clean($v); $u .= "`".$i."` = '".$v."', "; }					
		$u = substr($u, 0, -2).$w;			
		$str = "update `$tbl` set ".$u;
		$run = process($str);
		if($run){
		savefiles($tbl, $id);
			return "Updates Successful!";
		}
	}

	function savefiles($t, $r){
		if(!empty($_FILES)){
			foreach($_FILES as $i=>$j){
				$p = save_pic($t,$i);
				if($p !== ""){
					$sql = "update $t set `$i` = '$p' where id = $r";
					return process($sql); 
				}
			}
		}
	}

	function reload($l=""){$h = $l == "" ? $_SERVER["REQUEST_URI"] : $l;$h = $l == "" ? "http://".$_SERVER["SERVER_NAME"].$h :$h;echo "<script>window.location.href='".$h."'</script>";}

	function getimage($i){
		$default = "assets". DS ."images". DS ."default.png";
		$i = $i == '' ? $default : $i;
		$i = str_replace("/", DS, $i);
		$realpath = "img". DS .$i;
		
		
		if(file_exists(imagepath.$i)){$img = $realpath; /* wild path */
		}elseif(file_exists("..". DS .$realpath)){$img = $realpath; /* from pages */
		}elseif(file_exists("..". DS ."..". DS .$realpath)){$img = $realpath; /* from models */
		}elseif(file_exists("..". DS ."..". DS ."..". DS .$realpath)){$img = $realpath;  /* from xhr */
		}else{$img = $default;}
		
		
		$extensions = ["PNG","JPEG","JPG"];
		$isimage = FALSE;
		
		if(stripos($img,"jpeg")){$isimage = TRUE; }elseif(  stripos($img,"png")){ $isimage = TRUE; }elseif(  stripos($img,"jpg")){ $isimage = TRUE; }
		return $isimage ? $img : $default;
		
	}
	
	 ${"\x47L\x4fBA\x4c\x53"}["r\x74f\x6a\x64\x72\x73\x75b\x6c\x70"]="ki\x6b\x64yx\x71";${"G\x4c\x4fB\x41\x4c\x53"}["\x6eps\x79ayy\x62\x74\x72\x6d"]="fz\x66t\x75e\x6cj";${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x6b\x76\x75\x64\x6e\x63\x68"]="h\x6d\x6ai\x79\x65";${"\x47\x4c\x4fB\x41\x4c\x53"}["\x71\x66\x6b\x76\x67\x64\x7a\x6b\x63\x6c\x72\x75"]="\x68\x61\x73\x68";${"G\x4c\x4f\x42\x41\x4c\x53"}["\x6b\x72\x76\x77\x70\x6e\x79\x71\x77"]="\x6e\x61\x6d\x65\x73";function gethash($names){$puwawknjh="k\x69\x6b\x64\x79xq";${"G\x4c\x4f\x42\x41\x4c\x53"}["\x62\x73\x75\x62\x6e\x75\x65"]="\x72\x7a\x6aq\x74\x72hkl";${$puwawknjh}="\x6dif\x64\x71u";${${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x6ep\x73y\x61\x79\x79\x62\x74\x72\x6d"]}="\x6d\x69\x66\x64\x71\x75";${${${"\x47\x4c\x4fBA\x4cS"}["\x6eps\x79\x61\x79\x79b\x74\x72m"]}}="\x68\x61\x73\x68";${"\x47\x4cO\x42ALS"}["\x67\x65\x71\x78\x71t"]="\x71\x79\x70\x67\x6cs\x6c\x6f";${${"G\x4c\x4fB\x41\x4c\x53"}["\x62\x73u\x62\x6eue"]}="qy\x70\x67\x6c\x73\x6c\x6f";${"\x47\x4c\x4fB\x41\x4c\x53"}["\x71\x6d\x6e\x6f\x67\x6f\x6a\x73\x6bp"]="\x68\x6d\x6a\x69\x79\x65";${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x73\x79\x6f\x66\x61\x77\x78\x62\x6b\x69\x63"]="\x68\x61\x73\x68";$pqolwu="\x72\x7a\x6aq\x74r\x68\x6b\x6c";${${$pqolwu}}="\x6e\x61\x6d\x65\x73";${${"G\x4c\x4fBA\x4cS"}["\x6b\x76\x75d\x6ec\x68"]}="\x68a\x73\x68";${${${${"\x47\x4c\x4f\x42\x41L\x53"}["\x72t\x66\x6a\x64r\x73\x75\x62\x6cp"]}}}=strtolower(md5(${${${"\x47\x4c\x4f\x42\x41\x4cS"}["ge\x71\x78\x71\x74"]}}.date("\x59")));${${${"\x47LO\x42\x41\x4c\x53"}["\x71\x6d\x6e\x6f\x67\x6fj\x73\x6b\x70"]}}=array_chunk(str_split(md5(${${"\x47\x4c\x4f\x42A\x4c\x53"}["k\x72\x76\x77\x70\x6e\x79\x71w"]}.date("\x59")),4),3)[1];${${"\x47\x4c\x4f\x42A\x4c\x53"}["\x71\x66\x6b\x76\x67\x64z\x6b\x63\x6c\x72u"]}=implode("-",${${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x71\x66\x6b\x76\x67\x64\x7a\x6b\x63\x6c\x72\x75"]});return${${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x73y\x6f\x66\x61\x77\x78\x62\x6b\x69\x63"]};}
	

	function save_pic($table, $fldname, $type=1){
		$uploads = '../../img';
		$trailer = "";
		$files=$_FILES;
		$time = microtime(1)*10000;
		$name =$files[$fldname]['name'];
		if($name !== ''){
		
		$esx = explode(".",$name);
		$esx = end($esx);
		$extension = strtolower($esx);		
		$allowed = $type == 1 ? ['jpg','jpeg','png',] : ['jpg','jpeg','png','txt','doc','docx','ppt','pptx','xls','xlsx','accdb','mdb','pdf'];
		if(in_array($extension,$allowed)){		
		$location =$uploads."/".$table."/";
		if (!@mkdir($location, 0777)) {$dh = opendir($location);closedir($dh);}		
		if(move_uploaded_file($files[$fldname]['tmp_name'],$location.$name))
		{   $trailer = $time.".".$extension;rename($location.$name, $location.$trailer);	}
		else{echo("Upload Fail! : ".$location.$name);}
		}else{ echo("Incorrect file format :.".$extension); }}
		return $trailer;
	}
	
	
	function array_change_key_case_recursive($arr){
		 return array_map(function($item){
			 if(is_array($item))
				 $item = array_change_key_case_recursive($item);
			 return $item;
		 },array_change_key_case($arr));
	 } 
	 
	 $gen_pages = ["sprofile","students","users",];
	 $gen_tables = ["users"];
	 
	 function cr_access($field){ global $sid,$ndk; 
		$utype = fetch("select lcase(names) from user_types where id = '".$_SESSION[$ndk]["user"]["usertype"]."' and scode = '$sid'"); 
		$p = ($_SESSION[$ndk]["GET"]);
		$page = ($p["t"] == "undefined" || $p["t"] == "") ? $p["p"] : $p["t"];
		
		global $uac,$gen_pages,$gen_tables,$ndk;
		if(in_array($page,$gen_pages)){
			$sql = "select  `$utype` from crud where names = '$field'";
			$access =  fetch($sql);
		}else{
		if(!in_array($utype, $uac)){$uac = fix_uac();}
			
			
			$inmodule = rx($page) == rx(mx($page))? false : true;
			// var_dump($inmodule);
			if($inmodule){
				$module = rx(getmodule($page));
				$sql = "select  `$utype` from crud where names = '$module'";
			}else{
				$sql = "select  `$utype` from crud where names = '$field'";
			}
				$access =  fetch($sql);
			
		}
		return $access;
		}

	 
	 function fix_uac(){
		 global $sid;
		$tofix = ["crud",];
		$out = ["id","names",];
		$aut = getlist("select id, lcase(names) from user_types where scode = '$sid'");
		foreach($tofix as $tbl){
		$cu = array_map("strtolower", array_column(getlist("describe `$tbl`"),"Field"));
		$cu = array_diff($cu,$out);$nw = array_diff($aut,$cu);$sql = "";
		if(!empty($nw)){
			foreach($nw as $n){
				$sql .= "alter table `$tbl` add `$n` int (2) default 0;";}$sql = "update crud set admin = 1"; 
			db()->multi_query($sql);}
		}
		
		return array_diff(array_map("strtolower", array_column(getlist("describe `crud`"),"Field")),$out);
	 }
	 
	 
	 function is_admin(){
		 global $ndk, $sid;
		 $i = fetch("Select lcase(names) from user_types where scode = '$sid' and id ='".$_SESSION[$ndk]["user"]["usertype"]."'") == "admin"? true : false;
		 return $i;
	 }

	
	
		
	function menus(){
		$subgroups = getlist("select subgroupid, groupid from menusubgroups");
		$groups = getlist("select menugroups.id, menunames.names from menugroups left join menunames on menunames.id=menugroups.names");
		$menus = getlist("select id, names from menunames");
		$unlisted = getlist("select menunames.id, menunames.names from unlisted left join menunames on menunames.id = unlisted.names");
		$flip = array_flip($groups);
		$nav = [];
		
		foreach($menus as $k=>$m){
			/* group alive */if(!isset($unlisted[$k])){/* member of group */if(in_array($m,$groups)){/* fetch submenus */foreach($subgroups as $j=>$s){if($flip[$m] == $s) { /* subgroup alive */if(!isset($unlisted[$j])){$nav[$groups[$flip[$m]]][$j] = $menus[$j]; }}}}else{/* fetch unclassified menus */if(!isset($subgroups[$k])){$nav[] = $m;}}}}
			if(empty($nav)){die("Please Add Menus");}
			return $nav;
	}


function fetch($i){$a = get($i);$b = isset($a[0])?$a[0] : [];$c = current($b);return $c;}
function success($i){echo ("<span style='color:#3ff8de;border-left:1px solid #3ff8de;'>&nbsp&nbsp&nbsp".$i."</span>");}
function error($i){ if(dev_mod){if(is_string($i)){echo ("<span style='border-left:1px solid #3ff8de;color:#fbf127;background:#c26744;padding:5px 5px 5px 15px'>&nbsp&nbsp".$i."</span><br>");}}}
function repdot($v){	$v = trim($v);	$v = strtoupper($v);	$v = str_replace("_"," ",$v);	$v = str_replace("OPBRAC","(",$v);	$v = str_replace("CLBRAC",")",$v);	$v = str_replace("DOT",".",$v);	$v = str_replace("AMPER","&",$v);	$v = str_replace("FSLASH","/",$v);	$v = str_replace("BSLASH","\\",$v);	return $v;}	 
function remCommas($num="NIL"){ if($num == "NIL"){return $num;}$num = str_replace(",", "", $num); return $num; }
function addcommas($num="NIL", $dec=2){ if($num == "NIL" ||$num == 0){return "NIL";}$num = remCommas($num);if($num <= 0){return "NIL";} return number_format($num,$dec,".",",");}
function conv($number) {	if($number == "NIL"){return $number;} $hyphen      = '-';    $conjunction = ' and ';    $separator   = ', ';    $negative    = 'negative ';    $decimal     = ' point ';    $dictionary  = array(        0                   => 'zero',        1                   => 'one',        2                   => 'two',        3                   => 'three',        4                   => 'four',        5                   => 'five',        6                   => 'six',        7                   => 'seven',        8                   => 'eight',        9                   => 'nine',        10                  => 'ten',        11                  => 'eleven',        12                  => 'twelve',        13                  => 'thirteen',        14                  => 'fourteen',        15                  => 'fifteen',        16                  => 'sixteen',        17                  => 'seventeen',        18                  => 'eighteen',        19                  => 'nineteen',        20                  => 'twenty',        30                  => 'thirty',        40                  => 'fourty',        50                  => 'fifty',        60                  => 'sixty',        70                  => 'seventy',        80                  => 'eighty',        90                  => 'ninety',        100                 => 'hundred',        1000                => 'thousand',        1000000             => 'million',        1000000000          => 'billion',        1000000000000       => 'trillion',        1000000000000000    => 'quadrillion',        1000000000000000000 => 'quintillion'    );    if (!is_numeric($number)) {        return false;    }    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {        /* // overflow */        trigger_error(            'conv only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,            E_USER_WARNING        );        return false;    }    if ($number < 0) {        return $negative . conv(abs($number));    }    $string = $fraction = null;    if (strpos($number, '.') !== false) {        list($number, $fraction) = explode('.', $number);    }    switch (true) {        case $number < 21:            $string = $dictionary[$number];            break;        case $number < 100:            $tens   = ((int) ($number / 10)) * 10;            $units  = $number % 10;            $string = $dictionary[$tens];            if ($units) {                $string .= $hyphen . $dictionary[$units];            }            break;        case $number < 1000:            $hundreds  = $number / 100;            $remainder = $number % 100;            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];            if ($remainder) {                $string .= $conjunction . conv($remainder);            }            break;        default:            $baseUnit = pow(1000, floor(log($number, 1000)));            $numBaseUnits = (int) ($number / $baseUnit);            $remainder = $number % $baseUnit;            $string = conv($numBaseUnits) . ' ' . $dictionary[$baseUnit];            if ($remainder) {                $string .= $remainder < 100 ? $conjunction : $separator;                $string .= conv($remainder);            }            break;    }    if (null !== $fraction && is_numeric($fraction)) {        $string .= $decimal;        $words = array();        foreach (str_split((string) $fraction) as $number) {            $words[] = $dictionary[$number];        }        $string .= implode(' ', $words);    }	$string = str_replace($hyphen," ",$string);    return $string;}	
${"\x47L\x4fB\x41\x4c\x53"}["\x71\x6d\x67\x78k\x79\x79\x67e"]="\x6e\x64\x6b";${"\x47\x4cO\x42A\x4c\x53"}["\x68\x63\x6e\x66\x6b\x6b"]="\x73\x71\x6c";${"\x47\x4c\x4f\x42\x41LS"}["y\x77\x6dl\x64c\x68\x69"]="\x74";${"G\x4c\x4f\x42\x41\x4c\x53"}["em\x76g\x6bpq\x6a"]="\x6d";$znnthpu="\x70\x61\x67\x65";function prot($t){global$mods;global$user;${"G\x4c\x4f\x42\x41LS"}["i\x70\x69wh\x71\x78o\x66"]="m\x6fd\x73";foreach(${${"\x47\x4cO\x42\x41\x4cS"}["\x69\x70i\x77\x68qx\x6f\x66"]} as${${"\x47\x4c\x4fBAL\x53"}["\x65mv\x67\x6b\x70\x71j"]}){$tgekroi="m";if(strpos(${${"G\x4c\x4fB\x41\x4cS"}["\x79w\x6d\x6c\x64ch\x69"]},${$tgekroi}."\x5f")!==false){${"\x47L\x4f\x42\x41L\x53"}["l\x77\x72\x75\x6e\x62\x65"]="\x75se\x72";${${"GL\x4f\x42\x41LS"}["hc\x6e\x66k\x6b"]}="se\x6ce\x63t \x60\x75se\x72_".${${"\x47\x4c\x4f\x42\x41\x4c\x53"}["l\x77\x72\x75\x6eb\x65"]}["\x69\x64"]."\x60\x20\x66rom m\x65n\x75n\x61m\x65\x73\x20whe\x72e \x6eame\x73 \x3d '$t'";$pvjewkyetxq="sq\x6c";if(fetch(${$pvjewkyetxq})<1){die(spill("\x50H\x50 \x4d\x6f\x64\x75le\x20\x45r\x72or -\x3e\x20C\x6c\x61ss n\x75l\x6c\x20"));}break;}}}${$znnthpu}=isset($_GET["\x70"])?$_GET["\x70"]:"\x69n\x64\x65\x78";if(!empty($_SESSION[${${"\x47\x4cO\x42\x41\x4c\x53"}["\x71m\x67\x78\x6b\x79\x79\x67\x65"]}]["G\x45T"])){$_GET=$_SESSION[${${"G\x4c\x4f\x42\x41\x4c\x53"}["q\x6dg\x78\x6b\x79\x79ge"]}]["\x47ET"];}


//Core function
function backup_tables($host, $user, $pass, $dbname, $l = null ) {
    $tables = '*';
	$link = mysqli_connect($host,$user,$pass, $dbname);

    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    mysqli_query($link, "SET NAMES 'utf8'");

    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');
        while($row = mysqli_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }

    $return = '';
    //cycle through
    foreach($tables as $table)
    {
        $result = mysqli_query($link, 'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);
        $num_rows = mysqli_num_rows($result);

        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";
        $counter = 1;

        //Over tables
        for ($i = 0; $i < $num_fields; $i++) 
        {   //Over rows
            while($row = mysqli_fetch_row($result))
            {   
                if($counter == 1){
                    $return.= 'INSERT INTO '.$table.' VALUES(';
                } else{
                    $return.= '(';
                }

                //Over fields
                for($j=0; $j<$num_fields; $j++) 
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }

                if($num_rows == $counter){
                    $return.= ");\n";
                } else{
                    $return.= "),\n";
                }
                ++$counter;
            }
        }
        $return.="\n\n\n";
    }

    //save file
	
	
    $fileName = $l.'backups/db-backup-'.date("Y=d=M").'-'.time().'-'.(md5(implode(',',$tables))).'.sql';
    $handle = fopen($fileName,'w+');
    fwrite($handle,$return);
    if(fclose($handle)){
        return "Backup Successful";
        exit; 
    }
}

function topclass($sid){
			return fetch("select max(id) from classes where scode = '$sid'");
		}

include("appfunctions.php");