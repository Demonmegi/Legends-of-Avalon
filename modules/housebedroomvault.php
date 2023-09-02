<?php


function housebedroomvault_getmoduleinfo() {
	$info = array(
		"name"=>"House Rooms - Bedroom Vault",
		"author"=>"`!Rowne-Wuff Mastaile/`#Lonny Luberts",
		"version"=>"2.56",
		"category"=>"House System",
		"download"=>"http://www.pqcomp.com/modules/mydownloads/visit.php?cid=3&lid=48",
		"settings"=>array(
			"blockbed"=>"Do you want the 'Sleep' nav to only show in the bedroom?,bool|1",
		),
		"requires"=>array(
			"houserooms"=>"2.5|By `!Rowne-Wuff Mastaile/`#Lonny Luberts",
		),
	);
	return $info;
}

function housebedroomvault_install() {
	module_addhook ("roomsdefines");
	module_addhook ("housenavs");
	module_addhook ("bedroomcontents");
	module_addhook ("houseroomswherecan");
	$sql		= "SELECT acctid FROM ".db_prefix("accounts");
	$result	= db_query($sql);
	$row		= db_fetch_assoc($result);

	for ($i=0;$i<db_num_rows($result);$i++){
		set_module_pref ("bedroomfull", 1, "houserooms", $row['acctid']);
		set_module_pref ("bedroomnavs", 1, "houserooms", $row['acctid']);
	}

	output ("`^Doing a check on your preferences to ensure that a successful install has been made ...", $row2['name']);

	if (!get_module_pref ("bedroomfull", "houserooms")) {
		output ("`n");
		output ("`\$ERROR: `7Go and pester Rowne about it.");		
		output ("`n");
		return false;
	}
	
	elseif (get_module_pref ("bedroomfull", "houserooms")) {
		output ("`n");

		if (is_module_active ("housebedroomvault")) {
			output ("`2SUCCESS: `7The module has been updated successfully.");
		}
		
		else {
			output ("`2SUCCESS: `7The module has been installed successfully.");
		}

		output ("`n");
		return true;
	}
}

