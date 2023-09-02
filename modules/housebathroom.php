<?php

require_once("common.php");

function housebathroom_getmoduleinfo() {
	$info = array(
		"name"=>"House Rooms - Bathroom",
		"author"=>"`!Rowne-Wuff Mastaile/`3Lonny Luberts",
		"version"=>"2.56",
		"category"=>"House System",
		"download"=>"http://www.pqcomp.com/modules/mydownloads/visit.php?cid=3&lid=48",
		"settings"=>array(
			"toiletname"=>"The brand of toilet:|MusteliCo MusTEK",
		),
		"requires"=>array(
			"odor"=>"1.4|By `#Lonny Luberts",
			"bladder"=>"1.3|By `#Lonny Luberts",
			"houserooms"=>"2.5|By `!Rowne-Wuff Mastaile/`3Lonny Luberts",
		),
	);
	return $info;
}

function housebathroom_install() {
	module_addhook ("roomsdefines");
	module_addhook ("housenavs");
	module_addhook ("bathroomcontents");
	$sql		= "SELECT acctid FROM ".db_prefix("accounts");
	$result	= db_query($sql);
	$row		= db_fetch_assoc($result);

	for ($i=0;$i<db_num_rows($result);$i++){
		set_module_pref ("bathroomfull", 1, "houserooms", $row['acctid']);
		set_module_pref ("bathroomnavs", 1, "houserooms", $row['acctid']);
	}

	output ("`^Doing a check on your preferences to ensure that a successful install has been made ...", $row2['name']);

	if (!get_module_pref ("bathroomfull", "houserooms")) {
		output ("`n");
		output ("`\$ERROR: `7Go and pester Rowne about it.");		
		output ("`n");
		return false;
	}
	
	elseif (get_module_pref ("bathroomfull", "houserooms")) {
		output ("`n");

		if (is_module_active ("housebathroom")) {
			output ("`2SUCCESS: `7The module has been updated successfully.");
		}
		
		else {
			output ("`2SUCCESS: `7The module has been installed successfully.");
		}

		output ("`n");
		return true;
	}
}

function housebathroom_uninstall() {
	$sql		= "SELECT acctid FROM ".db_prefix("accounts");
	$result	= db_query			($sql);
	$row		= db_fetch_assoc	($result);

	for ($i=0;$i<db_num_rows($result);$i++){
		set_module_pref ("bathroomfull", 0, "houserooms", $row['acctid']);
		set_module_pref ("bathroomnavs", 0, "houserooms", $row['acctid']);
	}

	output ("`&");
	output ("Just a quick note ...");
	output ("`6");
	output ("If you see a dupe of installation procedure above, don't panic.");
	output ("It's simply the way the uninstaller works, it seems to reinstall");
	output ("before uninstalling, which means that any checks the installer");
	output ("makes are made before uninstalling, of course, as the uninstall");
	output ("hasn't been processed yet, those checks would prove correct as if");
	output ("they were made at the time of the installation. You should only");
	output ("worry if one or the above reports an error.");
	output ("`n");

	output ("`^Doing a check on your preferences to ensure that a successful uninstall has been made ...", $row2['name']);

	if (get_module_pref ("bathroomfull", "houserooms")) {
		output ("`n");
		output ("`$ERROR: `7Go and pester Rowne about it.");		
		output ("`n");
		return false;
	}
	
	elseif (!get_module_pref ("bathroomfull", "houserooms")) {
		output ("`n");
		output ("`2SUCCESS: `7The module has been uninstalled successfully.");
		output ("`n");
		return true;
	}
}

function housebathroom_dohook($hookname, $args) {
	global $session;
	$id = httpget("id");
	$toiletname	= get_module_setting	("toiletname");

	switch ($hookname){
	
	case "roomsdefines":
		if (!get_module_pref ("bathroomfull", "houserooms", $session['user']['acctid'])) set_module_pref ("bathroomfull", 1, "houserooms", $session['user']['acctid']);
		if (!get_module_pref ("bathroomnavs", "houserooms", $session['user']['acctid'])) set_module_pref ("bathroomnavs", 1, "houserooms", $session['user']['acctid']);
		break;
		
	case "bathroomcontents":
		output ("`7");
		output ("A state of the art bathroom awaits you with all the relevant amenities.");
		output ("The bath looks inviting and the %s (tm) auto-toilet appears very helpful ...", $toiletname);
		output ("if admittedly, a little scary. You could probably clean yourself up and sort yourself out");
		output ("suitably here, however.");
		addnav ("Draw a Bath", "runmodule.php?module=housebathroom&op=bath&id=".$id);
		addnav ("Gottago!", "runmodule.php?module=housebathroom&op=toilet&id=".$id);
		break;
	}

	return $args;
}

