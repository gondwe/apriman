<?php 

/* 2birds 1 stone data-table & forms*/
$sw = isset($_SESSION[$ndk]["route"]) ? $_SESSION[$ndk]["route"] :  $_SESSION[$ndk]["GET"]["t"];

// spill($_GET);
// spill($sw);

function get_types($me){
	global $sid;
	$admin = fetch("select id from user_types where scode= '$sid' and names = 'admin' ");
	return $me == $admin? null : " and id <> $admin";
	
}

switch($sw)
{
	case "users":
		$d->passwords[] = "password";
		$d->hide("thfile,code");
		
		if($_GET["p"] == "new"){ 
			$condition = get_types($_SESSION[$ndk]["user"]["usertype"] );
			$d->combos["usertype"] = "select id, names from user_types where scode = '$sid'" . $condition;} else{ 
			$d->combos["usertype"] = "select id, names from user_types where scode = '$sid'";
		}
		
		$d->aliases(["usertype"=>"user type","username"=>"user name","imagelocation"=>"photo",]);
		$d->pictures("imagelocation");
	break;

	
	case "crud":
		$d->aliases["names"] = "action";
		foreach(getlist("select id, lcase(names) from user_types where scode = '$sid'") as $u):
			$d->combos[$u] = ["0"=>"NO","1"=>"YES",];
		endforeach;
	break;
	case "menugroups":
		$d->combos["names"] = "select id, names from menunames";
	break;
	
	case "finance_voteheads":
		$d->combos["votehead"] = "select id, names from finance_votehead_names  where scode = '$sid'";
		$d->combos["term"] = "select id, vdat from vdata where vprop = 'terms' and xdat = '$sid'";
		$d->combos["account"] = "select id, names from finance_accounts ";
		$d->combos["class"] = "select id, abbr from classes where scode = '$sid'";
		$d->combos["feeclass"] = "select id, names from finance_feeclasses  where scode = '$sid'";
		$d->values["vhyear"]=date("Y");
		$d->readonly("vhyear");
		$d->where["vhyear"] = date("Y");
	break;
	
	case "finance_supplier_payments":
		$d->combos["supplycombo"] = "select id, supply_id from finance_supplies";
		$d->aliases["supplycombo"] = "item";
		$d->editset=false;
		$d->deleteset=false;
		$d->morecols = ["supplier"];
		$d->morecolsdata = ["supplier"=>getlist("select fsp.id, fs.names from finance_supplier_payments as fsp
								right join finance_supplies as fss on fss.id = fsp.supplycombo
								left join finance_suppliers as fs on fs.id = fss.supplier_id
								")];
		
	break;
	case "unlisted":
		$d->combos["names"] = "select id, names from menunames";
	break;
	
	case "finance_supplies":
		$d->combos["supplier_id"] = "select id, names from finance_suppliers where scode = '$sid'";
		$d->aliases["supplier_id"] = "supplier name";
		$d->aliases["supply_id"] = "item";
	break;
	
	case "menusubgroups":
		$d->combos["groupid"] = "select menugroups.id, menunames.names from menugroups left join menunames on menugroups.names = menunames.id";
		$d->combos["subgroupid"] = "select id, names from menunames where id not in (select distinct(names) from menugroups)";
		$d->aliases["groupid"]="group";
		$d->aliases["subgroupid"]="sub group";
	break;

	case "students":
		$d->values["sid"]=$sid;
		$d->where["sid"] = $sid;
		$d->orient = "L";
		$d->combos["class"] = "select id, replace(names,' ','') from classes where scode = '$sid'";
		$d->combos["stream"] = "select id, abbr from streams where scode = '$sid'";
		$d->combos["gender"] = "select id, vdat from vdata where vprop = 'gender'";
		$d->combos["dorm"] = "select id, abbr from dorms where scode = '$sid'";
		$d->pictures[] = "filetoupload";
		$d->aliases["filetoupload"] = "photo";
		$d->aliases["par_contact"] = "tel";
		$d->hide("time_base,dept,idnumber,dorm,student_contact,dob,date_of_completion,image,kcpe,grade,kcpe_year,religion,nationality,idcard,status,year,x,doa");
	break;
	
	case "vote_posts":
		$d->values["sid"]=$sid;
		$d->readonly("sid");
	break;	

	
	case "finance_refunds":
		// $d->values["scode"]=$sid;
		// $d->readonly("scode");
		$d->aliases["refyear"] = "year";
		$d->combos["refyear"] = [(date("Y")-1)=>(date("Y")-1),date("Y")=>date("Y")];
		$d->query = "select fr.id, fr.adm_no, st.names, cl.names as class,  str.names as stream, fr.amount from finance_refunds as fr left join students as st on st.adm_no = fr.adm_no left join classes as cl on st.class = cl.id left join streams as str on str.id = st.stream where st.sid = '$sid'";
	break;	
	
	case "terms":
		$d->aliases["vprop"] ="property";
		$d->aliases["vdat"] ="value";
		$d->values["vprop"]="terms";
		$d->readonly("xdat");
		$d->values["xdat"]=$sid;
		$d->readonly("vprop");
		// $d->hide("property");
		// $d->hide("xdat");
	break;	
	case "finance_payment_modes":
		$d->aliases["vprop"] ="property";
		$d->aliases["vdat"] ="payment mode";
		$d->orient = "p";
		$d->values["vprop"]="paymodes";
		$d->readonly("xdat");
		$d->values["xdat"]=$sid;
		$d->readonly("vprop");
		// $d->readonly("property");
		// $d->hide("vprop");
	break;	
	
	case "finance_banks":
		$d->aliases["vprop"] ="property";
		$d->aliases["vdat"] ="bank";
		$d->values["vprop"]="banks";
		$d->readonly("vprop");
		$d->readonly("xdat");
		$d->values["xdat"]=$sid;
	break;
	
	case "settings":
		$d->hide("pobox,category,date");
		$d->query = "select * from settings where id = '$sid'";
		$d->pictures("sign");
		$d->pictures("logo");
	break;
	
	case "vote_candidates":
		$d->combos["post_id"] = "select id, post_title from vote_posts";
		$d->combos["candidate_id"] = "select adm_no, names from students";
		$d->pictures("photo");
	break;
	
	case "finance_arrears":
		$d->combos["arryear"] = "select year(current_timestamp)-1 as id, year(current_timestamp)-1 as yr";
		$d->aliases["arryear"] = "YEAR";
		if($_GET["p"] == "new" ) { $d->values["adm_no"]= isset($_SESSION[$ndk]["adm_search"]) ? $_SESSION[$ndk]["adm_search"] : null; }
		
	break;
	
	case "staff":
		$d->combos["title"] = "select id, vdat from vdata where vprop = 'title'";
		$d->combos["employer"] = "select id, vdat from vdata where vprop = 'employer'";
		$d->combos["position"] = "select id, names from user_types where names <> 'admin' and `scode` = '$sid'";
		$d->combos["gender"] = "select id, vdat from vdata where vprop = 'gender'";
		$d->ucase("initials,employer");
	break;
	
	case "finance_votehead_names":
		$d->hide("p_order");
	break;
	

}
















switch($_GET["p"])
{
	case "new": if($anchor ==null || count($anchor) == 1)  { $d->newform(); } break;
	case "views":$d->dtable();break;
	case "edit":$d->update();break;
	case "profile":$d->hide("usertype");$d->update();break;
}
