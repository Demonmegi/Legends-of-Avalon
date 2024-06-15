<?php
// addnews ready
// translator ready
// mail ready

function ramiusaltar_getmoduleinfo(){
	$info = array(
		"name"=>"Altar of Ramius",
		"version"=>"1.0",
		"author"=>"Enhas",
		"category"=>"Graveyard Specials",
		"download"=>"http://dragonprime.net/users/Enhas/ramiusaltar.txt",
		"settings"=>array(
		"Altar of Ramius Settings,title",
		"minfavor"=>"Minimum favor that can be gained,range,1,20,1|5",
			"maxfavor"=>"Maximum favor that can be gained,range,1,20,1|15",
			"favorda"=>"Does Ramius favor players more who have Dark Arts as their specialty,bool|1",
		),
	);
	return $info;
}

function ramiusaltar_install(){
	module_addeventhook("graveyard", "return 75;");
	return true;
}

function ramiusaltar_uninstall(){
	return true;
}

function ramiusaltar_dohook($hookname,$args){
	return $args;
}

function ramiusaltar_runevent($type) {
	global $session;
	$minfavor = get_module_setting("minfavor");
	$maxfavor = get_module_setting("maxfavor");
	$favorda = get_module_setting("favorda");
	output("`7As you maneuver your way through the drab setting of the Shades, you notice an altar ahead with a small bust of `\$Ramius`7 upon it.  ");
	output("Black candles line the sides, casting an eerie glow upon the area.`n`n");
	output("You notice that one candle to the right has burned out, and take the time to light it using one of the others.`n`n");
	  output("You feel as if `\$Ramius`7 is pleased with your act!`n`n");
	  $favorgain = e_rand($minfavor,$maxfavor);
	  if ($favorda==1 && (is_module_active("specialtydarkarts")) && ($session['user']['specialty'] == "DA")) {
	  $favorgain = $favorgain * 2;
	  }
	  $session['user']['deathpower'] += $favorgain;
	  output("`3You receive `^%s`3 favor with `\$Ramius`3!`0", $favorgain);
}
?>