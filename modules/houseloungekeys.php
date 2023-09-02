<?php


function houseloungekeys_getmoduleinfo() {
	$info = array(
		"name"=>"House Rooms - Lounge Keycutter",
		"author"=>"`!Rowne-Wuff Mastaile/`#Lonny Luberts",
		"version"=>"2.56",
		"category"=>"House System",
		"download"=>"http://www.pqcomp.com/modules/mydownloads/visit.php?cid=3&lid=48",
		"settings"=>array(
			"General Settings,title",
			"brand"=>"Brand of the Keycutter|MusteliCo MusTEK",
			"race"=>"Race of the makers|Mustelids",
		),
		"requires"=>array(
			"houserooms"=>"2.5|By `!Rowne-Wuff Mastaile/`#Lonny Luberts",
		),
	);
	return $info;
}

function houseloungekeys_install() {
	module_addhook ("roomsdefines");
	module_addhook ("housenavs");
	module_addhook ("loungecontents");
	module_addhook ("houseroomswherecan");
	$sql		= "SELECT acctid FROM ".db_prefix("accounts");
	$result	= db_query($sql);
	$row		= db_fetch_assoc($result);

	for ($i=0;$i<db_num_rows($result);$i++){
		set_module_pref ("loungefull", 1, "houserooms", $row['acctid']);
		set_module_pref ("loungenavs", 1, "houserooms", $row['acctid']);
	}

	output ("`^Doing a check on your preferences to ensure that a successful install has been made ...", $row2['name']);

	if (!get_module_pref ("loungefull", "houserooms")) {
		output ("`n");
		output ("`\$ERROR: `7Go and pester Rowne about it.");		
		output ("`n");
		return false;
	}
	
	elseif (get_module_pref ("loungefull", "houserooms")) {
		output ("`n");

		if (is_module_active ("houseloungekeys")) {
			output ("`2SUCCESS: `7The module has been updated successfully.");
		}
		
		else {
			output ("`2SUCCESS: `7The module has been installed successfully.");
		}

		output ("`n");
		return true;
	}
}

