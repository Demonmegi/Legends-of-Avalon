<?php
//contribs - mprowler
//add bathroom to inn... admin on/off
function bladder_getmoduleinfo(){
	$info = array(
		"name"=>"Bladder",
		"version"=>"2.01",
		"author"=>"`#Lonny Luberts",
		"category"=>"PQcomp",
		"download"=>"http://www.pqcomp.com/modules/mydownloads/visit.php?cid=3&lid=36",
		"vertxtloc"=>"http://www.pqcomp.com/",
		"prefs"=>array(
			"Bladder Module User Preferences,title",
			"bladder"=>"Bladder Level,int|0",
			"emptied"=>"Emptied Bladder today,bool|0",
		),
		"settings"=>array(
			"Bladder Module Settings,title",
			"newday"=>"Bladder Increase on New Day,int|10",
			"inntoilet"=>"Add a toilet to the inn?,bool|0",
		),
	);
	return $info;
}

function bladder_install(){
	if (!is_module_active('bladder')){
		output("`4Installing Bladder Module.`n");
	}else{
		output("`4Updating Bladder Module.`n");
	}
	module_addhook("charstats");
	module_addhook("dragonkill");
	module_addhook("newday");
	module_addhook("village");
	module_addhook("forest");
	module_addhook("inn");
	return true;
}

function bladder_uninstall(){
	output("`4Un-Installing Bladder Module.`n");
	return true;
}

function bladder_dohook($hookname,$args){
	global $session,$texts;
	switch($hookname){
	case "charstats":
	    if ($session['user']['alive'] == 1){ 
			$len=0;
		     $len2=0;
		     $max=40;
		     $bladderval = get_module_pref('bladder');
		          for ($i=0;$i<$max/2;$i+=1){
		        if ($bladderval>$i) $len+=2;
		     }
		     $pct = round($len / $max * 100, 0);
		     $nonpct = 100-$pct;
		     if ($pct > 100) {
		        $pct = 100;
		        $nonpct = 0;
		     } elseif ($pct < 0) {
		        $pct = 0;
		        $nonpct = 100;
		     }
		     $color = "`$";
		     $barcolor = "#ff0000";
		     $barbgcol = "#777777";
		     $bladder = "";
		     $bladder .= "`b$color$pct%`b";
		     $bladder .= "<br />";
		     $bladder .= "<table style='border: solid 1px #000000' bgcolor='$barbgcol' cellpadding='0' cellspacing='0' width='70' height='5'><tr><td width='$pct%' bgcolor='$barcolor'></td><td width='$nonpct%'></td></tr></table>";
		     setcharstat("Vital Info","Bladder",$bladder);
     	}
   break;
	case "dragonkill":
		set_module_pref('bladder', 0);
	break;
	case "newday":
		if (get_module_pref('bladder')>20){
			output("`3You find that you couldn't hold it and wet yourself in your sleep!");
			$session['user']['charm']-=2;
			addnews("%s wet the bed!",$session['user']['name']);
			set_module_pref('bladder', -2);
		}
		set_module_pref('bladder', get_module_pref('bladder') + 2);
		set_module_pref('emptied', false);
	break;
	case "village":
		if (get_module_pref("usedouthouse","outhouse") and !get_module_pref('emptied')){
			set_module_pref('bladder', 0);
			set_module_pref('emptied', true);
		}
		if (get_module_pref('bladder')>19){
			if (get_module_pref('bladder')>24){
			output("<big>`4`bYou find that you couldn't hold it and wet yourself!`b</big>",true);
			$session['user']['charm']-=2;
			addnews("%s wet their pants!",$session['user']['name']);
			if (is_module_active('odor')) {
				set_module_pref('odor',(get_module_pref('odor') + 5),'odor');
			}
			set_module_pref('bladder', -2);
		}else{
			output("<big>`4`bYou have to go potty really bad!`b</big>",true);
			if (e_rand(1,100) > 90){
				$sql ="INSERT INTO commentary (postdate,section,author,comment) VALUES (now(),'".$texts['section']."','".$session['user']['acctid']."','::does the peepee dance.')";
				db_query($sql);
			}
		}
		}
	break;
	case "forest":
		if (get_module_pref("usedouthouse","outhouse") and !get_module_pref('emptied')){
			set_module_pref('bladder', 0);
			set_module_pref('emptied', true);
		}
	break;
	case "inn":
		if (get_module_setting("inntoilet")) addnav("The Head","runmodule.php?module=bladder");
	break;
}
	return $args;
}

function bladder_run(){
	global $SCRIPT_NAME;
	if ($SCRIPT_NAME == "runmodule.php"){
		$module=httpget("module");
		if ($module == "bladder"){
			include("modules/lib/bladder.php");
		}
	}
}
?>