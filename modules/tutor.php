<?php
// addnews ready
// mail ready
// translator ready

function tutor_getmoduleinfo(){
	$info = array(
		"name"=>"In-game tutor",
		"author"=>"Booger & Shannon Brown & JT Traub, minor modifications and translation by `8Or`4ia`\$n`4n`8a",
		"version"=>"1.0",
		"category"=>"Administrative",
		"download"=>"core_module",
		"prefs"=>array(
			"In-Game User Preferences,title",
			"user_ignore"=>"Turn off the tutor help?,bool|0",
			"seenforest"=>"Has the player seen the forest instructions,bool|0",
			),
		);
	return $info;
}

function tutor_install(){
	module_addhook("everyheader");
	module_addhook("newday");
	module_addhook("village");
	module_addhook("battle");
	module_addhook("shades");
	module_addhook("graveyard");
	module_addhook("ramiusfavors");
	return true;
}

function tutor_uninstall(){
	return true;
}

function tutor_dohook($hookname,$args){
	global $session;
	$age = 0;
	if (isset($session['user']['age'])) {
		$age = $session['user']['age'];
	}
	$ignore = get_module_pref("user_ignore");

	// If this person is already well out of tutoring range, just return
	if ((!isset($session['user']['dragonkills'])) || $session['user']['dragonkills'] || $ignore || $age >= 11) {
		return $args;
	}

	switch($hookname){
	case "newday":
		set_module_pref("seenforest", 0);
		break;
	case "village":
		if ($age < 11){
			tlschema($args['schemas']['gatenav']);
			addnav($args["gatenav"]);
			tlschema();
			addnav("*?`\$Hilfe, ich habe mich verlaufen!", "runmodule.php?module=tutor&op=helpfiles");
			unblocknav("runmodule.php?module=tutor&op=helpfiles");
		};
		break;
	case "battle":
		global $options;
		$badguy = $args[0];
		$tutormsg = "";
		if ($badguy['creaturehealth'] > 0 && $badguy['creaturelevel'] > $session['user']['level'] && $options['type'] == 'forest'){
			$tutormsg = translate_inline("`tDas `6En`^g`6el`^c`6hen`t sieht sehr besorgt aus. \"`^Achtung! Dieses Wesen scheint stärker als du zu sein... willst du nicht lieber fliehen? Wenn es nicht auf Anhieb klappt, versuch es gleich noch einmal.\"`t Das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t kichert nur und meint: `\$\"Genau, sonst endest du nacher noch als Dünger für den Wald!\"`0");
		}
		if ($tutormsg) tutor_talk("%s", $tutormsg);
	case "everyheader":
		if (!$session['user']['loggedin']) break;
		$adef = $session['user']['armordef'];
		$wdam = $session['user']['weapondmg'];
		$gold = $session['user']['gold'];
		$goldinbank = $session['user']['goldinbank'];
		$goldtotal = $gold+$goldinbank;
		if(!isset($args['script']) || !$args['script']) break;
		switch($args['script']){
		case "newday":
			if ($age > 1) break;
			if ((!$session['user']['race'] ||
						$session['user']['race']==RACE_UNKNOWN) &&
					httpget("setrace")==""){
				if (is_module_active("racetroll"))
					$troll=translate_inline("Troll");
				if (is_module_active("racedwarf"))
					$dwarf=translate_inline("Dwarf");
				if (is_module_active("racehuman"))
					$human=translate_inline("Human");
				if (is_module_active("raceelf"))
					$elf=translate_inline("Elf");
				if ($troll || $dwarf || $human || $elf) {
					$tutormsg = translate_inline("`tEin kleines `6En`^g`6el`^c`6hen`t fliegt zu dir und schwirrt für einen Moment um deinen Kopf herum.`n`n\"`&Wa-wa-wa...`t\" stammelst du.`n`n `\$\"Heda, halt mal den Schnabel!\"`t krakeelt das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t, das mit einem leisen 'plopp' auf deiner Schulter erscheint. `$\"Du sollst uns zuhören, nicht reden!\"`t`n`n\"`^Also, wir sind hier, um dich mit diesem Reich vertraut zu machen, also tust du gut daran, uns ganz genau zuzuhören\",`t erklärt das `6En`^g`6el`^c`6hen`t von deiner anderen Schulter aus. `n`nDu nickst stumm und schenkst diesen seltsamen Wesen deine volle Aufmerksamkeit.`n`n\"`\$Nun,`t\" beginnt das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t, \"`\$Du bist ja noch ganz grün hinter den Ohren. Und hast keinen blassen Schimmer, wo du herkommst, ne? Wenn du noch nie hier gewesen bist, ist es wohl am Einfachsten, wenn du dir da was aussuchst!\" `tAufgeregt hüpft es auf und ab und wedelt mit einer Liste voller Vorschläge vor deiner Nase herum.`n`n Tadelnd den Kopf schüttelnd lässt das `6En`^g`6el`^c`6hen`t dich noch wissen: `^\"Jede Rasse hat ihre ganz besonderen Vorteile und Stärken. Aber keine Sorge - wenn du nach einiger Zeit bemerkst, dass dir eine andere besser gefallen würde, kannst du nach jedem erlegten Drachen noch einmal wählen.\"");
					tutor_talk("%s", $tutormsg);
				};
			}elseif ($session['user']['specialty']=="" && !httpget("setrace")){
				if (is_module_active("specialtydarkarts"))
					$da=translate_inline("Dark Arts");
				if (is_module_active("specialtymysticpower"))
					$mp=translate_inline("Mystical Powers");
				if (is_module_active("specialtythiefskills"))
					$ts=translate_inline("Thieving Skills");
				if ($da || $mp || $ts){
					$tutormsg = translate_inline("`tDas `6En`^g`6el`^c`6hen`t flattert vor dir her, ungeachtet deiner Mühen, es aus deinem Sichtfeld zu scheuchen. Einen Moment später erklingt auch seine durchdringende Stimme wieder:`n`n`^\"Oh, sieh nur, noch mehr wundervolle Entscheidungen! Vermutlich willst du jetzt eine kurze Berufsberatung?\"`t`n`n Das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t rempelt es aber sofort grob an und unterbricht den Vortrag, doch das `6En`^g`6el`^c`6hen`t lässt sich nicht abhalten. `^\"Warum probierst du nicht erst einmal hiervon etwas? So stolperst du nicht über deine eigenen Füße.\"`t`n`nEs hält eine kleine Schriftrolle vor deine Augen, geprägt von kleiner Schrift, und wartet auf deine Entscheidung.`n`n Das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t kräht noch: `\$\"Das kannst du aber später auch nochmal ändern, Boss!\"");
					tutor_talk("%s", $tutormsg);
				}
			}
			break;
		case "village":
			$tutormsg = "";
			if ($wdam == 0 && $gold >= 48){
				$tutormsg = translate_inline("`\$\"Ey, du solltest dir wirklich 'ne Waffe zulegen\", `tverkündet das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t, \"`\$dass du den ollen Waldmonstern mal so richtig eins auf die Mütze geben kannst! Hopp, zu Waffenladen, ich warte dann dort auf dich, Boss.\"");
			}elseif($wdam == 0 && $goldtotal >= 48){
				$tutormsg = translate_inline("`n\"`\$Los, gehen wir 'n bisschen Kohle von der Bank holen, beweg' deinen Hintern!\"`n`n");
			}elseif ($adef == 0 && $gold >= 48){
				$tutormsg = translate_inline("`tDas `6En`^g`6el`^c`6hen`t umschwirrt dich besorgt. `^\"Du brauchst unbedingt auch eine Rüstung, nicht dass dir noch etwas passiert... das wäre wirklich schrecklich! Die gute Pegasus kann dir bestimmt weiterhelfen.\"");
			}elseif ($adef == 0 && $goldtotal >= 48){
				$tutormsg = translate_inline("\"`^Lass uns zuerst ein bisschen Gold von der Bank holen, ja?\"");
			}elseif (!$session['user']['experience']){
				$tutormsg = translate_inline("`tDas `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t drängelt: `\$\"Boss, wann gehen wir denn endlich mal in den Wyrmforst?\"`t Auf deinen fragenden Blick erklärt das `6En`^g`6el`^c`6hen`t: `^\"Du kannst dort Erfahrung sammeln und Gold finden.\"");
			}elseif ($session['user']['experience'] > 100 && $session['user']['level'] == 1 && !$session['user']['seenmaster']){
				$tutormsg = translate_inline("`tDas `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t schreit förmlich in dein Ohr: \"`\$Krass, Aldda! Du bist ja voll der coole Checker!\"`t Während du dir noch den Kopf darüber zerbrichst, was bitte ein 'kuhler Tscheka' sein soll, klärt das `6En`^g`6el`^c`6hen`t dich bereits auf. `^\"Du hast genug Erfahrung gesammelt, um deinen Meister herauszufordern. Du findest ihn im Trainingslager in deiner Heimatstadt.\"");
			}
			if ($tutormsg) tutor_talk("%s", $tutormsg);
			break;
		case "forest":
			$tutormsg = "";
			if ($goldtotal >= 48 && $wdam == 0){
				$tutormsg = translate_inline("`\$\"Ey, Boss! Du hast doch genug Gold... geh' dir mal 'ne anständige Waffe kaufen, dann kannst du denen noch viel besser eins auf die Rübe geben!\"`t meint das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t.");
			}elseif($goldtotal >= 48 && $adef == 0){
				$tutormsg = translate_inline("`tDas `6En`^g`6el`^c`6hen`t lässt dich wissen: `^\"Du hast jetzt genug Gold, um dir eine Rüstung zu leisten. Weißt du, ich würde mich wirklich besser fühlen, wenn du sicherer bist.\"");
			}elseif (!$session['user']['experience'] && !get_module_pref("seenforest")){
				$tutormsg = translate_inline("`tDas `6En`^g`6el`^c`6hen`t fliegt Schleifen um deinen Kopf und erklärt:`^ \"Hier gibt es wirklich nicht viel zu sagen. Bekämpfe die Monster, finde Gold und geh zum Heiler, wenn es nötig ist.\"`t Der Kommentar des `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$ns`t lässt nicht lange auf sich warten: `\$\"Vor allem solltest du aber Spaß haben, Boss!\"`t `n`nBeide verschwinden dann mit einem leisen 'plopp', zuvor noch hörst du das `6En`^g`6el`^c`6hen`t flüstern:  `^\"Bevor ich es vergesse, bitte lies die FAQ und besuche die Dorfschule... die News solltest du bei jedem Login lesen. Hab keine Angst Fremdes zu erkunden, aber renn lieber weg, wenn es nötig sein sollte! Und erinnere dich daran: Sterben ist Teil des Lebens!\"");
				set_module_pref("seenforest", 1);
			};
			if ($tutormsg) tutor_talk("%s", $tutormsg);
			break;
		case "shades":
			$tutormsg = "";
				$tutormsg = translate_inline("`tDas `6En`^g`6el`^c`6hen`t surrt wie wild um dich herum, um den Schaden zu begutachten, den du genommen hast. `^\"Ach ja, so schlimm ist es doch gar nicht. Wir sollten ins Mausoleum gehen und Ramius bitten, ob er dich nicht wieder nach Oben schickt.\"`t Das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t kichert gehässig, nickt aber wider Erwarten. `\$\"Genau, Boss! Lass' uns auf'n Friedhof gehen und 'n bisschen was zum Quälen suchen, der olle Ramius macht das nämlich nich für umme!\"`t");
			if ($tutormsg) tutor_talk("%s", $tutormsg);
			break;
		case "graveyard":
		$playerfavor = $session['user']['deathpower'];
		$max = $session['user']['level'] * 5 + 50;
			$tutormsg = "";
				if ($playerfavor <= 5){
				$tutormsg = translate_inline("`t Das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t scheint sich hier pudelwohl zu fühlen und piekst dich übermütig mit dem Dreizack, sobald du stehen bleibst. `\$\"Los, was zum Quälen suchen, aber bisschen dalli! Und dann ab ins Mausoleum!\"`t `tDas `6En`^g`6el`^c`6hen`t schüttelt nur missbilligend den Kopf und poliert derweil seinen Heiligenschein.");
				};
				if ($session['user']['soulpoints'] < $max) {
			$tutormsg = translate_inline("`tDas `6En`^g`6el`^c`6hen`t sieht ein wenig besorgt aus. `^\"Du solltest ins Mausoleum gehen und dich heilen lassen. Auch deine unsterbliche Seele kann Schaden nehmen, weißt du?\"`t Prompt äfft das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t nach: `\$\"Uuuuuuh, deine Seeeleee nimmt Schaaaden!\"`t Aber einen wirklich sinnvollen Einwand gegen den Vorschlag deines anderen Begleiters kann es anscheinend nicht vorbringen.");				
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
			background-color: #433828;
			border-color: #F5DEB3;
			border-style: double;
			border-width: medium;
			padding: 10px 10px 10px 10px;
			margin: 10px 10px 10px 10px;
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
		page_header("Hilfe!");
		output("`4`c`bHilfe, ich habe mich verirrt!`b`c`n");
		output("`tDu weißt nicht, was du tun sollst?`n`n");
		output("Legend of the Green Dragon hat zwar klein angefangen, aber mit der Zeit kamen viele neue Dinge dazu, die es zu erkunden gilt.`n`n");
		output("Für einen Neuling kann das ein wenig entmutigend sein.`n`n");
		output("Um neuen Spielern zu helfen, hat das LotGD-Team dir das `6En`^g`6el`^c`6hen`t und das `4T`\$e`4u`\$f`4e`\$l`4c`\$h`4e`\$n`t zur Seite gestellt. Das sind die kleinen Kerlchen, die dir anfangs geraten haben, eine Waffe und eine Rüstung zu kaufen. Aber was geschieht jetzt, wo sollst du hingehen und wohin führen die vielen Türen, Gassen und Geschäfte?`n`n");
		output("Zu allererst: In diesem Spiel geht es um Entdeckungen und Abenteuer, deshalb wirst du hier nicht für jede Frage eine Antwort finden. Für die meisten Sachen solltest du die FAQ lesen - oder probiere einfach aus und schau was passiert.`n`n");
		output("Natürlich wissen wir, dass manche Dinge ganz und gar nicht offensichtlich sind. Wir werden dir nicht auf die Nase binden, was welchen Effekt hat, aber wir haben eine Liste mit Dingen zusammengestellt, die du zuerst ausprobieren solltest und nach denen uns neue Spieler regelmäßig fragen.`n`n");
		output("Bitte bedenke, dass manche diese Hinweise Spoiler sind. Wenn du lieber alles selbst entdecken möchtest, lies jetzt nicht weiter.`n`n");
		output("Was haben all die Sachen in meiner Vital Info und Personal Info zu bedeuten? Die meisten davon brauchen dir kein Kopfzerbrechen bereiten. Die Anzeigen, die du jedoch aufmerksam beachten solltest, sind deine Lebenspunkte und der Erfahrungsbalken.");
		output("Idealerweise sollte die Lebenspunkt-Anzeige grün bleiben. Pass auf, wenn sie gelb wird - oder noch schlimmer: rot. Das bedeutet, dass der Tod nahe ist. Manchmal wäre weglaufen schlauer, als ständig sein Leben zu riskieren. Vielleicht ist ja jemand in der Nähe, der dafür sorgt, dass du dich wieder besser fühlst.`n`n");
		output("Weiter unten ist der Erfahrungsbalken, der komplett rot anfängt und sich nach und nach weiß färben wird. Warte ab, bis er blau ist, bevor du in deiner Heimatstadt den Meister herausforderst. Wenn du noch keinen blauen Balken sehen kannst, bist du noch nicht bereit!`n`n");
		output("Du suchst jemanden, den du kennst? Die Kriegerliste wird dir verraten, ob dein Freund gerade online ist oder nicht. Wenn das der Fall ist, ist die Ye Olde Mail (Postfach) eine gute Möglichkeit, ihn zu kontaktieren.`n`n");
		output("Wofür sind Edelsteine da? Sammle sie und wäge ab, wofür du sie ausgeben willst. Es gibt so einige Dinge, die du nur mit Edelsteinen kaufen kannst.`n`n");
		output("Warst du schon im Boar's Head Inn, in Thalheim? Vielleicht möchtest du ja etwas trinken, ein wenig unterhalten werden, oder mit den Leuten quatschen. Es ist immer eine gute Sache, wenn man die Charaktere im Boar's Head Inn kennt, denn die können einem jungen Krieger gute Hilfe leisten. Vielleicht befindest du eine Übernachtung der Kneipe ja auch für sicherer, als eine Nacht in den Feldern.`n`n");
		output("Reisen kann gefährlich sein. Vergewissere dich, dass du deine Wertgegenstände irgendwo sicher deponiert hast, und dass du dich gesund fühlst, bevor du losziehst.");
		output("Hungrig, müde, abenteuerlustig oder suchst du ein Haustier? Boogers Badestätte, Saucys Dorfküche, der Tattooladen und verschiedenen Tierhändler sind etwas, was du gesehen haben musst. Das sind Orte oder Geschäfte in verschiedenen Städten. Einige Ereignisse bringen Waldkämpfe, Charmepunkte oder Lebenspunkte ein, andere dagegen nehmen sie dir.`n`n");
		output("Wo aber ist denn jetzt der Drache? Alle fragen das. Du wirst ihn schon sehen, wenn du bereit bist, ihn zu bekämpfen - und nicht vorher! Du wirst dich in Geduld üben müssen und deine Kräfte trainieren, während du wartest.`n`n");
		output("Wenn du Fragen hast, die nicht in den FAQ erklärt werden, kannst du eine Petition an die Mods/Admins schreiben - behalte aber im Hinterkopf, dass das LotGD-Team keine Fragen beantwortet, wenn es sich um Spoiler handelt. Auch ein Besuch in der Dorfschule, die du in jeder Stadt findest, ist sicher keine schlechte Idee.");
		villagenav();
		page_footer();
	}
}
?>
