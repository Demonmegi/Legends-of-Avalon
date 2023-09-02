<?php


require_once("common.php");

function housekitchen_getmoduleinfo() {
	$info = array(
		"name"=>"House Rooms - Kitchen",
		"author"=>"`!Rowne-Wuff Mastaile/`#Lonny Luberts",
		"version"=>"2.56",
		"category"=>"House System",
		"download"=>"http://www.pqcomp.com/modules/mydownloads/visit.php?cid=3&lid=48",
		"settings"=>array(
			"pcookieon"=>"Are the Power Cookies (tm) enabled?,bool|1",
			"pcookiedie"=>"The player has a 1 in ? chance of dying:,int|3",
			"pcookieturn"=>"The player gains ? turns from a cookie:,int|8",
		),
		"requires"=>array(
			"usechow"=>"1.3|By `#Lonny Luberts",
			"houserooms"=>"2.5|By `!Rowne-Wuff Mastaile/`#Lonny Luberts",
		),
	);
	return $info;
}

function housekitchen_install() {
	module_addhook ("roomsdefines");
	module_addhook ("housenavs");
	module_addhook ("kitchencontents");
	$sql		= "SELECT acctid FROM ".db_prefix("accounts");
	$result	= db_query($sql);
	$row		= db_fetch_assoc($result);

	for ($i=0;$i<db_num_rows($result);$i++){
		set_module_pref ("kitchenfull", 1, "houserooms", $row['acctid']);
		set_module_pref ("kitchennavs", 1, "houserooms", $row['acctid']);
	}

	output ("`^Doing a check on your preferences to ensure that a successful install has been made ...", $row2['name']);

	if (!get_module_pref ("kitchenfull", "houserooms")) {
		output ("`n");
		output ("`\$ERROR: `7Go and pester Rowne about it.");		
		output ("`n");
		return false;
	}
	
	elseif (get_module_pref ("kitchenfull", "houserooms")) {
		output ("`n");
		
		if (is_module_active ("housekitchen")) {
			output ("`2SUCCESS: `7The module has been updated successfully.");
		}
		
		else {
			output ("`2SUCCESS: `7The module has been installed successfully.");
		}
		
		output ("`n");
		return true;
	}
}

