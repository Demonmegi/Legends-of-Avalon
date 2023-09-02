<?php
/*
Nach einer Idee von BellaYasmina
Umgesetzt von Sir Arvex; © 2005
Erstmalig auf Anagromataf.de erschienen
Bugs und Fehler an arvex@anagromataf.de
*/
function dpafterdk_getmoduleinfo(){
	$info = array(
		"name"=>"DK DonationPoints",
		"author"=>"`)Arvex",
		"version"=>"1.2",
		"category"=>"General",
		"download"=>"http://www.arvex.de/index.php?showforum=3",
		"settings"=>array(
		"DK DonationPoints - Settings,title",
			"maxdp1"=>"Maximale DP für bis einschließlich 10 DKs,range,1,25,1|20",
			"maxdp2"=>"Maximale DP für 11 bis einschließlich 25 DKs,range,10,50,1|35",
			"maxdp3"=>"Maximale DP für über 25 DKs,range,15,75,5|50",
			"Anmerkung: Das Minimum ist die jeweils niedrigst einstellbare Nummer,note",
			
		),
	);
	return $info;
}

function dpafterdk_install(){
	module_addhook("dragonkill");
	return true;
}

function dpafterdk_uninstall(){
	return true;
}

function dpafterdk_dohook($hookname,$args){
	global $session;
	switch($hookname){
		case "dragonkill":
			require_once('lib/e_rand.php');
			if ($session['user']['dragonkills'] <= 10) {
			include("modules/arvex/dpafterdk/dpafterdk_10.php");
			}
			if ($session['user']['dragonkills'] >= 11 && $session['user']['dragonkills'] <= 25) {
			include("modules/arvex/dpafterdk/dpafterdk_11-25.php");
			}
			if ($session['user']['dragonkills'] >= 26) {
			include("modules/arvex/dpafterdk/dpafterdk_26.php");
			}
		}	
	return $args;
}

function dpafterdk_run(){
}
?>