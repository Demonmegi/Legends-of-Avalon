<?php

function strangeoldman_getmoduleinfo(){
	$info = array(
		"name"=>"Alter Mann im Wald",
		"version"=>"1.0",
		"author"=>"Christian Rutsch, Christoph Meyer, Thomas Kramer",
		"category"=>"Forest Specials",
		"download"=>"core_module",
	);
	return $info;
}

function strangeoldman_install(){
	module_addeventhook("forest", "return 100;");
	return true;
}

function strangeoldman_uninstall(){
	return true;
}

function strangeoldman_dohook($hookname,$args){
	return $args;
}

function strangeoldman_runevent($type) {
	global $session;
	$op = httpget('op');

	if ($op == "") {
		switch(e_rand(1,3)){
			case 1:
				if ($session['user']['charm']>0){
					output("`^Ein alter Mann schlägt dich mit einem hässlichen Stock, kichert und rennt davon!`n`nDu `%verlierst einen`^ Charmepunkt!`0");
					$session['user']['charm']--;
				}else{
				  output("`^Ein alter Mann trifft dich mit einem hässlichen Stock und schnappt nach Luft, als der Stock `%einen Charmepunkt verliert`^.  Du bist noch hässlicher als dieser hässliche Stock!`0");
				}
				break;
			case 2:
				output("`^Ein alter Mann schlägt dich mit einem schönen Stock, kichert und rennt davon!`n`nDu `%bekommst einen`^ Charmepunkt!`0");
				$session['user']['charm']++;
				break;
			case 3:
				if ($op == "") {
				  output("`@Du begegnest einem merkwürdigen alten Mann!`n`n\"`#Ich hab mich verlaufen.`@\", sagt er, \"`#Kannst du mich ins Dorf zurückbringen?`@\"`n`n");
					output("Du weißt, daß du einen Waldkampf für heute verlieren wirst, wenn du diesen alten Mann ins Dorf bringst. Wirst du ihm helfen?");
					addnav("Führe ihn ins Dorf","forest.php?op=walk");
					addnav("Lass ihn stehen","forest.php?op=return");
					$session['user']['specialinc'] = "module:strangeoldman";
				}
				break;
		}
	} else if ($op == "walk") {
		$session['user']['turns']--;
		if (e_rand(0,1) == 0) {
			output("`@Du nimmst dir die Zeit, ihn zurück ins Dorf zu geleiten.`n`nAls Gegenleistung schlägt er dich mit seinem hübschen Stock und du erhältst `%einen Charmepunkt`@!");
			$session['user']['charm']++;
		} else {
			output("`@Du nimmst dir die Zeit, ihn zurück ins Dorf zu geleiten.`n`nAls Dankeschön gibt er dir `%einen Edelstein`@!");
			$session['user']['gems']++;
			debuglog("got 1 gem for walking old man to village");
		}
		$session['user']['specialinc']="";
	} else if ($op == "return") {
		output("`@Du erklärst dem Opa, daß du viel zu beschäftigt bist, um ihm zu helfen.`n`nKeine große Sache, er sollte in der Lage sein, den Weg zurück ");
		output("ins Dorf selbst zu finden. Immerhin hat er es ja auch vom Dorf hierher geschafft, oder? Ein Wolf heult links von dir in der Ferne und wenige Sekunden später ");
		output("antwortet ein anderer Wolf viel näher von rechts. Jup, der Mann sollte in Sicherheit sein.");
		$session['user']['specialinc']="";
	}
}
?>