<?php
/**
	29/09/2010 - v1.0.0

	Notes:
	You'll notice that I use a field named 'racetextarea'. The php code for this can be found in
	the 'race_creator.php' module file at the bottom. That module hooks into 'showformextensions',
	which allows you to add your own form fields. :)  'racetextarea' is basically a copy of 'textarea'
	but with one difference, it doesn't replace `n with \n which I found really annoying. :)
*/
function race_customisetext_getmoduleinfo()
{
	$info = array(
		"name"=>"Race Customise Text",
		"description"=>"Customise the village/stables/armour/weapon text for each race.",
		"version"=>"1.0.0",
		"author"=>"`@MarcTheSlayer",
		"category"=>"Races",
		"download"=>"",
		"requires"=>array(
			"race_creator"=>"1.0.0|`@MarcTheSlayer`2, available on Dragonprime.net"
		),
		"prefs-races"=>array(
			"Allow/Disable text,title",
				"disable"=>"Disable text for this race?,bool|1",
				"`2Saves you from having to delete everything you've typed in.,note",
			"Village Text,title",
				"villtitle"=>"Title:,string,60",
				"villtext"=>"Main Description:,racetextarea,30",
				"villclock"=>"Clock Line:,text",
				"`2Requires one `b%s`b`n1st `b%s`b - current time.,note",
				"villnewest1"=>"Newest Player (you):,text",
				"villnewest2"=>"Newest Player (them):,text",
				"`2Requires one `b%s`b`n1st `b%s`b - newest player's name.,note",
				"villtalk"=>"Chat area line:,text",
				"villsayline"=>"Say Line:,string,60",
				"villsection"=>"Chat Section \"village-,string,60",
				"`2eg: \"village-Romar\"`nBe very careful what you name this&#44; otherwise it may only be viewable by this race. It can't be used to create different villages. I recommend that you leave it blank.`n`i`b`3Do not add the 'village-' part!`b`i,note",
				"villgatenav"=>"Gate Nav:,string,60",
				"villfightnav"=>"Fight Nav:,string,60",
				"villmarketnav"=>"Market Nav:,string,60",
				"villtavernnav"=>"Tavern Nav:,string,60",
				"villinfonav"=>"Info Nav:,string,60",
				"villothernav"=>"Other Nav:,string,60",
				"villinnname"=>"Inn Name:,string,60",
				"villstablename"=>"Stable Name:,string,60",
				"villmercenarycamp"=>"Mercenarycamp Name:,string,60",
				"villarmorshop"=>"Armour shop Name:,string,60",
				"villweaponshop"=>"Weapon shop Name:,string,60",
			"Stables Text,title",
				"stabtitle"=>"Title:,string,60",
				"stabdesc"=>"Main Description:,racetextarea,30",
				"`2Requires one `b%s`b`n1st `b%s`b - lass/lad name.,note",
				"stablass"=>"Female name (eg: lass):,string,30",
				"stablad"=>"Male name (eg: lad):,string,30",
				"stabnosuchbeast"=>"No Mounts:,racetextarea,30",
				"stabfinebeast"=>"Fine Mount:,racetextarea,30",
				"`2Multiple lines. Place each on a new line.,note",
				"stabtoolittle"=>"Too Little:,racetextarea,30",
				"`2Requires three `b%s`b`n1st `b%s`b - new mount name.`n2nd `b%s`b - cost gold.`n3rd `b%s`b - cost gems.,note",
				"stabreplacemount"=>"Replaced your mount:,racetextarea,30",
				"`2Requires two `b%s`b`n1st `b%s`b - current mount name.`n2nd `b%s`b - new mount name.,note",
				"stabnewmount"=>"Bought a mount:,racetextarea,30",
				"`2Requires one `b%s`b`n1st `b%s`b - new mount name.,note",
				"stabnofeed"=>"No feed:,racetextarea,30",
				"`2Requires one `b%s`b`n1st `b%s`b - lass/lad name.,note",
				"stabnothungry"=>"Mount isn't hungry:,racetextarea,30",
				"`2Requires one `b%s`b`n1st `b%s`b - current mount name.,note",
				"stabhalfhungry"=>"Mount is half hungry:,racetextarea,30",
				"`2Requires three `b%s`b`n1st `b%s`b - current mount name.`n2nd `b%s`b - feed cost.`n3rd `b%s`b - feed cost.,note",
				"stabhungry"=>"Mount is hungry:,racetextarea,30",
				"`2Requires three `b%s`b`n1st `b%s`b - current mount name.`n2nd `b%s`b - feed cost.`n3rd `b%s`b - feed cost.,note",
				"stabmountfull"=>"Fed mount:,racetextarea,30",
				"`2Requires two `b%s`b`n1st `b%s`b - lass/lad name.`n2nd `b%s`b - current mount name.,note",
				"stabnofeedgold"=>"No gold for feed:,racetextarea,30",
				"`2Requires one `b%s`b`n1st `b%s`b - current mount name.,note",
				"stabconfirmsale"=>"Confirm sale:,racetextarea,30",
				"`2Requires one `b%s`b`n1st `b%s`b - lass/lad name.,note",
				"stabmountsold"=>"Sold your mount:,racetextarea,30",
				"`2Requires two `b%s`b`n1st `b%s`b - sold mount name.`n2nd `b%s`b - repaid gold and gems.,note",
				"staboffer"=>"Offer for mount:,racetextarea,30",
				"`2Requires three `b%s`b`n1st `b%s`b - repaid gold.`n2nd `b%s`b - repaid gems.`n3rd `b%s`b - current mount name.,note",
			"Armour Shop Text,title",
				"armtitle"=>"Title:,string,60",
				"armdesc"=>"Main Description:,racetextarea,30",
				"armtradein"=>"Trade in:,racetextarea,30",
				"`2Requires two `b%s`b`n1st `b%s`b - armour trade in price.`n2nd `b%s`b - armour name.,note",
				"armnosuchweapon"=>"No such armour:,racetextarea,30",
				"armtryagain"=>"Try Again:,string,60",
				"armnotenoughgold"=>"Not enough gold:,racetextarea,30",
				"`2Requires one `b%s`b`n1st `b%s`b - armour name.,note",
				"armpayarmor"=>"Pay for armour:,racetextarea,30",
				"`2Requires three `b%s`b`n1st `b%s`b - old armour name.`n2nd `b%s`b - new armour name.`n3rd `b%s`b - new armour name.,note",
			"Weapon Shop Text,title",
				"weaptitle"=>"Title:,string,60",
				"weapdesc"=>"Main Description:,racetextarea,30",
				"weaptradein"=>"Trade in:,racetextarea,30",
				"`2Requires two `b%s`b`n1st `b%s`b - weapon trade in price.`n2nd `b%s`b - weapon name.,note",
				"weapnosuchweapon"=>"No such weapon:,racetextarea,30",
				"weaptryagain"=>"Try Again:,string,60",
				"weapnotenoughgold"=>"Not enough gold:,racetextarea,30",
				"`2Requires one `b%s`b`n1st `b%s`b - weapon name.,note",
				"weappayweapon"=>"Pay for weapon:,racetextarea,30",
				"`2Requires two `b%s`b`n1st `b%s`b - old weapon name.`n2nd `b%s`b - new weapon name.,note",
			"Trade in Cost,title",
				"tradeinweap"=>"Weapon trade in cost:,range,0,100,5|75",
				"tradeinarm"=>"Armour trade in cost:,range,0,100,5|75",
				"`^Set to 100% to give the full amount back.,note",
			"Mercenary Camp Text,title",
				"merctitle"=>"Title:,string,60",
				"mercdesc"=>"Main Description:,racetextarea,30",
				"mercbuynav"=>"Buy Nav:,string,60",
				"merchealnav"=>"Heal Nav:,string,60",
				"merchealtext"=>"Healed Text:,racetextarea,30",
				"merchealnotenough"=>"Not Healed Text:,racetextarea,30",
				"merchealpaid"=>"Healed Paid:,racetextarea,30",
				"merctoomanycompanions"=>"Too many companions:,racetextarea,30",
				"mercmanycompanions"=>"Many offers to join you:,text",
				"merconecompanion"=>"One offers Tto join you:,text",
				"mercnocompanions"=>"No one offers to join you:,text",
		),
	);
	return $info;
}

