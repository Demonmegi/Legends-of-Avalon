<?php

require_once("lib/http.php");
require_once("lib/villagenav.php");

function ramiusdarling_getmoduleinfo(){
	$info = array(
		"name"=>"Ramius liebling",
		"version"=>"1.00",
		"author"=>"`^Twilight",
		"category"=>"Graveyard",
		"download"=>"core_module",
		"settings"=>array(
			),
		"prefs"=>array(
			)
	);
	return $info;
}

function ramiusdarling_install(){
	module_addhook("rock");
	module_addhook("shades");
	return true;
}

function ramiusdarling_uninstall(){
	return true;
}

function ramiusdarling_dohook($hookname,$args){
	global $session;
	switch($hookname){
	case "rock":
	case "shades":
			
		$superusermask = SU_HIDE_FROM_LEADERBOARD;
		$standardwhere = "(locked=0 AND (superuser & $superusermask) = 0)";
		$sql = "SELECT resurrections, name FROM ".db_prefix("accounts")." WHERE $standardwhere ORDER BY resurrections DESC LIMIT 1";
		debug($sql);
		$row = db_fetch_assoc(db_query($sql));
		output("`4Auf einem Grabstein steht eingraviert:`n");
		output("`\$Als suizidgefährdetster Krieger, hat sich `^%s`\$ den Titel `)\"Ramius Liebling\" `\$für `^%s`\$ Auferstehungen erarbeitet`n`n", $row['name'], $row['resurrections']);
		
		break;
	}
	return $args;
}

function ramiusdarling_run(){
}

?>