function houseloungekeys_uninstall() {
	$sql		= "SELECT acctid FROM ".db_prefix("accounts");
	$result	= db_query			($sql);
	$row		= db_fetch_assoc	($result);

	for ($i=0;$i<db_num_rows($result);$i++){
		set_module_pref ("loungefull", 0, "houserooms", $row['acctid']);
		set_module_pref ("loungenavs", 0, "houserooms", $row['acctid']);
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

	if (get_module_pref ("loungefull", "houserooms")) {
		output ("`n");
		output ("`$ERROR: `7Go and pester Rowne about it.");		
		output ("`n");
		return false;
	}
	
	elseif (!get_module_pref ("loungefull", "houserooms")) {
		output ("`n");
		output ("`2SUCCESS: `7The module has been uninstalled successfully.");
		output ("`n");
		return true;
	}
}

function houseloungekeys_dohook($hookname, $args) {
	global $session, $REQUEST_URI;
	$id = httpget("id");
	switch ($hookname){
	
	case "roomsdefines":
		if (!get_module_pref ("loungefull", "houserooms", $session['user']['acctid'])) set_module_pref ("loungefull", 1, "houserooms", $session['user']['acctid']);
		if (!get_module_pref ("loungenavs", "houserooms", $session['user']['acctid'])) set_module_pref ("loungenavs", 1, "houserooms", $session['user']['acctid']);
		break;
		
	case "loungecontents":
		$loungefrom	= 0;
		$brand		= get_module_setting	("brand");
		$race			= get_module_setting	("race");
		if ($id == $session['user']['acctid']){
			output ("`&");
			output ("[");
			output ("`@");
			output ("Keycutter");
			output ("`&");
			output ("]");
			output ("`7");
			output ("On a small table in the middle of the lounge is a strange %s device.", $brand);
			output ("It's apparently used for the cutting and duplication of keys.  This,");
			output ("will apparently allow you to distribute keys to your friends so that");
			output ("they might visit you. Clever fellows, these %s.", $race);
			addnav ("Keycutter");
			addnav ("Cut a Key", "runmodule.php?module=houseloungekeys&loungefrom=1&disablemh=1&op=givek&id=$id");
			addnav ("Withdraw Key", "runmodule.php?module=houseloungekeys&loungefrom=1&disablemh=1&op=withk&id=$id");
		}else{
			output ("`&");
			output ("[");
			output ("`@");
			output ("Keycutter");
			output ("`&");
			output ("]");
			output ("`7");
			output ("On a small table in the middle of the lounge is a strange %s device.", $brand);
			output ("It's apparently used for the cutting and duplication of keys.  This,");
			output ("will apparently allow the owner to distribute keys to their friends so that");
			output ("they might visit them. Clever fellows, these %s.", $race);
		}
		break;
		
	case "housenavs":
		$currpage	= comscroll_sanitize	($REQUEST_URI);
		$loungefrom	= httpget	("loungefrom");

        blocknav ("runmodule.php?module=house&lo=house&id=".$id."&op=givek");
		blocknav ("runmodule.php?module=house&lo=house&id=".$id."&op=withk");
		break;
		
	case "houseroomswherecan":
		$loungefrom	= httpget	("loungefrom");

		if ($loungefrom) {
			output ("There's a door nearby labeled '`2Lounge`7'");
			output ("`n");
		}

		break;
	}

	return $args;
}

function houseloungekeys_run() {
	global $session;
	require_once("lib/systemmail.php");
	$op				= httpget			("op");
	$to				= httppost			("to");
	$nick				= httppost			("nick");
	$acc				= httppost			("acc");
	$thehousezone	= get_module_pref	("village");
	$id = httpget("id");

	page_header ();
	output ("`^");
	output ("`b");
	output ("`c");
	output ("`n");
	output ("Lounge Keycutter");
	output ("`n`n");
	output ("`b");
	output ("`c");
	output ("`7");

	switch ($op) {
		case "givek":
			switch ($to != "") {
				case "1":
					$to		= explode	("|", $to, 2);
					$sql		= "SELECT ownerid FROM ".db_prefix("housekeys")." WHERE ownerid='".$to[0]."' AND houseid='".$id."'";
					$result	= db_query	($sql);

					switch (db_num_rows ($result) == 0) {
						case "1":
							$sql						= "INSERT INTO ".db_prefix("housekeys")." (ownerid, houseid, housename, location) VALUES ('".$to[0]."', '$id', ' ?".addslashes(get_module_pref("name", "house"))."', '".get_module_pref("village", "house")."')";
							db_query									($sql);

							$mailgivekeysubject	= sprintf	("You have been granted residence by %s.",$session['user']['name']);
							$mailgivekeybody		= "It appears as though you have been granted permission to live at %s in $thehousezone!  You should have your key and you can drop by any time.";
							systemmail	($to[0],$mailgivekeysubject,sprintf($mailgivekeybody,get_module_pref("name", "house")).$session['user']['name']);
							break;

						case "0":
							output ("This Player already has a key to your house!");
							break;
					}
				
			}
			
			switch ($nick != "") {
				case "1":
					$search="%";
					for ($x=0;$x<strlen($nick);$x++){
						$search .= substr($nick,$x,1)."%";
					}
					$search	= " AND name LIKE '".addslashes($search)."' ";
					$sql		= "SELECT acctid,name,login FROM " . db_prefix("accounts") . " WHERE locked=0 $search ORDER BY level DESC, dragonkills DESC, login ASC $limit";
					$result	= db_query	($sql);

					switch (db_num_rows ($result) >= 1) {
						case "1":
							rawoutput 	("<form action='runmodule.php?module=houseloungekeys&fromlounge=1&disablemh=1&op=givek&id=$id' method='POST'>");
							output		("`7Give a key to your house to");
							$msg			= translate_inline("Give");
							rawoutput 	("<select name='to' class='input'>");
							addnav("","runmodule.php?module=houseloungekeys&fromlounge=1&disablemh=1&op=givek&id=$id");
							for ($i=0;$i<db_num_rows($result);$i++){
								$row = db_fetch_assoc($result);
								rawoutput ("<option value=\"".HTMLEntities($row['acctid'])."|".HTMLEntities($row['name'])."\">".full_sanitize($row['name'])."</option>");
							}

							rawoutput ("</select><input type='submit' class='button' value='$msg'></form>",true);
							break;

						case "0":
							output ("`7Sorry, but there is no player with that name.");
							break;
					}
					break;

				case "0":
					$sql = "SELECT ownerid FROM ".db_prefix("housekeys")." WHERE houseid='".$id."'";
					$result = db_query($sql);

					if (db_num_rows ($result) >= get_module_setting("maxkeys", "house")) {
							output ("You don't have any rooms left!");
					}else{
							output		("You have %s rooms left!`n", get_module_setting("maxkeys", "house") - db_num_rows($result));
							$search		= translate_inline("Search by name: ");
							$search2		= translate_inline("Search");
							rawoutput	("<form action='runmodule.php?module=houseloungekeys&fromlounge=1&disablemh=1&op=givek&id=$id' method='POST'>$search<input name='nick'><input type='submit' class='button' value='$search2'></form>");
					}
			}
			
			addnav ("","runmodule.php?module=houseloungekeys&fromlounge=1&disablemh=1&op=givek&id=$id");
			break;

		case "withk":
			switch ($acc != "") {
				case "1":
					$sql = "DELETE FROM ".db_prefix("housekeys")." WHERE ownerid=$acc AND houseid=".$session['user']['acctid'];
					db_query ($sql);
					output("`6You withdrew the Key to your House!");
					$subject = sprintf("%s has revoked your access to their home!", $session['user']['name']);
					$body		= sprintf("It has been decided that you will no longer be able to stay at %s.  You will find you've already been relieved of your key.  If you feel this is in error, please mail the owner.", $session['user']['name'], get_module_pref("name", "house"));
					systemmail ($acc,$subject,$body);
					break;

				case "0":
					output	("`6Flatmates:`&");
					$sql		= "SELECT ownerid FROM ".db_prefix("housekeys")." WHERE houseid=$id";
					$result	= db_query ($sql);
					$sql		= "SELECT acctid,name FROM ".db_prefix("accounts")." WHERE acctid=";
					while		($row = mysql_fetch_row ($result)) $sql .= $row[0]." OR acctid=";
					$sql		= substr($sql, 0, -11);
					$result	= db_query($sql);
					$i			= 0;
					while		($row = mysql_fetch_array ($result)){
						$i ++;
						
						switch ($row['acctid'] == $session['user']['acctid']) {
							case "1":
								output_notl("`n$i. ".ereg_replace("`.","",$row['name']));
								break;
								
							case "0":
								rawoutput ("<br><form name='delete$i' action='runmodule.php?module=houseloungekeys&fromlounge=1&disablemh=1&op=withk&id=$id' method='POST'>");
								rawoutput ("<input type='hidden' name='nick' value='".$row['name']."'>");
								rawoutput ("<input type='hidden' name='acc' value='".$row['acctid']."'>");
								rawoutput ("$i. <a href='javascript:document.delete$i.submit();'>".ereg_replace("`.","",$row['name'])."</a></form>");
								break;
						}
					}
					addnav("","runmodule.php?module=houseloungekeys&fromlounge=1&disablemh=1&op=withk&id=$id");
					break;
			}
			break;
	}

	addnav ("Exits From Here");
	addnav ("Lounge", "runmodule.php?module=houserooms&op=lounge&id=$id");
	if ($id == $session['user']['acctid']){
		addnav ("Keycutter");
		addnav ("Cut a Key", "runmodule.php?module=houseloungekeys&loungefrom=1&disablemh=1&op=givek&id=$id");
		addnav ("Withdraw Key", "runmodule.php?module=houseloungekeys&loungefrom=1&disablemh=1&op=withk&id=$id");
	}
	page_footer();
}

?>