function housebedroomvault_uninstall() {
	$sql		= "SELECT acctid FROM ".db_prefix("accounts");
	$result	= db_query			($sql);
	$row		= db_fetch_assoc	($result);

	for ($i=0;$i<db_num_rows($result);$i++){
		set_module_pref ("bedroomfull", 0, "houserooms", $row['acctid']);
		set_module_pref ("bedroomnavs", 0, "houserooms", $row['acctid']);
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

	if (get_module_pref ("bedroomfull", "houserooms")) {
		output ("`n");
		output ("`$ERROR: `7Go and pester Rowne about it.");		
		output ("`n");
		return false;
	}
	
	elseif (!get_module_pref ("bedroomfull", "houserooms")) {
		output ("`n");
		output ("`2SUCCESS: `7The module has been uninstalled successfully.");
		output ("`n");
		return true;
	}
}

function housebedroomvault_dohook($hookname, $args) {
	global $session, $REQUEST_URI;
	$id = httpget("id");
	switch ($hookname){
	
	case "roomsdefines":
		if (!get_module_pref ("bedroomfull", "houserooms", $session['user']['acctid'])) set_module_pref ("bedroomfull", 1, "houserooms", $session['user']['acctid']);
		if (!get_module_pref ("bedroomnavs", "houserooms", $session['user']['acctid'])) set_module_pref ("bedroomnavs", 1, "houserooms", $session['user']['acctid']);
		break;
		
	case "bedroomcontents":
		$bedroomfrom = 0;
		if (get_module_setting ("blockbed")) {
			output ("`&");
			output ("[");
			output ("`2");
			output ("Catch Some Z's");
			output ("`&");
			output ("]");
			output ("`7");
			output ("There's a comfy looking sack dumped in the middle of the Bedroom, it's quite a comfy looking sack.");
			output ("One might even go so far as to say it's a four-poster sack. Indeed, it looks a comfy place for one to kip");
			output ("`&");
			output ("(");
			output ("`!");
			output ("Log Out");
			output ("`&");
			output (")`7.");
			output ("Should one desire to do so.");
			output ("`n`n");
			addnav ("Bedroom");
			addnav ("Catch Some Z's", "runmodule.php?module=house&lo=house&id=&id=".$id."&op=sleep");
		}
		output ("`7");
		output ("`&");
		output ("[");
		output ("`@");
		output ("Vault");
		output ("`&");
		output ("]");
		output ("`7");
		output ("A detailed painting hangs on the opposite wall, beautiful in its inricacies.");
		output ("Though it is known to you that its purpose is faux and were you to turn it aside,");
		output ("you would find a Vault there, where all this house's monetary income is stashed.");
		addnav ("Vault");
		addnav ("`7Withdraw `^Gold`n`7from the Vault", "runmodule.php?module=housebedroomvault&bedroomfrom=1&disablemh=1&op=goldw&id=".$id);
		addnav ("`7Deposit `^Gold`n`7in the Vault", "runmodule.php?module=housebedroomvault&bedroomfrom=1&disablemh=1&op=goldd&id=".$id);
		addnav ("`7Withdraw `%Gems`n`7from the Vault", "runmodule.php?module=housebedroomvault&bedroomfrom=1&disablemh=1&op=gemsw&id=".$id);
		addnav ("`7Deposit `%Gems`n`7in the Vault", "runmodule.php?module=housebedroomvault&bedroomfrom=1&disablemh=1&op=gemsd&id=".$id);
		break;
		
	case "housenavs":
		$currpage		= comscroll_sanitize	($REQUEST_URI);

		if (get_module_setting ("blockbed")) blocknav ("runmodule.php?module=house&lo=house&id=".$id."&op=sleep");

		blocknav ("runmodule.php?module=house&lo=house&id=".$id."&op=gemsw");
		blocknav ("runmodule.php?module=house&lo=house&id=".$id."&op=gemsd");
		blocknav ("runmodule.php?module=house&lo=house&id=".$id."&op=goldw");
		blocknav ("runmodule.php?module=house&lo=house&id=".$id."&op=goldd");
		break;

	case "houseroomswherecan":
		$bedroomfrom	= httpget	("bedroomfrom");

		if ($bedroomfrom) {
			output ("There's a door nearby labeled '`2Bedroom`7'");
		}
		break;
	}

	return $args;
}

function housebedroomvault_run() {
	global $session;
	require_once("lib/systemmail.php");
	page_header();
	output ("`^");
	output ("`b");
	output ("`c");
	output ("`n");
	output ("Bedroom Vault");
	output ("`n`n");
	output ("`b");
	output ("`c");
	output ("`7");

	$gold				= httppost				("gold");
	$gems				= httppost				("gems");
	$op				= httpget				("op");
	$treasure		= get_module_objpref	("house", $session['user']['acctid'], "treasure", "house");
	$gemtreasure	= get_module_objpref	("house", $session['user']['acctid'], "gemtreasure", "house");
	$gemdone			= get_module_pref		("gemdone", "house");
	$golddone		= get_module_pref		("golddone", "house");
	$gemwith			= get_module_setting	("gemwith", "house");
	$goldwith		= get_module_setting	("goldwith", "house");
	$goldperlevel	= get_module_setting	("goldperlevel", "house");
	$gemperlevel	= get_module_setting	("gemperlevel", "house");
	$id = httpget("id");
	$maxgolddepos	= $session['user']['level'] * $goldperlevel;
	$maxgoldtfer	= $session['user']['level'] * $goldperlevel;
	$maxgemsdepos	= $session['user']['level'] * $gemperlevel;
	$maxgemstfer	= $session['user']['level'] * $gemperlevel;

	switch ($op) {
		case "goldw":
			switch ($gold <= 0) {
				case "1":
					switch ($treasure != 0) {
						case "1":
							switch ($golddone >= $goldwith) {
								case "1":
									output ("You cannot withdraw more than %s times a day!",$goldwith);
									break;

								case "0":
									output("There is `^%s`7 gold in the chest`n", $treasure, true);
									output("You are allowed to withdraw `6%s`7 times up to `^%s`7 gold at a time!", $goldwith - $golddone, $goldperlevel * $session['user']['level']);
									rawoutput("<form action='runmodule.php?module=housebedroomvault&frombedroom=1&disablemh=1&op=goldw&id=".$id."' method='POST'>");
									output("`^Withdraw how much?");
									rawoutput("<input id='input' name='gold' width=5> <input type='submit' class='button' value='".translate_inline("Withdraw")."'>");
									rawoutput("</form>");
									rawoutput("<script language='javascript'>document.getElementById('input').focus();</script>",true);
									break;
							}
							break;
							
						case "0":
							output("`\$ERROR: There is no gold in the Chest!");
							break;
					}
					break;
				
				case "0":
					if ($gold > $maxgoldtfer) $gold	= $maxgoldtfer;
					if ($gold > $treasure) $gold	= $treasure;
					output ("You withdrew `^%s`7 gold from the chest!", $gold);
					$session['user']['gold'] 		+= $gold;
					set_module_objpref				("house", $id, "treasure", $treasure - $gold,"house");
					$golddone++;
					set_module_pref					("golddone", $golddone, "house");
					$sql			= "SELECT acctid FROM ".db_prefix("accounts")." WHERE acctid=$id";
					$result		= db_query			($sql);
					$row			= db_fetch_assoc	($result);
					$subject		= sprintf			("%s has Withdrawn Gold", $session['user']['name']);
					$body 		= sprintf			("%s `7has withdrawn `^%s gold `7from your vault", $session['user']['name'], $gold);
					systemmail	($row['acctid'],$subject,$body); 
					break;
			}

			addnav ("","runmodule.php?module=housebedroomvault&frombedroom=1&disablemh=1&op=goldw&id=".$id);
			break;

		case "goldd":
			if ($maxgolddepos > (get_module_setting ("treasuresize", "house") - $treasure)) $maxgolddepos = get_module_setting ("treasuresize", "house") - $treasure;
			if ($maxgolddepos > $session['user']['gold']) $maxgolddepos = $session['user']['gold'];
			switch ($maxgolddepos <= 0) {
				case "1":
					output ("You are not able to deposit any more gold in the chest!");
					break;

				case "0":
					switch ($gold <= 0) {
						case "1":
							output		("There is `^%s`7 gold in the chest`n", $treasure, true);
							output		("You are allowed to deposit up to `^%s`7 gold at a time!", $maxgolddepos);
							rawoutput	("<form action='runmodule.php?module=housebedroomvault&frombedroom=1&disablemh=1&op=goldd&id=".$id."' method='POST'>");
							output		("`^Deposit how much?");
							rawoutput	("<input id='input' name='gold' width=5> <input type='submit' class='button' value='".translate_inline("Deposit")."'>");
							rawoutput	("</form>");
							rawoutput	("<script language='javascript'>document.getElementById('input').focus();</script>",true);
							break;

						case "0":
							if ($gold > $maxgolddepos) $gold = $maxgolddepos;
							output		("You deposit `^%s`7 gold into the chest!", $gold);
							$session['user']['gold'] 	-= $gold;
							set_module_objpref			("house", $id, "treasure", $treasure + $gold,"house");
							$sql 			= "SELECT acctid FROM ".db_prefix("accounts")." WHERE acctid=$id";
							$result 		= db_query 			($sql);
							$row 			= db_fetch_assoc	($result);
							$subject		= sprintf			("%s has Depostited Gold", $session['user']['name']);
							$body 		= sprintf			("%s `7has deposited `^%s gold `7into your vault", $session['user']['name'], $gold);
							systemmail	($row['acctid'],$subject,$body); 
							break;
					}
					break;
			}

			addnav ("","runmodule.php?module=housebedroomvault&frombedroom=1&disablemh=1&op=goldd&id=".$id);
			break;

		case "gemsw":
			switch ($gems <= 0) {
				case "1":
					switch ($gemtreasure != 0) {
						case "1":
							switch ($session['user']['transferredtoday'] >= $gemwith) {
								case "1":
									output ("You cannot withdraw more than %s times a day!", $gemwith);
									break;

								case "0":
									output		("There are `^%s`7 gems in the chest`n", $gemtreasure, true);
									output		("You are allowed to withdraw `6%s`7 times up to `^%s`7 gems at a time!",  $gemwith - $gemdone, $gemperlevel * $session['user']['level']);
									rawoutput	("<form action='runmodule.php?module=housebedroomvault&frombedroom=1&disablemh=1&op=gemsw&id=".$id."' method='POST'>");
									output		("`^Withdraw how much?");
									rawoutput	("<input id='input' name='gems' width=5> <input type='submit' class='button' value='".translate_inline("Withdraw")."'>");
									rawoutput	("</form>");
									rawoutput	("<script language='javascript'>document.getElementById('input').focus();</script>",true);
							}
							break;
						
						case "0":
							output("`\$ERROR: There are no gems in the Chest!");
							break;
					}
					break;

				case "0":
					if ($gems > $maxgemstfer) $gems = $maxgemstfer;
					if ($gems > $gemtreasure) $gems = $gemtreasure;
					output ("You withdrew `^%s`7 gems from the chest!", $gems);
					$session['user']['gems'] += $gems;
					set_module_objpref	("house", $id, "gemtreasure", $gemtreasure - $gems, "house");
					$gemdone ++;
					set_module_pref		("gemdone", $gemdone, "house");
					$sql						= "SELECT acctid FROM ".db_prefix("accounts")." WHERE acctid=$id";
					$result					= db_query	($sql);
					$row 						= db_fetch_assoc($result);
					$subject					= sprintf	("%s has Withdrawn Gems", $session['user']['name']);
					$body						= sprintf	("%s `7has withdrawn `^%s gems `7from your vault", $session['user']['name'], $gems);
					systemmail				($row['acctid'], $subject, $body); 
					break;
			}

			addnav ("","runmodule.php?module=housebedroomvault&frombedroom=1&disablemh=1&op=gemsw&id=".$id);
			break;

		case "gemsd":
			if ($maxgemsdepos > (get_module_setting ("maxgems", "house") - $gemtreasure)) $maxgemsdepos = get_module_setting ("maxgems", "house") - $gemtreasure;
			if ($maxgemsdepos > $session['user']['gems']) $maxgemsdepos = $session['user']['gems'];
			switch ($maxgemsdepos <= 0) {
				case "1":
					output ("You are not able to deposit any more gems into the chest!");
					break;
					
				case "0":
					switch ($gems <= 0) {
						case "1":
							output		("There are `^%s`7 gems in the chest`n", $gemtreasure, true);
							output		("You are allowed to deposit up to `^%s`7 gems at a time!", $maxgemsdepos);
							rawoutput	("<form action='runmodule.php?module=housebedroomvault&frombedroom=1&disablemh=1&op=gemsd&id=".$id."' method='POST'>");
							output		("`^Deposit how much?");
							rawoutput	("<input id='input' name='gems' width=5> <input type='submit' class='button' value='".translate_inline("Deposit")."'>");
							rawoutput	("</form>");
							rawoutput	("<script language='javascript'>document.getElementById('input').focus();</script>",true);
							break;

						case "0":
							if ($gems > $maxgemsdepos) $gems = $maxgemsdepos;
							break;
					}
					output ("You deposited `^%s`7 gems into the chest!", $gems);
					$session['user']['gems'] -= $gems;
					set_module_objpref	("house", $id, "gemtreasure", $gemtreasure + $gems,"house");
					$sql						= "SELECT acctid FROM ".db_prefix("accounts")." WHERE acctid=$id";
					$result					= db_query			($sql);
					$row						= db_fetch_assoc	($result);
					$subject					= sprintf("%s has Deposited Gems", $session['user']['name']);
					$body						= sprintf("%s `7has deposited `^%s gems `7into your vault", $session['user']['name'], $gems);
					systemmail				($row['acctid'],$subject,$body); 
					break;
			}
	
			addnav("","runmodule.php?module=housebedroomvault&frombedroom=1&disablemh=1&op=gemsd&id=".$id);
			break;
	}

	addnav ("Exits From Here");
	addnav ("Bedroom","runmodule.php?module=houserooms&op=bedroom&id=".$id);
	addnav ("Vault");
	addnav ("`7Withdraw `^Gold`n`7from the Vault", "runmodule.php?module=housebedroomvault&bedroomfrom=1&disablemh=1&op=goldw&id=".$id);
	addnav ("`7Deposit `^Gold`n`7in the Vault", "runmodule.php?module=housebedroomvault&bedroomfrom=1&disablemh=1&op=goldd&id=".$id);
	addnav ("`7Withdraw `%Gems`n`7from the Vault", "runmodule.php?module=housebedroomvault&bedroomfrom=1&disablemh=1&op=gemsw&id=".$id);
	addnav ("`7Deposit `%Gems`n`7in the Vault", "runmodule.php?module=housebedroomvault&bedroomfrom=1&disablemh=1&op=gemsd&id=".$id);
	page_footer();
}

?>