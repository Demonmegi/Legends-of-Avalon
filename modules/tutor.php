<?php
// addnews ready
// mail ready
// translator ready

function tutor_getmoduleinfo(){
	$info = array(
		"name"=>"In-game tutor",
		"author"=>"Booger & Shannon Brown & JT Traub",
		"version"=>"1.0",
		"category"=>"Administrative",
		"download"=>"core_module",
		"prefs"=>array(
			"In-Game tutor User Preferences,title",
			"user_ignore"=>"Turn off the tutor help?,bool|0",
			"seenforest"=>"Has the player seen the forest instructions,bool|0",
			),
		);
	return $info;
}

function tutor_install(){
	module_addhook("everyheader-loggedin");
	module_addhook("newday");
	module_addhook("village");
	module_addhook("battle");
	return true;
}

function tutor_uninstall(){
	return true;
}

function tutor_dohook($hookname,$args){
	global $session;
	$age = $session['user']['age'];
	$ignore = get_module_pref("user_ignore");

// Wenn diese Person bereits außerhalb des Tutoring-Bereichs ist, einfach zurückgeben
if ($session['user']['dragonkills'] || $ignore || $age >= 11) {
    return $args;
}

switch ($hookname) {
    case "newday":
        set_module_pref("seenforest", 0);
        break;
    case "village":
        if ($age < 11) {
            tlschema($args['schemas']['gatenav']);
            addnav($args["gatenav"]);
            tlschema();
            addnav("*?`\$Hilf mir, ich bin verloren!", "runmodule.php?module=tutor&op=helpfiles");
            unblocknav("runmodule.php?module=tutor&op=helpfiles");
        };
        break;
    case "battle":
        global $options;
        $badguy = $args[0];
        $tutormsg = "";
        if ($badguy['creaturehealth'] > 0 && $badguy['creaturelevel'] > $session['user']['level'] && $options['type'] == 'forest'){
            $tutormsg = translate_inline("`#Deman`0 sieht aufgeregt aus!  \"`\$Pass auf!`3 Dieses Wesen scheint eine höhere Stufe als du zu haben! Du solltest `^weglaufen`3! Du könntest nicht erfolgreich sein, aber versuche es und hoffe, dass du entkommst, bevor du zu Waldboden wirst!`0\"`n");
        }
        if ($tutormsg) tutor_talk("%s", $tutormsg);
    case "everyheader-loggedin":
        $adef = $session['user']['armordef'];
        $wdam = $session['user']['weapondmg'];
        $gold = $session['user']['gold'];
        $goldinbank = $session['user']['goldinbank'];
        $goldtotal = $gold + $goldinbank;
        if (!isset($args['script']) || !$args['script']) break;
        switch ($args['script']) {
            case "newday":
                if ($age > 1) break;
                if ((!$session['user']['race'] ||
                    $session['user']['race'] == RACE_UNKNOWN) &&
                    httpget("setrace") == "") {
                    if (is_module_active("racetroll"))
                        $troll = translate_inline("Troll");
                    if (is_module_active("racedwarf"))
                        $dwarf = translate_inline("Zwerg");
                    if (is_module_active("racehuman"))
                        $human = translate_inline("Mensch");
                    if (is_module_active("raceelf"))
                        $elf = translate_inline("Elf");
                    if ($troll || $dwarf || $human || $elf) {
                        $tutormsg = translate_inline("`0Ein winziger `#aqua-farbener Kobold`0 fliegt auf und summt für einen Moment neben deinem Kopf.`n`n\"`&Wha-wha-wha...`0\" stammelst du.`n`n\"`#Oh, hör auf zu reden! Du sollst mir zuhören, nicht sprechen!`0\" quietscht der Kobold.`n`n\"`#Jetzt, ich bin hier, um dir dabei zu helfen, dich mit diesen Reichen vertraut zu machen, also besser hör gut zu, was ich zu sagen habe.`0\"`n`nDu nickst einen Moment lang dumm und gibst diesem Wesen deine Aufmerksamkeit.`n`n\"`#Jetzt,`0\" sagt er,\" `#du bist noch jung und vielleicht erinnerst du dich nicht mehr daran, wo du aufgewachsen bist. Wenn du noch nie hier drin warst, ist die Auswahl einer dieser Optionen wahrscheinlich am einfachsten!`0\" Er springt aufgeregt herum und wartet auf deine Entscheidung, und hält eine Liste von Vorschlägen vor dir.`n");
                        tutor_talk("%s`c`b`#%s`n%s`n%s`n%s`n`b`c", $tutormsg, $troll, $elf, $human, $dwarf);
                    };
                } elseif ($session['user']['specialty'] == "" && !httpget("setrace")) {
                    if (is_module_active("specialtydarkarts"))
                        $da = translate_inline("Dunkle Künste");
                    if (is_module_active("specialtymysticpower"))
                        $mp = translate_inline("Mystische Kräfte");
                    if (is_module_active("specialtythiefskills"))
                        $ts = translate_inline("Diebstahl-Fähigkeiten");
                    if ($da || $mp || $ts) {
                        $tutormsg = translate_inline("`0Der Käfer flattert um dich herum, egal wie sehr du versuchst, ihn aus dem Blickfeld zu schlagen. Einen Moment später kehrt sein durchdringendes Geplapper zurück.`n`n\"`#Oh, schau, noch mehr Entscheidungen! Ich nehme an, du möchtest jetzt Berufsberatung, oder?`0\"`n`nEr fliegt herum, bevor er sagt, \"`#Warum nicht zuerst eine dieser ausprobieren, damit du nicht über deine eigenen Schnürsenkel stolperst?`0\"`n`nEr hält dir eine kleine Schriftrolle vor, die mit kleinen Schriftzeichen versehen ist, und wartet auf deine Entscheidung.`n");
                        tutor_talk("%s`c`b`#%s`n%s`n%s`b`c", $tutormsg, $da, $mp, $ts);
                    }
                }
                break;
            case "village":
                $tutormsg = "";
                if ($wdam == 0 && $gold >= 48) {
                    $tutormsg = translate_inline("\"`3Du solltest wirklich eine Waffe besorgen, um stärker zu werden. Du kannst eine im `^Waffengeschäft`3 kaufen. Ich treffe dich dort! -Deman`0\"`n");
                } elseif ($wdam == 0 && $goldtotal >= 48) {
                    $tutormsg = translate_inline("\"`3Wir müssen etwas Gold aus `^der Bank`3 abheben, um eine Waffe zu kaufen. Komm mit mir! -Deman`0\"`n");
                } elseif ($adef == 0 && $gold >= 48) {
                    $tutormsg = translate_inline("\"`3Du wirst nicht sehr sicher sein, ohne Rüstung! Das `^Rüstungsgeschäft`3 hat eine schöne Auswahl. Los geht's! -Deman`0\"`n");
                } elseif ($adef == 0 && $goldtotal >= 48) {
                    $tutormsg = translate_inline("\"`3Wir müssen etwas Gold aus `^der Bank`3 abheben, damit wir uns etwas Rüstung kaufen können! -Deman`0\"`n");
                } elseif (!$session['user']['experience']) {
                    $tutormsg = translate_inline("\"`3Der `^Wald`3 ist auch einen Besuch wert. Hier gewinnst du Erfahrung und Gold! -Deman`0\"`n");
                } elseif ($session['user']['experience'] > 100 && $session['user']['level'] == 1 && !$session['user']['seenmaster']) {
                    $tutormsg = translate_inline("\"`3Heilige Rauchwolken! Du steigst so schnell auf! Du hast genug Erfahrung, um Stufe 2 zu erreichen. Du solltest das `^Kriegertraining`3 finden und deinen Meister herausfordern! Danach wirst du feststellen, dass du viel mächtiger bist. -Deman`0\"`n");
                }
                if ($tutormsg) tutor_talk("%s", $tutormsg);
                break;
            case "forest":
                $tutormsg = "";
                if ($goldtotal >= 48 && $wdam == 0) {
                    $tutormsg = translate_inline("\"`3Hey, du hast genug Gold, um eine Waffe zu kaufen. Es könnte eine gute Idee sein, jetzt `^in die Stadt`3 zu gehen und einkaufen zu gehen! -Deman`0\"`n");
                } elseif ($goldtotal >= 48 && $adef == 0) {
                    $tutormsg = translate_inline("\"`3Hey, du hast genug Gold, um etwas Rüstung zu kaufen. Es könnte eine gute Idee sein, jetzt `^in die Stadt`3 zu gehen und einkaufen zu gehen! -Deman`0\"`n");
                } elseif (!$session['user']['experience'] && !get_module_pref("seenforest")) {
                    $tutormsg = translate_inline("`#Deman`& sagt: \"`3Hier gibt es nicht viel zu sagen. Kämpfe gegen Monster, gewinne Gold, heile dich, wenn du musst. Vor allem: Hab Spaß!`0\"`n`nEr fliegt zurück zum Dorf.`n`nÜber seine Schulter ruft er aus, \"`3Bevor ich gehe, lies bitte die FAQs... und die Nachricht des Tages ist etwas, das du jedes Mal überprüfen solltest, wenn du dich anmeldest. Scheue dich nicht zu erkunden, aber scheue dich nicht zu fliehen! Und denk daran, sterben gehört zum Leben dazu!`0\"`n");
                    set_module_pref("seenforest", 1);
                };
                if ($tutormsg) tutor_talk("%s", $tutormsg);
                break;
        }
        break;
}
return $args;
}

