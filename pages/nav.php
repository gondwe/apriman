<?php 

/* shortcut routes */



$_SESSION[$ndk]["tablo"] = $t;

switch($_GET["t"]){
	case "exams_examslist"; $tbl = "exams_new"; break;
	default : $tbl = $_GET['t'] == "undefined" ? $_GET["p"] : $_GET['t'] ; break;
}

// spill($tbl);

switch($tbl){
	case "usertypes":inmenu(["views/users",]);break;
	case "users":inmenu(["new/user_types",]);break;
	case "menugroups":inmenu(["new/menusubgroups","new/menunames",]);break;
	case "menunames":inmenu(["new/menusubgroups","new/menugroups"]);break;
	case "menusubgroups":inmenu(["new/menunames","new/menugroups",]);break;
	case "exams_exam_sheets":inmenu(["mark_sheets","correction_sheets",]);break;
	case "user_types":inmenu(["new/users",]);break;
	case "finance_voteheads":inmenu(["new/finance_settings","new/finance_feeclasses","new/finance_votehead_names","new/finance_accounts",]);break;
	case "finance_accounts":inmenu(["new/finance_voteheads"]);break;
	case "finance_votehead_names":inmenu(["new/finance_voteheads",]);break;
	case "finance_payments":inmenu(["new/finance_arrears","new/receipts","new/finance_stats",]);break;
	case "receipts":inmenu(["new/finance_payments"]);break;
	case "finance_arrears":inmenu(["new/finance_payments","new/finance_books"]);break;
	case "finance_stats":inmenu(["new/finance_payments","new/finance_banks","new/finance_balances",]);break;
	case "finance_banks":inmenu(["new/finance_payments","new/finance_payment_modes"]);break;
	case "finance_payment_modes":inmenu(["new/finance_payments","new/finance_banks"]);break;
	case "settings":inmenu(["new/student_settings"]);break;
	case "finance_cashbook":inmenu(["finance_ledger","new/finance_books",]);break;
	case "finance_ledger":inmenu(["finance_cashbook","new/finance_books",]);break;
	case "finance_fee_structure":inmenu(["new/finance_books",]);break;
	
	case "students":inmenu(["new/classes","new/streams",]);break;
	case "dorms":inmenu(["new/streams","new/classes",]);break;
	case "streams":inmenu(["new/dorms","new/classes",]);break;
	case "classes":inmenu(["new/dorms","new/streams",]);break;
	case "student_settings":inmenu(["new/settings",]);break;
	// case "finance_expenses":inmenu(["new/finance_suppliers",]);break;
	case "finance_suppliers":inmenu(["new/new_supply","new/finance_expenses"]);break;
	case "finance_expenditure_names":inmenu(["new/finance_expenses",]);break;
	case "finance_expenditure_cashbook":inmenu(["new/finance_books","finance_expenditure_ledger",]);break;
	case "finance_expenditure_ledger":inmenu(["new/finance_books","finance_expenditure_cashbook"]);break;
	case "finance_trial_balance":inmenu(["new/finance_books"]);break;
	case "finance_fees_register":inmenu(["new/finance_books"]);break;
	case "finance_balances":inmenu(["new/finance_books"]);break;
	case "finance_refunds":inmenu(["new/finance_books"]);break;
	case "finance_supplies":inmenu(["new/finance_expenses"]);break;
	case "finance_feeclasses":inmenu(["new/finance_voteheads"]);break;
}


// echo "<div style='clear:both;float:none; border-bottom:1px solid red'>line</div>";