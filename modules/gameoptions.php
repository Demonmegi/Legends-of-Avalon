<?php
function gameoptions_getmoduleinfo(){
	$info = array(
		"name" => "Helping Options for Core Edits",
		"version" => "1.0",
		"author"=>"`2R`@o`ghe`2n `Qvon `2Fa`@lk`genbr`@uch`&",
		"category" => "General",
		"prefs"=>array(
			"Farben und Chat Optionen,title",
			"user_layout"=>"Taubendarstellung,enum,0,Nach Absender,1, Nach Eingangsdatum,2,Wie früher",
            "user_showcolors"=>"Nutzer sieht Farbauswahl,enum,0,Als Dropdown-Menü,1,Als Farbliste,2,Gar nicht",
			"Rollenspiel,title",
			"lastwritingchar"=>"Zuletzt benutzter account,int",
			"autorepair_ctitle"=>"Automatische Titelreparatur,string",
			"autorepair_name"=>"Automatische Namesreparatur,string",
			"Chatspeicherung,title",
			"lastpostvalues"=>"Zuletzt zwischengespeicherte Werte"
		),

	);
	return $info;
}

function gameoptions_install(){
	module_addhook("modifypreviewfield");
	return true;
}

function gameoptions_uninstall(){
	return true;
}

function gameoptions_dohook($hookname, $args){
	global $session;
	switch ($hookname){
	 case 'modifypreviewfield':
		$values=unserialize(get_module_pref("lastpostvalues"));
		if (is_array($values)) {
			if (isset($values[$args['fieldname']])) {
				$args['defaultvalue']=$values[$args['fieldname']];
				set_module_pref("lastpostvalues","");
			}
		}

	// 	set_module_pref("lastwritingchar",$session['user']['acctid']);
	// 	$ctitle = get_module_pref("autorepair_ctitle");
	// 	$name   = get_module_pref("autorepair_name");
		
		break;
	}
	return $args;
}

function gameoptions_run() {
}