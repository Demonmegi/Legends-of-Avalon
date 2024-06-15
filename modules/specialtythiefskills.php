<?php
//addnews ready
// mail ready
// translator ready

function specialtythiefskills_getmoduleinfo(){
	$info = array(
		"name" => "Specialty - Thieving Skills",
		"author" => "Eric Stevens<br>modified for lotgd.de by `&Za`7nzam`&ar",
		"version" => "1.1",
		"download" => "core_module",
		"category" => "Specialties",
		"prefs" => array(
			"Specialty - Thieving Skills User Prefs,title",
			"skill"=>"Skill points in Thieving Skills,int|0",
			"uses"=>"Uses of Thieving Skills allowed,int|0",
		),
	);
	return $info;
}

function specialtythiefskills_install(){
	$sql = "DESCRIBE " . db_prefix("accounts");
	$result = db_query($sql);
	$specialty="TS";
	while($row = db_fetch_assoc($result)) {
		// Convert the user over
		if ($row['Field'] == "thievery") {
			debug("Migrating thieving skills field");
			$sql = "INSERT INTO " . db_prefix("module_userprefs") . " (modulename,setting,userid,value) SELECT 'specialtythiefskills', 'skill', acctid, thievery FROM " . db_prefix("accounts");
			db_query($sql);
			debug("Dropping thievery field from accounts table");
			$sql = "ALTER TABLE " . db_prefix("accounts") . " DROP thievery";
			db_query($sql);
		} elseif ($row['Field']=="thieveryuses") {
			debug("Migrating thieving skills uses field");
			$sql = "INSERT INTO " . db_prefix("module_userprefs") . " (modulename,setting,userid,value) SELECT 'specialtythiefskills', 'uses', acctid, thieveryuses FROM " . db_prefix("accounts");
			db_query($sql);
			debug("Dropping thieveryuses field from accounts table");
			$sql = "ALTER TABLE " . db_prefix("accounts") . " DROP thieveryuses";
			db_query($sql);
		}
	}
	debug("Migrating Thieving Skills Specialty");
	$sql = "UPDATE " . db_prefix("accounts") . " SET specialty='$specialty' WHERE specialty='3'";
	db_query($sql);

	module_addhook("choose-specialty");
	module_addhook("set-specialty");
	module_addhook("fightnav-specialties");
	module_addhook("apply-specialties");
	module_addhook("newday");
	module_addhook("incrementspecialty");
	module_addhook("specialtynames");
	module_addhook("specialtymodules");
	module_addhook("specialtycolor");
	module_addhook("dragonkill");
	return true;
}

function specialtythiefskills_uninstall(){
	// Reset the specialty of anyone who had this specialty so they get to
	// rechoose at new day
	$sql = "UPDATE " . db_prefix("accounts") . " SET specialty='' WHERE specialty='TS'";
	db_query($sql);
	return true;
}