function tutor_talk() {
	rawoutput("<style type='text/css'>
		.tutor {
			background-color: #444444;
			border-color: #0099ff;
			border-style: double;
			border-width: medium;
			color: #CCCCCC;
		}
		.tutor .colDkBlue	{ color: #0000B0; }
		.tutor .colDkGreen   { color: #00B000; }
		.tutor .colDkCyan	{ color: #00B0B0; }
		.tutor .colDkRed	 { color: #B00000; }
		.tutor .colDkMagenta { color: #B000CC; }
		.tutor .colDkYellow  { color: #B0B000; }
		.tutor .colDkWhite   { color: #B0B0B0; }
		.tutor .colLtBlue	{ color: #0000FF; }
		.tutor .colLtGreen   { color: #00FF00; }
		.tutor .colLtCyan	{ color: #00FFFF; }
		.tutor .colLtRed	 { color: #FF0000; }
		.tutor .colLtMagenta { color: #FF00FF; }
		.tutor .colLtYellow  { color: #FFFF00; }
		.tutor .colLtWhite   { color: #FFFFFF; }
		.tutor .colLtBlack   { color: #999999; }
		.tutor .colDkOrange  { color: #994400; }
		.tutor .colLtOrange  { color: #FF9900; }
		</style>");
	$args = func_get_args();
	$args[0] = translate($args[0]);
	$text = call_user_func_array("sprintf", $args);
	rawoutput("<div class='tutor'>");
	rawoutput(tlbutton_clear().appoencode($text));
	rawoutput("</div>");
}

function tutor_runevent($type){
}

function tutor_run(){
	global $session;
	$op = httpget("op");
	$city= getsetting("villagename", LOCATION_FIELDS); // name of capital city
	$iname = getsetting("innname", LOCATION_INN); // name of capital's inn
	$age = $session['user']['age'];
	if ($op=="helpfiles") {
		page_header("Help!");
		output("`%`c`bHelp Me, I'm Lost!`b`c`n");
		output("`@Feeling lost?`n`n");
		output("`#Legend of the Green Dragon started out small, but with time it has collected many new things to explore.`n`n");
		output("To a newcomer, it can be a little bit daunting.`n`n");
		output("To help new players, the Central staff created Deman, the imp.");
		output("He's the little blue guy who told you to buy weapons when you first joined, and helped you choose a race.");
		output("But what happens next, where should you go, and what are all the doors, alleys, and shops for?`n`n");
		output("First of all: The game is about discovery and adventure.");
		output("For this reason, you won't find all the answers to every little question.");
		output("For most things, you should read the FAQs, or just try them and see.`n`n");
		output("But we recognize that some things aren't at all obvious.");
		output("So while we won't tell you what everything does, we've put together a list of things that you might want to try first, and that new players commonly ask us.`n`n");
		output("Please understand that these hints are spoilers.");
		output("If you'd rather discover on your own, don't read any further.`n`n");
		output("`%What are all those things in my Vital Info, and Personal Info, I'm confused?");
		output("A lot of it you don't need to worry about for the most part.");
		output("The ones you should watch carefully are your hitpoints, and your experience.");
		output("Ideally, you should keep that hitpoint bar green.");
		output("And beware if it begins to turn yellow, or worse still, red.");
		output("That tells you that death is near.");
		output("Sometimes running would be smarter than risking death.");
		output("Perhaps there's someone close by who can help you feel better.`n`n");
		output("Lower down is the experience bar, which starts all red, and will gradually fill up with white.");
		output("Wait until it goes blue before you challenge your master.");
		output("If you can't see a blue bar, you aren't ready yet!`n`n");
		output("Looking for someone you know?");
		output("The List Warriors area will tell you if your friend is online right now or not.");
		output("If they are, Ye Olde Mail is a good way to contact them.`n`n");
		output("What are gems for?");
		output("Hang onto these and be careful how you spend them.");
		output("There are some things that you can only obtain with gems.`n`n");
		output("Have you been into %s, in %s? Perhaps you'd like to try a drink, listen to some entertainment, or chat to people.",$iname, $city);
		output("It's also a good idea to get to know the characters in the %s, because they can be quite helpful to a young warrior.",$iname);
		output("You might even decide that sleeping in %s would be safer than in the fields.`n`n",$iname);
		output("Travelling can be dangerous.");
		output("Make sure you've placed your valuables somewhere safe, and that you're feeling healthy before you leave.`n`n");
		output("Hungry, tired, feeling adventurous, or looking for a pet?");
		output("The Spa, the Kitchen, the Tattoo Parlor, and the Stables are all places you might want to visit.");
		output("These things are just some of the shops in different towns.");
		output("Some of them give turns, charm or energy, and some take it away.`n`n");
		output("Where's the dragon?");
		output("They all ask this.");
		output("You'll see her when you are ready to fight her, and not before, and you will need to be patient and build your strength while you wait.`n`n");
		output("`QIf you have any questions which are not covered in the FAQ, you may wish to Petition for Help - bear in mind that the staff won't give you the answer if it will spoil the game for you.");
		villagenav();
		page_footer();
	}
}
?>