function housekitchen_uninstall() {
	$sql		= "SELECT acctid FROM ".db_prefix("accounts");
	$result	= db_query			($sql);
	$row		= db_fetch_assoc	($result);

	for ($i=0;$i<db_num_rows($result);$i++){
		set_module_pref ("kitchenfull", 0, "houserooms", $row['acctid']);
		set_module_pref ("kitchennavs", 0, "houserooms", $row['acctid']);
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

	if (get_module_pref ("kitchenfull", "houserooms")) {
		output ("`n");
		output ("`$ERROR: `7Go and pester Rowne about it.");		
		output ("`n");
		return false;
	}
	
	elseif (!get_module_pref ("kitchenfull", "houserooms")) {
		output ("`n");
		output ("`2SUCCESS: `7The module has been uninstalled successfully.");
		output ("`n");
		return true;
	}
}

function housekitchen_dohook($hookname, $args) {
	global $session;
	$id = httpget("id");
	switch ($hookname){
	
	case "roomsdefines":
		if (!get_module_pref ("kitchenfull", "houserooms", $session['user']['acctid'])) set_module_pref ("kitchenfull", 1, "houserooms", $session['user']['acctid']);
		if (!get_module_pref ("kitchennavs", "houserooms", $session['user']['acctid'])) set_module_pref ("kitchennavs", 1, "houserooms", $session['user']['acctid']);
		break;
		
	case "kitchencontents":
		$pcookie	=	get_module_setting	("pcookieon");
		output ("`7");
		output ("An incredibly clean Kitchen is laid out before you.");
		output ("All the appliances you'd need to fix up a nice snack");
		output ("before heading back out into the World.");
		output ("Face it with a full stomach, you would. The Kitchen,");
		output ("is well stocked and catered for aswell. You're not quite");
		output ("sure by who as there doesn't seem to be anyone `ihere`i ...");
		output ("but there are certainly many forms of fresh foodstuffs about.");
		addnav ("Fix a Snack", "runmodule.php?module=housekitchen&op=snack&id=".$id);
		if ($pcookie) {
			output ("The other oddity you happen to spot is a jar of cookies on the table.");
			output ("They're labelled `b`^Power Cookies`b`7 but their jar also has an");
			output ("ominous Skull and Crossbones on it, right next to a smiley-faced Sun.");
			output ("You can't help but wonder `iwhat the hell`i is up with those cookies.");
			output ("`n`n");
			addnav ("Eat a Cookie", "runmodule.php?module=housekitchen&op=cookie&id=".$id);
		}
		break;
	}

	return $args;
}

function housekitchen_run() {
	global $session;
	$id = httpget("id");
	$op			= httpget			("op");
	$subop		= httpget			("subop");
	$cookturn	= get_module_pref	("pcookieturn");
	$cdiebase	= get_module_pref	("pcookiedie");
	$cookdie		= e_rand				(1, $cdiebase);

	page_header ();

	switch ($op) {
		case "snack":
			output ("`^`b`cSizzle, fry, bake 'n' shake!`b");
			output ("`c");
			output ("`n");
			output ("`7");

			switch ($subop) {
				case "":
					output ("You cast your gaze around the Kitchen and prepare to rustle up some grub.");
					output ("You could make everything from a sandwich to a real meal.  Question is ...");
					output ("what to make?");
					output ("`n`n");
					addnav ("Sandwich", "runmodule.php?module=housekitchen&op=snack&subop=sandwich&id=".$id);
					addnav ("Brunch", "runmodule.php?module=housekitchen&op=snack&subop=brunch&id=".$id);
					addnav ("Dinner", "runmodule.php?module=housekitchen&op=snack&subop=dinner&id=".$id);
					modulehook ("housekitchennavs");
					break;

				case "sandwich":
					output ("You spend a little while slapping together a masterwork of a sandwich.");
					output ("A triple-decker with ingrediants set to counterbalance each other.");
					output ("All towards a sublime taste capturing the true art of the sandwich.");
					output ("`n`n");
					set_module_pref ('hunger', get_module_pref('hunger', 'usechow') - 20, 'usechow');
					set_module_pref ('bladder', get_module_pref('bladder', 'bladder') + 2, 'bladder');
					$session['user']['turns']--;
					output ("`&");
					output ("`cYou feel slightly less hungry.");
					output ("`n`n");
					output ("The time involved making a sandwich however cost you a Forest Fight!`c");
					output ("`n`n");
					break;

				case "brunch":
					output ("You gather together various things from around the Kitchen.");
					output ("You crack some eggs into a pan and start frying them up along with some bacon.");
					output ("You drop a few pieces of toast under the grill and peel a few Oranges.");
					output ("Grabbing a little garnish, you sprinkle it in with the eggs and side the whole");
					output ("thing off with the fruit. Of course, the bread gets serviced with");
					output ("your best butter. By the time you've finished, your mouth is watering.");
					output ("So you waste no time and dig in!");
					output ("`n`n");
					set_module_pref ('hunger', get_module_pref('hunger', 'usechow') - 45, 'usechow');
					set_module_pref ('bladder', get_module_pref('bladder', 'bladder') + 3, 'bladder');
					$session['user']['turns'] = $session['user']['turns'] - 2;
					output ("`&");
					output ("`cYou're less hungry now.");
					output ("`n`n");
					output ("The time involved making brunch however cost you two Forest Fights!`c");
					output ("`n`n");
					break;

				case "dinner":
					output ("You set about making dinner, hunting around the cupboards for the things you'll need.");
					output ("Within minutes you have something being refridgerated, numerous pots and pans boiling");
					output ("and a Chicken in the oven. You can smell the sauces boiling and the rice is almost ready.");
					output ("The whole thing comes together as an amazing meal with the side order of trifle you refridgerated.");
					output ("It's too much, your stomach is rumbling! You ravenously Wolf down the huge meal.");
					output ("The lemon sauce on the Chicken is divine and with the egg-fried rice,");
					output ("the flavour is really brought out. What a wonderful meal!");
					set_module_pref ('hunger', 0, 'usechow');
					set_module_pref ('bladder', get_module_pref('bladder', 'bladder') + 5, 'bladder');
					$session['user']['turns'] = $session['user']['turns'] - 4;
					output ("`&");
					output ("`cYou feel totally stuffed!");
					output ("`n`n");
					output ("The time involved making dinner however cost you four Forest Fights!`c");
					output ("`n`n");
					break;
					
				modulehook ("housekitchenfoods");
			}
			
			modulehook ("gobacknav");
			addnav ("Main Hall", "runmodule.php?module=house&lo=house&id=".$id);
			break;

		case "cookie":
			output ("`^`b`cSuch a strange cookie ...`b");
			output ("`c");
			output ("`n");
			output ("`7");
		
			switch ($subop) {
				case "":
					output ("You wander suspiciously over to the jar");
					output ("and peer inside. The cookies look normal enough.");
					output ("There is a slight glow to them however, if you");
					output ("tip the cookie away from the light, this strange");
					output ("glow becomes quite obvious. The question is ...");
					output ("`n`n");
					output ("Are you daring enough to eat the cookie?");
					output ("`n`n");
					addnav ("Eat the Cookie!", "runmodule.php?module=housekitchen&op=cookie&subop=eatcookie&id=".$id);
					modulehook ("gobacknav");
					addnav ("Main Hall", "runmodule.php?module=house&lo=house&id=".$id);
					break;

				case "eatcookie":
					output ("You eagerly snarf the cookie ...");
					
					if ($cookdie < 2) {
						output ("and you find yourself choking, your throat closes and cuts off your air.");
						output ("You reach up and with your last act of life, you try to swat the evil jar into oblivion.");
						output ("With your last breaths, you gasp \"...why...\".");
						output ("`n`n");
						output ("Though still, you feel as though this is only half of the scret of the cookies.");
						output ("`n`n");
						output ("`c`\$You are dead!`c");
						$session['user']['hitpoints']=0;
						$session['user']['alive']=0;
						addnav("Daily News", "news.php");
					}
			
					else {
						output ("and you feel strangely revitalized! Ready for anything in fact.");
						output ("You could almost run out of the house and do five or ten laps of the nearby");
						output ("Forest. Wow! What was in that cookie?!");
						output ("`n`n");
						output ("`&");
						output ("`c");
						output ("You gain `2%s `&Forest Fights!", $cookturn);
						$session['user']['turns']+=$cookturn;
						modulehook ("gobacknav");
						addnav ("Main Hall", "runmodule.php?module=house&lo=house&id=".$id);
					}
					break;
			}
	}

	page_footer ();
}

?>