function specialtythiefskills_dohook($hookname,$args){
	global $session,$resline;

	$spec = "TS";
	$name = "Thieving Skills";
	$ccode = "`^";

	switch ($hookname) {
	case "dragonkill":
		set_module_pref("uses", 0);
		set_module_pref("skill", 0);
		break;
	case "choose-specialty":
		if ($session['user']['specialty'] == "" ||
				$session['user']['specialty'] == '0') {
			addnav("$ccode$name`0","newday.php?setspecialty=".$spec."$resline");
			$t1 = translate_inline("Stealing from the rich and giving to yourself");
			$t2 = appoencode(translate_inline("$ccode$name`0"));
			rawoutput("<a href='newday.php?setspecialty=$spec$resline'>$t1 ($t2)</a><br>");
			addnav("","newday.php?setspecialty=$spec$resline");
		}
		break;
	case "set-specialty":
		if($session['user']['specialty'] == $spec) {
			page_header($name);
			output("`6Growing up, you recall discovering that a casual bump in a crowded room could earn you the coin purse of someone otherwise more fortunate than you.");
			output("You also discovered that the back side of your enemies were considerably more prone to a narrow blade than the front side was to even a powerful weapon.");
		}
		break;
	case "specialtycolor":
		$args[$spec] = $ccode;
		break;
	case "specialtynames":
		$args[$spec] = translate_inline($name);
		break;
	case "specialtymodules":
		$args[$spec] = "specialtythiefskills";
		break;
	case "incrementspecialty":
		if($session['user']['specialty'] == $spec) {
			$new = get_module_pref("skill") + 1;
			set_module_pref("skill", $new);
			$name = translate_inline($name);
			$c = $args['color'];
			output("`n%sYou gain a level in `&%s%s to `#%s%s!",
					$c, $name, $c, $new, $c);
			$x = $new % 3;
			if ($x == 0){
				output("`n`^You gain an extra use point!`n");
				set_module_pref("uses", get_module_pref("uses") + 1);
			}else{
				if (3-$x == 1) {
					output("`n`^Only 1 more skill level until you gain an extra use point!`n");
				} else {
					output("`n`^Only %s more skill levels until you gain an extra use point!`n", (3-$x));
				}
			}
			output_notl("`0");
		}
		break;
	case "newday":
		$bonus = getsetting("specialtybonus", 1);
		if($session['user']['specialty'] == $spec) {
			$name = translate_inline($name);
			if ($bonus == 1) {
				output("`n`2For being interested in %s%s`2, you receive `^1`2 extra `&%s%s`2 use for today.`n",$ccode,$name,$ccode,$name);
			} else {
				output("`n`2For being interested in %s%s`2, you receive `^%s`2 extra `&%s%s`2 uses for today.`n",$ccode,$name,$bonus,$ccode,$name);
			}
		}
		$amt = (int)(get_module_pref("skill") / 3);
		if ($session['user']['specialty'] == $spec) $amt = $amt + $bonus;
		set_module_pref("uses", $amt);
		break;
	case "fightnav-specialties":
		$uses = get_module_pref("uses");
		$script = $args['script'];
		if ($uses > 0) {
			addnav(array("$ccode$name (%s points)`0", $uses), "");
			addnav(array("$ccode &#149; Diebstahl`7 (%s)`0", 1), 
					$script."op=fight&skill=$spec&l=1", true);
		}
		if ($uses > 1) {
			addnav(array("$ccode &#149; Waffe Vergiften`7 (%s)`0", 2),
					$script."op=fight&skill=$spec&l=2",true);
		}
		if ($uses > 2) {
			addnav(array("$ccode &#149; Sand in ihren Augen`7 (%s)`0", 3),
					$script."op=fight&skill=$spec&l=3",true);
		}
		if ($uses > 4) {
			addnav(array("$ccode &#149; Angriff von Hinten`7 (%s)`0", 5),
					$script."op=fight&skill=$spec&l=5",true);
		}
		break;
	case "apply-specialties":
		$skill = httpget('skill');
		$l = httpget('l');
		if ($skill==$spec){
			if (get_module_pref("uses") >= $l){
				switch($l){
				case 1:
					$swi = e_rand(1,5);
					switch($swi){
						case 1:
						case 2:
							$snatch = e_rand($session['user']['level']*10,$session['user']['level']*50);
							$startmsg = translate_inline("`^Unbemerkt ziehst du {badguy}`^ $snatch Gold aus der Tasche!");
							$session['user']['gold']+= $snatch;
							break;
						case 3:
						case 4:
							//require_once("lib/itemhandler.php");
            	//if ($swi == 3) {
            		//$snatch = get_random_item('Loot');
            	//}else{
            		//$snatch = get_random_item('Nahrung');
            	//}
            	//$startmsg = translate_inline("`^Unbemerkt ziehst du {badguy}`^ folgendes aus der Tasche: $snatch['name']");
            	//add_item((int)$snatch['itemid']);
            	//break;
            case 5:
            	$startmsg = translate_inline("`^Als {badguy}`^ dich bei deinem Versuch erwischt und beinahe in zwei Stücke teilt, fragst du dich, warum du ihn überhaupt bestehlen willst, wenn du ihn doch sowieso kaltstellen musst!");
            	break;
          }
					apply_buff('ts1',array(
						"startmsg"=>"$startmsg",
						"rounds"=>1,
						"badguydmgmod"=>1.1,
						"schema"=>"module-specialtythiefskills"
					));
					break;
				case 2:
					apply_buff('ts2',array(
						"startmsg"=>"`^Du trägst etwas Gift auf {weapon}`^ auf.",
						"name"=>"`^Waffe Vergiften",
						"rounds"=>$session['user']['level'],
						"wearoff"=>"`6Das Blut deiner Opfer hat das Gift von {weapon}`6 gewaschen.",
						"atkmod"=>1.2,
						"damageshield"=>-0.33,
						"effectmsg"=>"`6Das Gift richtet zusätzliche `^{damage}`6 Schadenspunkte bei {badguy} an!", 
						"schema"=>"module-specialtythiefskills"
					));
					break;
				case 3:
					apply_buff('ts3', array(
						"startmsg"=>"`^Mit einem kraftvollen Tritt schleuderst du {badguy}`^ einen Schwall Sand ins Gesicht!",
						"name"=>"`^Sand in ihren Augen",
						"rounds"=>3,
						"wearoff"=>"`6Die Augen deines Opfers haben sich wieder erholt.",
						"badguyatkmod"=>0.45,
						"badguydefmod"=>0.45,
						"roundmsg"=>"`^{badguy} `^kann nichts mehr sehen und schlägt wild um sich!",
						"badguyatkmod"=>0,
						"schema"=>"module-specialtythiefskills"
					));
					apply_buff('ts3b', array(
						"name"=>"`^Dreck",
						"rounds"=>1,
						"minioncount"=>1,
						"minbadguydamage"=>floor($session['user']['attack']/2),
						"maxbadguydamage"=>$session['user']['level']+$session['user']['attack']/2,
						"effectmsg"=>"`6{badguy} `6kratzt sich vor Schmerz beinahe selbst die Augen aus und erleidet `^{damage}`6 Punkte Schaden!",
						"schema"=>"module-specialtythiefskills"
					));
					break;
				case 5:
					apply_buff('ts5',array(
						"startmsg"=>"`^Mit den Fähigkeiten eines Meisterdiebs verschwindest du und schiebst {badguy} eine dünne Klinge zwischen die Rückenwirbel!",
						"name"=>"`^Angriff von Hinten",
						"rounds"=>1,
						"atkmod"=>4,
						"defmod"=>2,
						"schema"=>"module-specialtythiefskills"
					));
					break;
				}
				set_module_pref("uses", get_module_pref("uses") - $l);
			}else{
				apply_buff('ts0', array(
					"startmsg"=>"You try to attack {badguy} by putting your best thievery skills into practice, but instead, you trip over your feet.",
					"rounds"=>1,
					"schema"=>"module-specialtythiefskills"
				));
			}
		}
		break;
	}
	return $args;
}

function specialtythiefskills_run(){
}
?>
