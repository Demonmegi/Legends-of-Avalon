<?php
// addnews ready
// mail ready
// translator ready

function specialtyarcher_getmoduleinfo(){
	$spec_version = "1.1";
	$info = array(
		"name" => "Specialty - Archer",
		"author" => "Tizen",
		"version" => $spec_version,
		"download" => "http://dragonprime.net/users/Tizen/specialtyarcher.zip",
		"category" => "Specialties",
		"settings"=>array(
			"Specialty - Archer Settings,title",
			"Version ". $spec_version .",note",
			"mindk"=>"Minimum DK for specialty,int|1",
		),
		"prefs" => array(
			"Specialty - Archer User Prefs,title",
			"skill"=>"Skill points in Archer,int|0",
			"uses"=>"Uses of Archer allowed,int|0",
		),
	);
	return $info;
}

function specialtyarcher_install(){
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

function specialtyarcher_uninstall(){
	$sql = "UPDATE " . db_prefix("accounts") . " SET specialty='' WHERE specialty='AR'";
	db_query($sql);
	return true;
}

function specialtyarcher_dohook($hookname,$args){
	global $session,$resline;

	$spec = "AR";
	$name = "Archer";
	$ccode = "`^";

	switch ($hookname) {
	case "dragonkill":
		set_module_pref("uses", 0);
		set_module_pref("skill", 0);
		break;
	case "choose-specialty":
		if ($session['user']['specialty'] == "" || $session['user']['specialty'] == '0') {
			addnav("$ccode$name`0","newday.php?setspecialty=".$spec."$resline");
			$t1 = translate_inline("Sharp reflexes and a keen eye.");
			$t2 = appoencode(translate_inline("$ccode$name`0"));
			rawoutput("<a href='newday.php?setspecialty=$spec$resline'>$t1 ($t2)</a><br>");
			addnav("","newday.php?setspecialty=$spec$resline");
		}
		break;
	case "set-specialty":
		if($session['user']['specialty'] == $spec) {
			page_header($name);
			output("`6As a child, you always had better aim than the other kids. You could hit a small frog with a rock, 20 yards away.");
			output("Sadly, your father left when you were young and your mother needed help putting food on the table.");
			output("The old bow and arrows he left behind proved very valuable, and you quickly gained skill in their use.");
		}
		break;
	case "specialtycolor":
		$args[$spec] = $ccode;
		break;
	case "specialtynames":
		$args[$spec] = translate_inline($name);
		break;
	case "specialtymodules":
		$args[$spec] = "specialtyarcher";
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
			addnav(array("$ccode &#149; Double Strafe`7 (%s)`0", 1), 
					$script."op=fight&skill=$spec&l=1", true);
		}
		if ($uses > 1) {
			addnav(array("$ccode &#149; Owl's Eye`7 (%s)`0", 2),
					$script."op=fight&skill=$spec&l=2",true);
		}
		if ($uses > 2) {
			addnav(array("$ccode &#149; Vulture's Eye`7 (%s)`0", 3),
					$script."op=fight&skill=$spec&l=3",true);
		}
		if ($uses > 3) {
			addnav(array("$ccode &#149; Improve Concentration`7 (%s)`0", 4),
					$script."op=fight&skill=$spec&l=4",true);
		}
		if ($uses > 4) {
			addnav(array("$ccode &#149; Arrow Shower`7 (%s)`0", 5),
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
					apply_buff('ar1',array(
						"name"=>"`\$Double Strafe",
						"startmsg"=>"`^You begin firing twin arrows at {badguy} with your bow!",
						"wearoff"=>"Your arrows return to normal.",
						"rounds"=>4,
						"atkmod"=>2,
						"schema"=>"module-specialtyarcher"
					));
					break;
				case 2:
					apply_buff('ar2', array(
						"name"=>"`\$Owl's Eye",
						"startmsg"=>"`^Your vision clears and your arrows strike truer than ever!",
						"rounds"=>$session['user']['level'],
						"atkmod"=>1.75,
						"roundmsg"=>"`^You see clearly, and take careful aim...",
						"wearoff"=>"Your vision returns to normal.",
						"schema"=>"module-specialtyarcher"
					));
					break;
				case 3:
					apply_buff('ar3', array(
						"name"=>"`\$Vulture's Eye",
						"startmsg"=>"`^Your rage boils over, and your eyes gleam with hatred for {badguy}.",
						"rounds"=>3,
						"atkmod"=>1 + ($session['user']['level'] * .2),
						"roundmsg"=>"`^The gleam in your eyes strips {badguy} of its defenses.",
						"wearoff"=>"The look in your eyes has faded.",
						"schema"=>"module-specialtyarcher"
					));
					break;
				case 4:
					apply_buff('ar4', array(
						"name"=>"`\$Improve Concentration",
						"startmsg"=>"`^You concentrate solely on conquering your enemy, {badguy}.",
						"rounds"=>8,
						"atkmod"=>1.5,
						"defmod"=>1.5,
						"roundmsg"=>"`^Your deep state of concentration has increased your attack and defenses!",
						"wearoff"=>"You lose your concentration.",
						"schema"=>"module-specialtyarcher"
					));
					break;
				case 5:
					apply_buff('ar5',array(
						"name"=>"`\$Arrow Shower",
						"startmsg"=>"`^You fire a volley of arrows at {badguy}!",
						"rounds"=>1,
						"atkmod"=>11,
						"defmod"=>11,
						"schema"=>"module-specialtyswordsman"
					));
					break;
				}
				set_module_pref("uses", get_module_pref("uses") - $l);
			}else{
				apply_buff('ar0', array(
					"startmsg"=>"You try to attack {badguy} by putting your best archer skills into practice, but instead, you trip over your own feet.",
					"rounds"=>1,
					"schema"=>"module-specialtyarcher"
				));
			}
		}
		break;
	}
	return $args;
}

function specialtyarcher_run(){
}
?>
