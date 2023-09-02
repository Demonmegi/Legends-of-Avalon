<?php
//contribs - mprowler
//	v. 1.46: modifications:
//			-title is variable in module settings
//			-negative buff-effects are changeable: attack-minus, defense-minus



function odor_getmoduleinfo(){
	$info = array(
		"name"=>"Odor",
		"version"=>"1.46",
		"author"=>"`#Lonny Luberts, modifications by Lenny LandFloh",
		"category"=>"PQcomp",
		"download"=>"Auf Anfrage",
		"vertxtloc"=>"http://www.hinterzimmer.ch/",
		"prefs"=>array(
			"Odor Module User Preferences,title",
			"odor"=>"Odor Level,int|0",
		),
		"settings"=>array(
			"Odor Module Settings,title",
			"newday"=>"Odor Increase on New Day,int|1",
			"titlenew"=>"Titel, text|Schweinebacke",
			"roundsleft"=>"Anzahl Runden,int|200",
			"attackeffect"=>"Attack Minus Effekt in Prozent,int|10",
		    "defenseeffect"=>"Defense Minus Effekt in Prozent,int|10",
		),
	);
	return $info;
}

function odor_install(){
	if (!is_module_active('odor')){
		output("`4Installing Odor Module.`n");
	}else{
		output("`4Updating Odor Module.`n");
	}
	module_addhook("charstats");
	module_addhook("dragonkill");
	module_addhook("newday");
	module_addhook("village");
	module_addhook("battle-victory");
	module_addhook("battle-defeat");
	module_addeventhook("forest", "return 100;");
	return true;
}

function odor_uninstall(){
	output("`4Installing Odor Module.`n");
	return true;
}

function odor_dohook($hookname,$args){
	global $session;
		   $attackminus=get_module_setting("attackeffect");
		   $defenseminus=get_module_setting("defenseeffect");
		   $roundsleft=get_module_setting("roundsleft");
		   $titlenew=get_module_setting("titlenew");
		   
	
	switch($hookname){
		case "charstats":
			if ($session['user']['alive'] == 1){
				$len=0;
			    $len2=0;
			    $max=40;
			    $odorval = get_module_pref('odor');
			         for ($i=0;$i<$max/2;$i+=1){
			       if ($odorval>$i) $len+=2;
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
			    $color = "`^";
			    $barcolor = "#F7E827";
			    $barbgcol = "#777777";
			    $odor = "";
			    $odor .= "`b$color$pct%`b";
			    $odor .= "<br />";
			    $odor .= "<table style='border: solid 1px #000000' bgcolor='$barbgcol' cellpadding='0' cellspacing='0' width='70' height='5'><tr><td width='$pct%' bgcolor='$barcolor'></td><td width='$nonpct%'></td></tr></table>";
			    setcharstat("Vital Info","Odor",$odor);
	    	}
		break;
			case "dragonkill":
			set_module_pref('odor', 0);
		break;
		case "newday":
			if (get_module_pref('odor') > 2) $session['user']['charm']-=(get_module_pref('odor')-2);
			set_module_pref('odor', get_module_pref('odor') + get_module_setting('newday'));
			if (get_module_pref('odor')>9 and $session['user']['clean']<15) addnews("%s`2 is pretty stinky!",$session['user']['name']);
			if (get_module_pref('odor')>14 and get_module_pref('odor')<20){
				output("You can hardly stand the smell of yourself!");
				addnews("%s`2 smells really bad!",$session['user']['name']);
			}
			if (get_module_pref('odor')>19){ 
				output("You have earned the title of $titlenew for being so dirty!`n");
					addnews("%s `7was awarded the title of $titlenew for being so dirty!",$session['user']['name']);
					$newtitle="stinker";
					require_once("lib/names.php");
					$newname = change_player_title($newtitle);
					$session['user']['title'] = $newtitle;
					$session['user']['name'] = $newname;
					
			//--------------------
			apply_buff('stinky1',
				array(
					"name"=>"`QMiefpsychose",
					"rounds"=>$roundsleft,
					"wearoff"=>"Dein Gestank ist endlich verflogen.",
					"atkmod"=>$session['user']['level']-$attackminus*$session['user']['level']/100,
					"defmod"=>$session['user']['level']-$defenseminus*$session['user']['level']/100,
					"minioncount"=>1,
					"roundmsg"=>"Dein Gestank verwirrt dir die Sinne",
					"schema"=>"module-odor",
					));
			//--------------------
			}
		break;
		case "village":
			tlschema($args['schemas']['marketnav']);
    		addnav($args['marketnav']);
    		tlschema();
			addnav("Bath House", "runmodule.php?module=odor");
		break;
		case "battle-victory":
			if (e_rand(1,3) == 3) set_module_pref('odor', get_module_pref('odor') + 1);
		break;
		case "battle-defeat":
			if (e_rand(1,3) == 3) set_module_pref('odor', get_module_pref('odor') + 2);
		break;
	}
	return $args;
}

function odor_runevent(){
	global $session;
	$op = httpget('op');
	if (e_rand(1,2) == 1 and $op <> "bathe"){
		output("You trip!  Ohhhh! right into a mud puddle!  You are covered in mud!");
		set_module_pref('odor', get_module_pref('odor') + 2);
	}else{
		$session['user']['specialinc']="module:odor";
		if ($op == ""){
		output("You come across a small river, the water looks clean and fresh.  What a great place to clean up!");
		addnav("Bathe","forest.php?op=bathe");
		addnav("Continue on Your way","forest.php?op=continue");
		}
		if ($op == "continue"){
			$session['user']['specialinc']="";
			redirect("forest.php");
		}
		if ($op == "bathe"){
			set_module_pref('odor', 0);
			output("You strip down to your skivies and hop in the river.  The bath leaves you feeling and smelling much better!");
			$session['user']['specialinc']="";
			addnav("Continue on Your way","forest.php");
		}
	}
}

function odor_run(){
global $session;
$op = httpget('op');
page_header("Bath House");
output("`c`b`&Bath House`0`b`c`n`n");
if ($op == ""){
output("`2You enter the bath house and notice that everything looks very damp, including the old woman tending");
output("the baths.  There are curtains around all of the baths for privacy.  You think a nice steamy hot bath");
output("would feel good about now.  The old woman looks at you and points to a sign on the wall.  The sign states");
output("that a bath will cost you `65 `2gold.`n");
addnav("Take a Bath","runmodule.php?module=odor&op=bathe");
modulehook("bathhouse",$texts);
addnav("Back to the Village","village.php");
}
if ($op == "bathe"){
	if ($session['user']['gold']<5){
	output("`2You dig for the 5 gold in your pouch, but come up short.  The old woman just turns away and points to the door.`n");
	addnav("Back to the Village","village.php");
	}else{
	output("`2You hand the old woman your 5 gold and without saying a word leads you to a bath and pulls the curtain");
	output("You undress and slip into the warm water and proceed to clean the grime of the forest and the village");
	output("from your body.  The bath feels heavenly and you could stay here forever, but just as you get settled in");
	output("the old woman abruptly pulls back the curtain and gestures for you to get out.  She closes the curtain and");
	output("leaves you to dry off and get dressed.  You feel much better after your bath!`n");
	set_module_pref('odor', 0);
	$session['user']['gold']-=5;
	addnav("Back to the Village","village.php");
	}
}
//I cannot make you keep this line here but would appreciate it left in.
rawoutput("</a><br>");
page_footer();
}
?>