function housebathroom_run() {
	global $session;
	$id = httpget("id");
	$op			= httpget				("op");
	$toiletname	= get_module_setting	("toiletname");

	page_header();

	switch ($op) {
		case "bath":
			output ("`^`b`cSplish splash, takin' a bath.`b");
			output ("`c");
			output ("`n");
			output ("`7");
			output ("As the sound of slowly running bathwater relaxes you, you strip down to your skivvies.");
			output ("You wait until the water level and temperature is just right and then halt the faucets.");
			output ("With the most minimal splash of water, you lower yourself in and begin to relax ...");
			output ("you ensure that you're completely clean but you took a while doing it!");
			output ("You slowly climb out of the bath and dry off, dressing back up again and ready to face the World.");
			output ("`n`n");
			output ("`&");
			output ("`cYou're as clean as a whistle!");
			output ("`n");
			set_module_pref ("odor", 0, "odor");
			addnav ("Gottago!", "runmodule.php?module=housebathroom&op=toilet&id=".$id);
			modulehook ("gobacknav");
			addnav ("Main Hall", "runmodule.php?module=house&lo=house&id=".$id);
			break;

		case "toilet":
			page_header ();
			output ("`^`b`cWhere's that newspaper ...`b");
			output ("`c");
			output ("`n");
			output ("`7");
			output ("You settle down on the carefully carved %s toilet.", $toiletname);
			output ("It's very comfortable and you can feel it already taking care of things for you.");
			output ("You reach over and take a newspaper of the realms from a nearby stack");
			output ("and begin to read ...");
			output ("`n");
			output ("`n`2`c`bLonny's Latest`b");
			output ("`c");
			output ("`2`c-=-=-=-=-=-=-=-`c");
			$sql 					= "SELECT newstext,arguments FROM ".db_prefix("news")." ORDER BY newsid DESC LIMIT 5";
			$result 				= db_query($sql) or die(db_error(LINK));
			for ($i=0;$i<5;$i++){
				$row 				= db_fetch_assoc($result);
				if ($row['arguments']>""){
			$arguments 			= array();
			$base_arguments 	= unserialize($row['arguments']);
			array_push($arguments,$row['newstext']);
			while (list($key,$val)=each($base_arguments)){
				array_push($arguments,$val);
			}
			$newnews 			= call_user_func_array("sprintf_translate",$arguments);
			}else{
				$newnews 		= $row['newstext'];
			}
				output("`c %s `c",$newnews);
				if ($i <> 5) output("`2`c-=-=-=-=-=-=-=-=-=-=-=-=-`c");
			}
			output("`^`cNews brought to you by`c");
			rawoutput("<div style=\"text-align: center;\"><a href=\"http://www.pqcomp.com\" target=\"_blank\">Lonny's PQComp</a><br>");
			output("`2`c-=-=-=-=-=-=-=-=-=-=-=-=-`c");
			output ("`7");
			output ("`n");
			output ("You're jostled back to reality by a spray of warm water which shoots up underneath you.");
			output ("Apparently, you're done. You stand up, drop your paper and redress your rear.");
			output ("It has to be said though, that was one comfy toilet! You've certainly taken care of your bodily needs.");
			output ("`n`n");
			output ("`&");
			output ("`cYou really had to go and did you ever!");
			output ("`n");
			set_module_pref ("bladder",0,"bladder");
			set_module_pref ("emptied",1,"bladder");
			addnav ("Draw a Bath", "runmodule.php?module=housebathroom&op=bath&id=".$id);
			modulehook ("gobacknav");
			addnav ("Main Hall", "runmodule.php?module=house&lo=house&id=".$id);
			break;
	}
	
	page_footer();
}

?>