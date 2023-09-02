<?php
require_once("common.php");
require_once("lib/fightnav.php");
require_once("lib/pvpwarning.php");
require_once("lib/pvplist.php");
require_once("lib/pvpsupport.php");
require_once("lib/http.php");
require_once("lib/taunt.php");
require_once("lib/villagenav.php");
require_once("lib/battle-skills.php");
require_once("lib/systemmail.php");
function estbreak_getmoduleinfo(){
		$info = array(
			"name"=>"Estate Breakin",
			"author"=>"Chris Vorndran",
			"version"=>"1.2",
			"category"=>"House System",
			"download"=>"http://dragonprime.net/users/Sichae/estbreak.zip",
			"vertxtloc"=>"http://dragonprime.net/users/Sichae/",
			"requires"=>array(
				"house"=>"1.75|by Chris Vorndran and Kujaku, http://dragonprime.net/users/Sichae/house.zip",
			),
			"settings"=>array(
				"Estate Breakin General Settings,title",
					"aliaff"=>"Is alignment affected by breaking in,bool|1",
					"alplun"=>"Alignment is decreased by this much -  after Stealing,int|5",
					"alatk"=>"Alignment is decrease by this much - after Attacking,int|5",
					"hof"=>"Display an HoF page,bool|1",
					"pp"=>"Display how many pages in HoF listing,int|10",
				"Attack Settings,title",
					"attack"=>"Is Attacking allowed,bool|1",
					"timespv"=>"How many times can a person enter an estate `ito attack`i,range,1,5,1|2",
					"days"=>"Days a person is immune from PvP,range,1,10,1|5",
					"exp"=>"PvP immunity until this amount of EXP is earned,int|1500",
				"Plunder Settings,title",
					"plunder"=>"Is Plundering allowed,bool|1",
					"times"=>"How many times can a person enter an estate `ito steal`i,range,1,5,1|2",
					"gold"=>"Multiplier of Level to retrieve gold that one can steal,int|100",
					"gems"=>"Multiplier of Level to retrieve gems that one can steal,int|1",
				"Guardian Settings,title",
					"guardian"=>"Does a guardian protect the Estates,bool|1",
					"atk"=>"Multiplier of attacker's attack to get Creature Attack,floatrange,0,2,.02|1.7",
					"def"=>"Multiplier of attacker's defense to get Creature Defense,floatrange,0,2,.02|1.7",
					"hp"=>"Multiplier of attacker's maxHP to get Creature Hitpoints,floatrange,0,2,.02|2",
					"heal"=>"Does user get healed after Guardian Battle,bool|1",
					"hpheal"=>"Percentage of Max Hitpoints that is healed,range,0,100,1|75",
			),
			"prefs"=>array(
				"Estate Breakin Preferences,title",
					"count"=>"How many times has this user broken in `ito steal`i,int|0",
					"countpv"=>"How mant times has this user broken in `ito attack`i,int|0",
			)
			);
	return $info;
}
function estbreak_install(){
	module_addhook("housenavs");
	module_addhook("pvpcount");
	module_addhook("newday");
	module_addhook("footer-hof");
	return true;
}
function estbreak_uninstall(){
	return true;
}
function estbreak_dohook($hookname,$args){
	global $session;
	$count = get_module_pref("count");
	$times = get_module_setting("times");
	switch ($hookname){
		case "housenavs":
			$op = httpget('op');
			$lo = httpget('lo');
			if ($op == "" && $lo == ""){
				if ($count <= $times){
					addnav("Breakin");
					if (get_module_setting("attack") == 1) addnav("Attack Residents","runmodule.php?module=estbreak&op=attack");
					if (get_module_setting("plunder") == 1) addnav("Plunder Estates","runmodule.php?module=estbreak&op=plunder");
				}else{
					output("`n`nYou can see that the Guardian is more wary today...");
					output(" You might want to wait until the newday, when he is all liquored up.`n`n");
				}
			}
				break;
		 case "pvpcount":
			if ($args['loc'] != translate_inline("Estate Housing")) break;
		    $args['handled'] = 1;
			if ($args['count'] == 1) {
	            output("`&There is `^1`& person sleeping in their Estate whom you might find interesting.`0`n");
		    } else {
			    output("`&There are `^%s`& people sleeping in their Estates whom you might find interesting.`0`n", $args['count']);
	        }
		    break;
		case "newday":
			set_module_pref("count",0);
			break;
		case "footer-hof":
			if (get_module_setting("hof") == 1){
				addnav("Warrior Rankings");
				addnav("Estate Sizes","runmodule.php?module=estbreak&op=hof");
				}
			break;
		}
	return $args;
}
function estbreak_run(){
	global $session,$pvptime,$pvptimeout;
	$pvptime = getsetting("pvptimeout",600);
	$pvptimeout = date("Y-m-d H:i:s",strtotime("-$pvptime seconds"));
	page_header("Estate Breakin - Attack");
// Guard Values
	$hp = get_module_setting("hp");
	$atk = get_module_setting("atk");
	$def = get_module_setting("def");
// Breakin Values
	$times = get_module_setting("times");
	$count = get_module_pref("count");
	$timespv = get_module_setting("timespv");
	$countpv = get_module_pref("countpv");
// HTTP Values
	$op = httpget('op');
	$op2 = httpget('op2');
	$op3 = httpget('op3');
	$pvp = httpget('pvp');
	$guard = httpget('guard');
	$id = httpget('id');
	$page = httpget('page');
// Multipliers for Theft
	$gold = get_module_setting("gold");
	$gems = get_module_setting("gems");
// Gold/Gem Treasure of Estate
	$treasure = get_module_objpref("house", $id, "treasure", "house");
	$gemtreasure = get_module_objpref("house", $id, "gemtreasure", "house");
// Script for Battle
	$script = "runmodule.php?module=estbreak&op2=$op2";
// Healing for After Battle
	$hpheal = get_module_setting("hpheal");
	$pct = $hpheal/100;
	$amnt = (int)($session['user']['maxhitpoints']*$pct);
	$heal = $amnt - $session['user']['hitpoints'];
// Location of Resident
	$estloc = translate_inline("Estate Housing");

	if ($op == "hof"){
			page_header("Hall of Fame");
			$pp = get_module_setting("pp");
			$pageoffset = (int)$page;
			if ($pageoffset > 0) $pageoffset--;
			$pageoffset *= $pp;
			$limit = "LIMIT $pageoffset,$pp";
			$sql = "SELECT COUNT(userid) AS c FROM " . db_prefix("module_userprefs") . " WHERE modulename = 'house' AND setting = 'housesize' AND value >= 1";
			$result = db_query($sql);
			$row = db_fetch_assoc($result);
			$total = $row['c'];
			$count = db_num_rows($result);
			if (($pageoffset + $pp) < $total){
				$cond = $pageoffset + $pp;
			}else{
				$cond = $total;
			}
			$sql = "SELECT ".db_prefix("module_userprefs").".value, ".db_prefix("accounts").".name, ".db_prefix("accounts").".acctid FROM ".db_prefix("module_userprefs")." , ".db_prefix("accounts"). " WHERE acctid = userid AND modulename = 'house' AND setting = 'housesize' AND value >= 1 ORDER BY (value+0) DESC $limit";
			$result = db_query($sql);
			$rank = translate_inline("Rank");
			$oe = translate_inline("Owner of Estate");
			$pn = translate_inline("Property Name");
			$ps = translate_inline("Property Size");
			rawoutput("<big>");
			output("`c`b`^Largest Properties in the Land`b`c`0`n");
			rawoutput("</big>");
			rawoutput("<table border='0' cellpadding='2' cellspacing='1' align='center' bgcolor='#999999'>");
			rawoutput("<tr class='trhead'><td>$rank</td><td>$oe</td><td>$pn</td><td>$ps</td></tr>");
			if (db_num_rows($result)>0){
				for($i = $pageoffset; $i < $cond && $count; $i++) {
					$row = db_fetch_assoc($result);
					if ($row['name']==$session['user']['name']){
						rawoutput("<tr class='trhilight'><td>");
					} else {
						rawoutput("<tr class='".($i%2?"trdark":"trlight")."'><td>");
					}
					$j=$i+1;
					output_notl("$j.");
					rawoutput("</td><td>");
					output_notl("`&%s`0",$row['name']);
					rawoutput("</td><td>");
					output_notl(stripslashes(get_module_pref("name","house",$row['acctid'])));
					rawoutput("</td><td>");
					output_notl("`c`@%s`c`0",$row['value']);
					rawoutput("</td></tr>");
				}
			}
			rawoutput("</table>");
		if ($total>$pp){
			addnav("Pages");
			for ($p=0;$p<$total;$p+=$pp){
				addnav(array("Page %s (%s-%s)", ($p/$pp+1), ($p+1), min($p+$pp,$total)), "runmodule.php?module=estbreak&op=hof&page=".($p/$pp+1));
			}
		}
	addnav("Other");
	addnav("Back to HoF", "hof.php");
	villagenav();
	}elseif ($op=="attack"){
			page_header("Estate Breakin - Attack");
				output("`)You sneak along a long narrow alleyway, and see the lights peek out from the windows.");
				output(" You can hear the folk sleeping soundly in their beds, unknowing of the death that is to come.");
				if ($session['user']['playerfights'] > 0 || $countpv <= $timespv){
					if (get_module_setting("guardian") == 1){
					output("`n`n`&You can hear the shapening of a blade nearby.");
					output(" You know that if you proceed, you may very well die.");
					addnav("Options");
					addnav("Peek Closer","runmodule.php?module=estbreak&op=guardian&op2=atk");
					}else{
					addnav("Options");
					addnav("Advance to the Window","runmodule.php?module=estbreak&op=atklist");
					}
					addnav("Return to the Estates","runmodule.php?module=house");
				}else{
					output("`n`nYou are too weary to look any closer...");
					output("The dogs of the Estates have been sniffing around for a while.");
					output(" You don't feel that today is a good time to go back.");
					addnav("Return to the Estates","runmodule.php?module=house");
				}
		}elseif ($op=="plunder"){
			if ($count <= $times){
				output("`)Using your Ninja like skills, you evade the front gates and are now in the Residential Area of %s.",$session['user']['location']);
				output(" Ahead of you, you see the houses.");
				output(" A sly grin slips across your face, and you look over the hedges.");
				output(" \"`@Which one should I attack?`)\"");
				if (get_module_setting("guardian") == 1){
					output("`n`n`&You can hear the shapening of a blade nearby.");
					output(" You know that if you proceed, you may very well die.");
					addnav("Options");
					addnav("Peek Closer","runmodule.php?module=estbreak&op=guardian&op2=plun");
				}else{
					addnav("Options");
					addnav("Advance to the Window","runmodule.php?module=estbreak&op=plunlist");
				}
				addnav("Return to the Estates","runmodule.php?module=house");
			}else{
				output("The dogs of the Estates have been sniffing around for a while.");
				output(" You don't feel that today is a good time to go back.");
				addnav("Return to the Estates","runmodule.php?module=house");
			}
		}elseif ($op=="guardian"){
			$badguy = array(
            "creaturename"=>translate_inline("`\$Guardian of the Estates`0"),
            "creaturelevel"=>$session['user']['level']+5,
            "creatureweapon"=>translate_inline("Lochaber Axe"),
			"creatureattack"=>$session['user']['attack']*$atk,
			"creaturedefense"=>$session['user']['defense']*$def,
			"creaturehealth"=>round($session['user']['maxhitpoints']*$hp),
			"diddamage"=>0,);
			$session['user']['badguy'] = createstring($badguy);
			$op = "setup";
			httpset('op', $op);
		}elseif ($op=="goforit"){
			$sql = "SELECT name FROM ".db_prefix("accounts")." WHERE acctid='$id'";
			$res = db_query($sql);
			$row = db_fetch_assoc($res);
			output("`3You sneak into %s's `3Estate and hear the creaking of the floorboards.",$row['name']);
			output(" You step on one, and a alarm goes off!");
			output(" Realizing you only have a few minutes before the Owner is woken up, you have to decide.`n`n");
			rawoutput("<big>");
			if (get_module_setting("enabletreasure","house") == 1 && get_module_setting("enablegems","house") == 1){
				output("`b`^Gold `3or `%Gems`3!?`b");
				addnav("Run!");
				addnav("Gold Storage","runmodule.php?module=estbreak&op=gold&id=$id");
				addnav("Gem Storage","runmodule.php?module=estbreak&op=gems&id=$id");
			}
			if (get_module_setting("enablegems","house") == 1 && get_module_setting("enabletreasure","house") != 1){
				output("Gems!");
				addnav("Run!");
				addnav("Gem Storage","runmodule.php?module=estbreak&op=gems&id=$id");
			}
			if (get_module_setting("enabletreasure","house") == 1 && get_module_setting("enablegems","house") != 1){
				output("Gold!");
				addnav("Run!");
				addnav("Gold Storage","runmodule.php?module=estbreak&op=gold&id=$id");
			}
			rawoutput("</big>");
			addnav("Run!");
			addnav("Outside","runmodule.php?module=house");
		}elseif ($op=="gold"){
			if ($treasure >= $session['user']['level']*$gold){
				output("`3You smiles with your decision of stealing `^Gold`3.");
				output(" You look into the Chest and see `^%s Gold`3.",$treasure);
				output(" At your current strength, you feel that you can steal `^%s 	gold`3.",$session['user']['level']*$gold);
				output(" Do you want to go for it?");
				addnav("Go For It","runmodule.php?module=estbreak&op=done&id=$id&op3=gold");
				addnav("Run For It","runmodule.php?module=house");
			}else{
				output("`3You suddenly realize that the amount of gold that is in the chest, is not worth your time and energy.");
				output(" You pick up your things, and casually walk out.");
				output(" Looking behind you, you see `^%s Gold`3.",$treasure);
				addnav("Return to the Alleyway","runmodule.php?module=house");
			}
		}elseif ($op=="gems"){
			if ($gemtreasure >= $session['user']['level']*$gems){
				output("`3You smiles with your decision of stealing `^Gold`3.");
				output(" You look into the Chest and see `5%s Gems`3.",$gemtreasure);
				output(" At your current strength, you feel that you can steal `5%s Gems`3.",$session['user']['level']*$gems);
				output(" Do you want to go for it?");
				addnav("Go For It","runmodule.php?module=estbreak&op=done&id=$id&op3=gems");
				addnav("Run For It","runmodule.php?module=house");
			}else{
				output("`3You suddenly realize that the amount of gems that is in the chest, is not worth your time and energy.");
				output(" You pick up your things, and casually walk out.");
				output(" Looking behind you, you see `5%s Gems`3.",$gemtreasure);
				addnav("Return to the Alleyway","runmodule.php?module=house");
			}
		}elseif ($op=="done"){
			$goldfinal = e_rand($session['user']['level'],$gold*$session['user']['level']);
			$gemfinal = e_rand(round($session['user']['level']/5),$gems*$session['user']['level']);
			debug("This is how much you are able to steal, minimum" . round($session['user']['level']/5));
			debug("This is how much you are able to steal, maximum" . $gems*$session['user']['level']);
			if ($op3=="gold"){
				output("`3You reach for the treasure, but then hear alarms going off!");
				output(" The Guardian appears behind you and lifts you up off of your feet.");
				output(" Holding you by the scruff of your neck, the Guardian brings you outside and throws you into the Garden's Lake.");
				output(" You look into your hand, and see firmly clenched, a bunch of twinkling pieces of gold.");
				output(" After counting, you see that you made off with `^%s Gold`3.",$goldfinal);
				$session['user']['gold']+=$goldfinal;
                set_module_objpref("house", $id, "treasure", $treasure - $goldfinal,"house");
				$subject = sprintf("Someone Has Broken In!");
				$body = sprintf("%s `3has broken into your estate, and made off with `^%s Gold`3.",$session['user']['name'],$goldfinal);
				$subject = translate_inline($subject);
				$body = translate_inline($body);
				systemmail($id,$subject,$body);
				addnav("Climb Out","gardens.php");
			}elseif ($op3=="gems"){
				output("`3You reach for the treasure, but then hear alarms going off!");
				output(" The Guardian appears behind you and lifts you up off of your feet.");
				output(" Holding you by the scruff of your neck, the Guardian brings you outside and throws you into the Garden's Lake.");
				output(" You look into your hand, and see firmly clenched, a bunch of gems.");
				output(" After counting, you see that you made off with `5%s Gems`3.",$gemfinal);
				$session['user']['gems']+=$gemfinal;
				set_module_objpref("house", $id, "gemtreasure", $gemtreasure - $gemfinal,"house");
				$subject = sprintf("Someone Has Broken In!");
				$body = sprintf("%s `3has broken into your estate, and made off with `5%s Gems`3.",$session['user']['name'],$gemfinal);
				$subject = translate_inline($subject);
				$body = translate_inline($body);
				systemmail($id,$subject,$body);
				addnav("Climb Out","gardens.php");
			}
			$alplun = get_module_pref("alplun");
			if (is_module_active("alignment") && get_module_setting("aliaff") == 1){
			align("-$alplun");
			}
			$count++;
			set_module_pref("count",$count);
		}elseif($op=="atklist"){
				page_header("Estate Breakin - Attack");
				if (get_module_setting("guardian") == 1 && get_module_setting("heal") == 1 && $session['user']['hitpoints'] < $amnt){
					output("`c`b`3A wandering bard appears beside you and rubs a healing salve upon your skin.");
					output(" You are healed for `\$%s Damage`3!`b`c`n`n`0",$heal);
					$session['user']['hitpoints']+=$heal;
				}
				$days = get_module_setting("days");
				$exp = get_module_setting("exp");
				$clanrankcolors=array("`!","`#","`^","`&");
				$lev1 = $session['user']['level']-1;
				$lev2 = $session['user']['level']+2;
				$last = date("Y-m-d H:i:s", strtotime("-".getsetting("LOGINTIMEOUT", 900)." sec"));
				$id = $session['user']['acctid'];
				$loc = $session['user']['location'];
				$sql = "SELECT name, alive, ".db_prefix("module_userprefs").".value AS location, sex, level, laston, loggedin, login, pvpflag, clanshort, clanrank
				FROM ".db_prefix("accounts")."
				LEFT JOIN ".db_prefix("clans")." ON ".db_prefix("clans").".clanid=".db_prefix("accounts").".clanid
				INNER JOIN ".db_prefix("module_userprefs")." ON ".db_prefix("accounts").".acctid=".db_prefix("module_userprefs").".userid
				WHERE (locked=0)
				AND ".db_prefix("module_userprefs").".setting = 'location_saver'
				AND ".db_prefix("module_userprefs").".modulename = 'house'
				AND (slaydragon=0) AND
				(age>$days OR dragonkills>0 OR pk>0 OR experience>$exp)
				AND (level>=$lev1 AND level<=$lev2) AND (alive=1)
				AND (laston<'$last' OR loggedin=0) AND (acctid<>$id)
				ORDER BY location='$loc' DESC, location, level DESC,
				experience DESC, dragonkills DESC";
				pvplist($loc,"runmodule.php?module=estbreak","&op=combat&pvp=1", $sql);
				addnav("Actions");
				addnav("Refresh List","runmodule.php?module=estbreak&op=atklist");
				addnav("Return");
				addnav("Return to the Alleyway","runmodule.php?module=house");
		}elseif ($op=="plunlist"){
			if (get_module_setting("guardian") == 1 && get_module_setting("heal") == 1 && $session['user']['hitpoints'] < $amnt){
				output("`c`b`3A wandering bard appears beside you and rubs a healing salve upon your skin.");
				output(" You are healed for `\$%s Damage`3!`b`c`n`n`0",$heal);
				$session['user']['hitpoints']+=$heal;
			}
			output("`)You dart across the grounds and pull out a small map.");
			output(" On it, you see the location of all of the houses in the area, as well as the Owner's names.`n`n");
            $sql = "SELECT userid FROM ".db_prefix("module_userprefs")." WHERE modulename='house' AND setting='village' AND value='".$session['user']['location']."'";
            $result = db_query ($sql);
            $i = 0;
			$name = translate_inline("Name");
			$owner = translate_inline("Owner");
			$size = translate_inline("House Size");
			rawoutput("<table border='1' cellpadding='3' cellspacing='0'>");
            rawoutput("<tr class='trhead'><td>$name</td><td>$owner</td><td>$size</td></tr>");
            while ($row = db_fetch_assoc($result)) {
                $i ++;
                rawoutput("<tr class='".($i%2?"trlight":"trdark")."'>");
                rawoutput("<td>");
                output_notl(stripslashes(get_module_pref("name","house",$row['userid'])));
                rawoutput("</td><td>");
                $sql = "SELECT name,acctid FROM ".db_prefix("accounts")." WHERE acctid=".$row['userid'];
                $result2 = db_query ($sql);
                $row2 = db_fetch_assoc($result2);
				rawoutput("<a href='runmodule.php?module=estbreak&op=goforit&id=".rawurlencode($row['userid'])."'>");
                output_notl($row2['name']);
				rawoutput("</a>");
                $housesize = get_module_pref("housesize","house",$row['userid']);
                rawoutput ("</td><td>");
                if ($housesize > 0) output_notl("$housesize");
                else output("`6In Construction");
                rawoutput("</td></tr>");
				addnav("","runmodule.php?module=estbreak&op=goforit&id=".rawurlencode($row['userid'])."");
            }
            rawoutput("</table>");
			addnav("Return");
			addnav("Return to the Alleyway","runmodule.php?module=estbreak&op=plunder");
			addnav("","runmodule.php?module=estbreak&op=goforit&id=".rawurlencode($row['userid'])."");
		} elseif ($op=="combat") {
			// Okay, we've picked a person to fight.
	        require_once("lib/pvpsupport.php");
		    $name = httpget("name");
			$badguy = setup_target($name);
	        $failedattack = false;
		    if ($badguy===false) {
			    output("`n`nYou survey the area again.`n");
				addnav("Return");
				addnav("Return to the Alleyway","runmodule.php?module=estbreak&op=attack");
	        } else {
		        $battle = true;
			    $session['user']['badguy']=createstring($badguy);
				$session['user']['playerfights']--;
	        }
		}
	if ($op == "setup"){
		suspend_buff_by_name("mount","`b`c`\$Your Mount runs away scared.`b`c`0");
		$op = "fight";
	}
	if ($op=="fight"){
		$battle = true;
	}
    if ($battle){
        include_once("battle.php");
        if ($victory){
			if ($pvp){
                require_once("lib/pvpsupport.php");
				$killedin = $badguy['location'];
				pvpvictory($badguy, $killedin);
                addnews("`4%s`3 defeated `4%s`3 while they were sleeping in their Estate.", $session['user']['name'], $badguy['creaturename']);
                $badguy=array();
				addnav("Return");
				addnav("Return to the Alleyway","runmodule.php?module=house");
		}else{
				$badguy=array();
				addnav("Advance");
			if ($op2=="atk"){
				addnav("Advance to the Window","runmodule.php?module=estbreak&op=atklist");
			}elseif ($op2=="plun"){
				addnav("Sneak Closer","runmodule.php?module=estbreak&op=plunlist");
			}
		}
		unsuspend_buffs("allowinpvp","`bYour Mount canters back to you. You smack it over the head, for being a big scaredy cat`b`0");
		$countpv++;
		set_module_pref("countpv",$countpv);
		$alatk = get_module_pref("alatk");
		if (is_module_active("alignment") && get_module_setting("aliaff") == 1){
			align("-$alatk");
		}
        }elseif ($defeat){
			if ($pvp){
				require_once("lib/pvpsupport.php");
				$killedin = $badguy['location'];
				$taunt = select_taunt_array();
				pvpdefeat($badguy, $killedin, $taunt);
                addnews("`4%s`3 was defeated while attacking `4%s`3 as they were sleeping in their Estate.`n%s", $session['user']['name'], $badguy['creaturename'], $taunt);
				output("`n`n`&You are sure that someone, sooner or later, will stumble over your corpse and return it to %s for you." , $session['user']['location']);
			}else{
				$exploss = $session['user']['experience']*.1;
				output("The titan strikes down one final blow and knocks you out cold.");
				output(" You lose %s experience and all of your gold on hand.",$exploss);
				$session['user']['experience']-=$exploss;
				$session['user']['gold']=0;
				debuglog("lost $exploss experience and all gold to Estate Guardian.");
				addnews("%s fell before the mighty blade of the Estate Watcher.",$session['user']['name']);
				addnav("Return");
				addnav("Return to the Shades","shades.php");
			}
		unsuspend_buff_by_name("mount","`bYour Mount canters back to you. You smack it over the head, for being a big scaredy cat`b`0");
		$countpv++;
		set_module_pref("countpv",$countpv);
        }else{
            require_once("lib/fightnav.php");
            $allow = true;
            $extra = "";
            if ($pvp) {
                $allow = false;
                $extra = "&pvp=1&";
	            fightnav($allow,$allow,$script.$extra);
            }else{
				$allow = true;
				$extra = "&guard=1&";
	            fightnav($allow,false,$script.$extra);
			}
        }
    }
	if ($session['user']['superuser'] & SU_DEVELOPER) addnav("Escape to Village","village.php");
page_footer();
}
?>