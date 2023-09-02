<?php
/*

This is part of a series of specialties I'm making to recreate the core D&D classes in LoGD.
This also works well as a basic drop-in specialty because the core specialties are basically
a thief, and two magic users.  The game really needs a basic Fighter specialty, IMO.

-- Enderandrew

*/

function specialtyfighter_getmoduleinfo(){
	$info = array(
		"name" => "Specialty - Fighter",
		"author" => "`!Enderandrew",
		"version" => "1.11",
		"download" => "http://dragonprime.net/users/enderwiggin/specialityfighter.zip",
		"vertxtloc"=>"http://dragonprime.net/users/enderwiggin/",
		"category" => "Specialties",
		"description"=>"This adds a D&D inspired Fighter specialty to the game.",
		"prefs" => array(
			"Specialty - Fighter User Prefs,title",
			"skill"=>"Skill points in Fighter Feats,int|0",
			"uses"=>"Uses of Fighter Feats allowed,int|0",
		),
		"settings"=> array(
			"Specialty - Fighter Settings,title",
			"mindk"=>"How many DKs do you need before the specialty is available?,int|5",
			"cost"=>"How many points do you need before the specialty is available?,int|5",
		),
	);
	return $info;
}

function specialtyfighter_install(){
	$specialty="FI";
	module_addhook("apply-specialties");
	module_addhook("castlelib");
	module_addhook("castlelibbook");
	module_addhook("choose-specialty");
	module_addhook("dragonkill");
	module_addhook("fightnav-specialties");
	module_addhook("incrementspecialty");
	module_addhook("newday");
	module_addhook("pointsdesc");
	module_addhook("set-specialty");
	module_addhook("specialtycolor");
	module_addhook("specialtymodules");
	module_addhook("specialtynames");
	return true;
}

function specialtyfighter_uninstall(){
	// Reset the specialty of anyone who had this specialty so they get to
	// rechoose at new day
	$sql = "UPDATE " . db_prefix("accounts") . " SET specialty='' WHERE specialty='FI'";
	db_query($sql);
	return true;
}

