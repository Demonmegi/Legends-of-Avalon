<?php
// addnews ready
// mail ready
// translator ready
function titlechange_getmoduleinfo(){
	$info = array(
		"name"=>"Title Change",
		"author"=>"JT Traub",
		"version"=>"1.0",
		"download"=>"core_module",
		"category"=>"Lodge",
		"settings"=>array(
			"Title Change Module Settings,title",
			"initialpoints"=>"How many donator points needed to get first title change?,int|2000",
			"extrapoints"=>"How many additional donator points needed for subsequent title changes?,int|100",
		),
		"prefs"=>array(
			"Title Change User Preferences,title",
			"timespurchased"=>"How many title changes have been bought?,int|0",
		),
	);
	return $info;
}

function titlechange_install(){
	module_addhook("lodge");
	module_addhook("pointsdesc");
	return true;
}
function titlechange_uninstall(){
	return true;
}

function titlechange_dohook($hookname,$args){
	global $session;
	switch($hookname){
	case "pointsdesc":
		$args['count']++;
		$format = $args['format'];
		$str = translate("The ability to choose a custom in-game title upon reaching %s and every %s points thereafter. (this doesn't use up those points) [NOTE: A title is the prefix on your name like Farmboy or Page]");
		$str = sprintf($str, get_module_setting("initialpoints"),
				get_module_setting("extrapoints"));
		output($format, $str, true);
		break;
	case "lodge":
		addnav("Mein Charakter");
		// If they have less than what they need just ignore them
		$times = get_module_pref("timespurchased");
		if (get_module_setting("initialpoints") > $session['user']['donation'] || get_module_setting("extrapoints") > ($session['user']['donation'] - $session['user']['donationspent'])) {
			addnav(array("Set Custom Title (%s Donationpoints)", get_module_setting("extrapoints")), "");
			break;
		}
		addnav(array("Set Custom Title (%s Donationpoints)`n`\$Achtung:`0Du brauchst hierf�r mindestens %s Donationpoints!", get_module_setting("extrapoints"), get_module_setting("initialpoints")),"runmodule.php?module=titlechange&op=titlechange");
		break;
	}
	return $args;
}

function titlechange_run(){
	require_once("lib/sanitize.php");
	require_once("lib/names.php");
	global $session;
	$op = httpget("op");

	page_header("Hunter's Lodge");
	if ($op=="titlechange"){
		output("`3`bCustomize Title`b`0`n`n");
		output("`7Because you have earned sufficient points, you have been granted the ability to set a custom title of your choosing.");
		output("The title must be appropriate, and the admin of the game can reset if it isn't (as well as penalize you for abusing the game).");
		output("The title may not be more than 25 characters long including any characters used for colorization!.`n`n");
		$otitle = get_player_title();
		output("`7Your title is currently`^ ");
		rawoutput($otitle);
		output_notl("`0`n");
		output("`7which looks like %s`n`n", $otitle);
		output("`7How would you like your title to look?`n");
		rawoutput("<form action='runmodule.php?module=titlechange&op=titlepreview' method='POST'>");
		rawoutput("<input id='input' name='newname' width='25' maxlength='25' value='".htmlentities($otitle)."'>");
		rawoutput("<input type='submit' class='button' value='Preview'>");
		rawoutput("</form>");
		addnav("", "runmodule.php?module=titlechange&op=titlepreview");
	}elseif ($op=="titlepreview"){
		$ntitle = httppost('newname');
		$ntitle=newline_sanitize($ntitle);
		if (trim($ntitle) == "") $ntitle = "`3";
		$nname = get_player_basename();
		output("`7Your new title will look like this: %s`0`n", $ntitle);
		output("`7Your entire name will look like: %s %s`0`n`n",
				$ntitle, $nname);
		output("`7Is this how you wish it to look?");
		addnav("`bConfirm Custom Title`b");
		addnav("Yes", "runmodule.php?module=titlechange&op=changetitle&newname=".rawurlencode($ntitle));
		addnav("No", "runmodule.php?module=titlechange&op=titlechange");
	}elseif ($op=="changetitle"){
		$ntitle=httpget('newname');
		$fromname = $session['user']['name'];
		$newname = change_player_ctitle($ntitle);
		$session['user']['ctitle'] = $ntitle;
		$session['user']['name'] = $newname;
		addnews("%s`^ has become known as %s.",$fromname,$session['user']['name']);
		set_module_pref("timespurchased", get_module_pref("timespurchased")+1);
		$session['user']['donationspent'] += get_module_setting("extrapoints");
		output("Your custom title has been set.");
		modulehook("namechange", array());
	}
	addnav("L?Return to the Lodge","lodge.php");
	page_footer();
}
?>