function race_customisetext_install()
{
	output("`c`b`Q%s 'race_customisetext' Module.`b`n`c", translate_inline(is_module_active('race_customisetext')?'Updating':'Installing'));
	module_addhook('moderate');
	module_addhook('raceinvalidatecache');
	module_addhook_priority('villagetext',70);
	module_addhook_priority('stabletext',70);
	module_addhook_priority('armortext',70);
	module_addhook_priority('weaponstext',70);
	module_addhook_priority('mercenarycamptext',70);
	return TRUE;
}

function race_customisetext_uninstall()
{
	output("`n`c`b`Q'race_customisetext' Module Uninstalled`0`b`c");
	return TRUE;
}

function race_customisetext_dohook($hookname,$args)
{
	global $session;

	if( $hookname != 'moderate' || $hookname != 'raceinvalidatecache' )
	{
		$raceid = get_module_pref('raceid','race_creator');
		// Text for this race is disabled.
		if( get_module_objpref('races',$raceid,'disable') == 1 ) return $args;
	}

	switch( $hookname )
	{
		case 'moderate':
			tlschema('commentary');
			$sql = "SELECT raceid, racename
					FROM " . db_prefix('races');
			$result = db_query($sql);
			while( $row = db_fetch_assoc($result) )
			{
				$section = get_module_objpref('cities', $row['raceid'], 'villsection');
				if( $section != '' ) $args["village-$section"] = sprintf_translate("Race: %s Village", $row['racename']);
			}
			tlschema();
			return $args;
		break;

		case 'raceinvalidatecache':
			invalidatedatacache('race_customisetext-'.$args['raceid']);
			return $args;
		break;

		case 'villagetext':
			$name = 'vill';
			$new = 0;
			if( is_module_active('cities') )
			{
				$city = $session['user']['location'];
				$new = get_module_setting("newest-$city",'cities');
				if( $new != 0 )
				{
					$sql = "SELECT name
							FROM " . db_prefix('accounts') . "
							WHERE acctid = '$new'";
					$result = db_query_cached($sql, "newest-$city");
					$row = db_fetch_assoc($result);
					$args['newestplayer'] = $row['name'];
					$args['newestid'] = $new;
				}
				else
				{
					$args['newestplayer'] = $new;
					$args['newestid'] = '';
				}
			}
		break;
		case 'stabletext':			$name = 'stab';	break;
		case 'armortext':			$name = 'arm';	break;
		case 'weaponstext':			$name = 'weap';	break;
		case 'mercenarycamptext':	$name = 'merc';	break;
	}

	// Get the village for the player's race.
	$sql = "SELECT racevillage
			FROM " . db_prefix('races') . "
			WHERE raceid = '$raceid'";
	$result = db_query($sql);
	$row = db_fetch_assoc($result);
    if( $session['user']['location'] != $row['racevillage'] ) return $args; // Location doesn't match current location then stop here.

	// Get the text for this place.
	$sql = "SELECT setting, value
			FROM " . db_prefix('module_objprefs') . "
			WHERE modulename = 'race_customisetext'
				AND objtype = 'races'
				AND setting LIKE '$name%'
				AND objid = '$raceid'";
	$result = db_query_cached($sql, "race_customisetext-$raceid", 86400);

	while( $row = db_fetch_assoc($result) )
	{
		if( $row['value'] != '' )
		{
			// This needs to be above the str_replace line as only the stable has lad/lass.
			if( $row['setting'] == 'stabdesc' ) $row['value'] = array(array(stripslashes($row['value']), translate_inline($session['user']['sex']?get_module_objpref('races', $raceid, 'stablass'):get_module_objpref('races', $raceid, 'stablad'), 'module-race_customisetext_'.$raceid)));

			$row['setting'] = str_replace($name,'',$row['setting']); // Strip out the setting name identifier.

			if( $row['setting'] == 'finebeast' )
			{	// Put each line into an array.
				$row['value'] = explode("\r\n", $row['value']);
				foreach( $row['value'] as $key => $value ) $row['value'][$key] = stripslashes($value);
			}
			if( $row['setting'] == 'tradein' )
			{
				if( $name == 'weap' ) $row['value'] = array(array(stripslashes($row['value']), round(($session['user']['weaponvalue']*(get_module_objpref('races', $raceid, 'tradeinweap')/100)),0), $session['user']['weapon']));
				elseif( $name == 'arm' ) $row['value'] = array(array(stripslashes($row['value']), round(($session['user']['armorvalue']*(get_module_objpref('races', $raceid, 'tradeinarm')/100)),0), $session['user']['armor']));
			}
			if( $row['setting'] == 'title' ) $row['value'] = strip_tags($row['value']);
			if( $name == 'vill' )
			{
				if( $row['setting'] == 'newest1' && $new == $session['user']['acctid'] )
				{
					$args['newest'] = $row['value'];
				}
				if( $row['setting'] == 'newest2' && $new != $session['user']['acctid'] )
				{
					$args['newest'] = $row['value'];
				}
			}

			$args[$row['setting']] = ( is_array($row['value']) ) ? $row['value'] : stripslashes($row['value']);
			$args['schemas'][$row['setting']] = 'module-race_customisetext_'.$raceid;
		}
	}

	return $args;
}

function race_customisetext_run()
{
}
?>