function specialtyfighter_dohook($hookname,$afis){
	global $session,$resline;
	tlschema("fightnav");

	$spec = "FI";
	$name = "Kaempfer-Faehigkeiten";
	$ccode = "`2";
	$cost = get_module_setting("cost");
	$op69 = httpget('op69');

	switch ($hookname) {

	case "apply-specialties":
		$skill = httpget('skill');
		$l = httpget('l');
		if ($skill==$spec){
			if (get_module_pref("uses") >= $l){
				switch($l){
				case 1:
					apply_buff('fi1', array(
						"startmsg"=>"`2You're tired of dinking around.  It's time to cleave some skulls!",
						"name"=>"`@Cleave",
						"rounds"=>5,
						"wearoff"=>"You begin to tire...",
						"effectmsg"=>"`@With grim determination you smash `^{badguy}`6 for `^{damage}`) points.",
						"effectnodmgmsg"=>"`@You strike at {badguy} with all your strike, but you still MISS!",
						"atkmod"=>1.5,
						"schema"=>"specialtyfighter"
					));
					break;
				case 2:
					apply_buff('fi2', array(
						"startmsg"=>"`2Your finely-honed skill in combat allows you to react quickly and riposte more often!",
						"name"=>"`@Combat Reflexes",
						"rounds"=>5,
						"wearoff"=>"Your begin to slow down.",
						"effectmsg"=>"`@You quickly jump on {badguy} and strike for {damage} damage.",
						"defmod"=>1.6,
						"schema"=>"specialtyfighter"
					));
					break;
				case 3:
					apply_buff('fi3', array(
						"startmsg"=>"`2You pour all of your strength into battering down {badguy}'s weaponry and armor.",
						"name"=>"`@Improved Sunder",
						"rounds"=>5,
						"wearoff"=>"You tire from outpouring so much raw strength.",
						"effectmsg"=>"`@You jump on {badguy}'s weakened state and strike for {damage} damage.",
						"effectnodmgmsg"=>"`@Despite {badguy}'s weakened state, you still MISS!",
						"badguydefmod"=>0.5,
						"badguyatkmod"=>0.5,
						"schema"=>"specialtyfighter"
					));
					break;
				case 5:
					apply_buff('fi5', array(
						"startmsg"=>"`2In anime-esque fashion you unleash your full arsenal of rapid, brutal attacks at once.",
						"name"=>"`@Whirlwind Attack",
						"rounds"=>3,
						"wearoff"=>"You give it your all and are spent...",
						"effectmsg"=>"`@Screaming furiously with blood-curdling rage, you strike `^{badguy}`6 for `^{damage}`) points.",
						"effectnodmgmsg"=>"`@Perhaps you swung too violently and wildly because you miss {badguy}!",
						"atkmod"=>3.5,
						"schema"=>"specialtyfighter"
					));
					break;
				}
				set_module_pref("uses", get_module_pref("uses") - $l);
			}else{
				apply_buff('fi0', array(
					"startmsg"=>"You twirl your weapon to intimidate your opponent, but stub your toe accidentally.",
					"rounds"=>1,
					"schema"=>"specialtyfighter"
				));
			}
		}
		break;

	case "castlelib":
		if ($op69 == 'fighter'){
			output("You sit down and open up the Book of Five Rings.`n");
			output("You read for a while... in the time it takes you to read you use up`n");
			output("3 Turns.`n`n");
			output("To learn a Japanese martial art is to learn Zen, and although you can't do so simply by reading `n");
			output("a book, it sure does help--especially if that book is The Book of Five Rings.  Unlike it's more`n");
			output("famous cousin, The Art of War, this book doesn't deal with vague general strategies.  This is a`n");
			output("fairly specific treatise on the art of martial warfare.`n");
			output("`@You become more skilled as a Fighter!`n");
			$session['user']['turns']-=3;
			set_module_pref('skill',(get_module_pref('skill','specialtyfighter') + 1),'specialtyfighter');
			set_module_pref('uses', get_module_pref("uses",'specialtyfighter') + 1,'specialtyfighter');
			addnav("Continue","runmodule.php?module=lonnycastle&op=library");
			}
		break;

	case "castlelibbook":
		output("Book of Five Rings. (3 Turns)`n");
		addnav("Read a Book");
		addnav("Book of Five Rings","runmodule.php?module=lonnycastle&op=library&op69=fighter");
		break;

	case "choose-specialty":
		if ($session['user']['dragonkills']>=get_module_setting("mindk")) {
			if ($session['user']['specialty'] == "" ||
				$session['user']['specialty'] == '0') {
				addnav("$ccode$name`0","newday.php?setspecialty=".$spec."$resline");
				$t1 = translate_inline("Swinging around swords and shields");
				$t2 = appoencode(translate_inline("$ccode$name`0"));
				rawoutput("<a href='newday.php?setspecialty=$spec$resline'>$t1 ($t2)</a><br>");
				addnav("","newday.php?setspecialty=$spec$resline");
			}
		}
		break;

	case "dragonkill":
		set_module_pref("uses", 0);
		set_module_pref("skill", 0);
		break;

	case "fightnav-specialties":
		$uses = get_module_pref("uses");
		$script = $afis['script'];
		if ($uses > 0) {
			addnav(array("%s%s (%s points)`0", $ccode, $name, $uses), "");
			addnav(array("%s &#149; Cleave`7 (%s)`0", $ccode, 1), 
					$script."op=fight&skill=$spec&l=1", true);
		}
		if ($uses > 1) {
			addnav(array("%s &#149; Combat Reflexes`7 (%s)`0", $ccode, 2),
					$script."op=fight&skill=$spec&l=2",true);
		}
		if ($uses > 2) {
			addnav(array("%s &#149; Improved Sunder`7 (%s)`0", $ccode, 3),
					$script."op=fight&skill=$spec&l=3",true);
		}
		if ($uses > 4) {
			addnav(array("%s &#149; Whirlwind Attack`7 (%s)`0", $ccode, 5),
					$script."op=fight&skill=$spec&l=5",true);
		}
		break;

	case "incrementspecialty":
		if($session['user']['specialty'] == $spec) {
			$new = get_module_pref("skill") + 1;
			set_module_pref("skill", $new);
			$c = $afis['color'];
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
			if ($bonus == 1) {
				output("`n`2For being interested in %s%s`2, you receive `^1`2 extra `&%s%s`2 use for today.`n",$ccode,$name,$ccode,$name);
			} else {
				output("`n`2For being interested in %s%s`2, you receive `^%s`2 extra `&%s%s`2 uses for today.`n",$ccode,$name,$bonus,$ccode,$name);
			}
		}
		$amt = (int)(get_module_pref("skill") / 3);
		if ($session['user']['specialty'] == $spec) $amt++;
		set_module_pref("uses", $amt);
		break;

	case "pointsdesc":
		$cost = get_module_setting("cost");
		if ($cost > 0){
			$afis['count']++;
			$format = $afis['format'];
			$str = translate("The Fighter Specialty is availiable upon reaching %s Dragon Kills and %s points.");
			$str = sprintf($str, get_module_setting("mindk"),$cost);
		}
		output($format, $str, true);
		break;

	case "set-specialty":
		if($session['user']['specialty'] == $spec) {
			page_header($name);
			$session['user']['donationspent'] = $session['user']['donationspent'] + $cost;
			output("`2Whether driven by frustration, the desire to bully, or the desire to become a hero, ");
			output("You decided to spend your childhood days and nights studying the ways of martial warfare. ");
			output("It also could be that you had inordinate fascination with all things sharp and pointy. ");
			output("Maybe you were trying to cover up, and deal with some internal inadequacy or face some ");
			output("demon of your youth.  I never really thought about this before, but we could probably ");
			output("spend days psycho-analyzing why you decided to pursue a career in killing things.`n`n");
			output("Then again, considering you're a trained killing machine, maybe I'll just drop the subject ");
			output("and be on my merry way...`n`n");
		}
		break;

	case "specialtycolor":
		$afis[$spec] = $ccode;
		break;

	case "specialtymodules":
		$afis[$spec] = "specialtyfighter";
		break;

	case "specialtynames":
		$pointsavailable = $session['user']['donation'] - $session['user']['donationspent'];
		if ($session['user']['superuser'] & SU_EDIT_USERS || $session['user']['dragonkills'] >= get_module_setting("mindk") || get_module_setting("cost") <= $pointsavailable){
			$afis[$spec] = translate_inline($name);
		}
		break;
	}
	return $afis;
}

function specialtyfighter_run(){
}
?>