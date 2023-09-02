<?php
	include('modules/race_creator/race_creator_functions.php');

	if( !empty($raceid) )
	{
		//
		// Get race data and send it for checking.
		//
		$sql = "SELECT *
				FROM " . db_prefix('races') . "
				WHERE raceid = '$raceid'";
		$result = db_query($sql);
		$row = db_fetch_assoc($result);
		if( db_num_rows($result) <> 1 )
		{
			output('`n`$Error: That race was not found!`0`n`n');
			$row = race_creator_array_check();
		}
		else
		{
			$row['rcbuff'] = @unserialize($row['newdaybuff']);
			unset($row['newdaybuff']);
			$row = race_creator_array_check($row);
		}
		$addnew = 'bool';
	}
	else
	{
		$row = race_creator_array_check();
		$addnew = 'invisible';
	}

	$form = array(
		'Race Details,title',
			'addnew'=>'Add as new?,'.$addnew,
			'raceactive'=>'Race is Active?,bool',
			'module'=>'Module:,viewonly',
			'raceid'=>'Race ID:,hidden',
			'raceauthor'=>'Race Author:,string,30',
			'racename'=>'Race Name:,string,30',
			"`^No colours or any sort of tags in the race name.,note",
			'racevillage'=>'Race Village:,location',
			'racecolour'=>'Race Colour:,enum,0,None,`!,Light Blue,`1,Dark Blue,`@,Light Green,`2,Dark Green,`#,Light Cyan,`3,Dark Cyan,`$,Light Red,`4,Dark Red,`%,Light Magenta,`5,Dark Magenta,`^,Light Yellow,`6,Dark Yellow,`&,Light White,`7,Dark White,`),Light Black,`~,Black,`Q,Light Orange,`q,Dark Orange,`t,Light Brown,`T,Dark Brown,`E,Light Rust,`e,Dark Rust,`L,Light LinkBlue,`l,Dark LinkBlue,`y,Khaki,`Y,Dark Khaki,`K,Dark Seagreen,`r,Rose,`R,Rose,`v,Ice Violet,`V,Blue Violet,`g,XLtGreen,`G,XLtGreen,`j,MdGrey,`J,MdBlue,`x,Burlywood,`X,Beige,`k,Aquamarine,`p,Light Salmon,`P,Salmon,`m,Wheat,`M,Tan',
			'racechoose'=>'Choose Race Text:,racetextarea,30',
			'raceset'=>'Set Race Text:,racetextarea,30',
			'racenewday'=>'Newday Race Text:,racetextarea,30',
			'`@To remove turns/travel/pvp/fights simply enter a negative value.,note',
			'raceturns'=>'Turns lost/gained each Newday:,int',
			'`^Default turns per day is '.getsetting('turns',10).'. Add to or subtract from this number to give more or less turns. Entering -4 will mean they get 6 turns each newday.,note',
			'racetravel'=>'Travel lost/gained each Newday:,int',
			'`^Default travel per day is '.get_module_setting('allowance','cities').'.,note',
			'racepvp'=>'PVP turns lost/gained each Newday:,int',
			'`^Default PVP turns per day is '.getsetting('pvpday',3).'.,note',
			'racegrave'=>'Grave fights lost/gained each Newday:,int',
			'`^Default grave fights per day is '.getsetting('gravefightsperday',10).'.,note',
			'alter-gemchance'=>'Alter Gemchance (1 in #):,range,0,100,1',
			'`^Default chance for finding a gem after a fight is '.getsetting('forestgemchance', 25).'.`nEnter 0 for default to be used.,note',
		'Raw PHP Code,title',
			'`i`^Leave these alone if you don\'t know what you\'re doing.`n`nThe code is run inside the eval() function so don\'t forget to include `bglobal`b if it\'s needed.`i,note',
			'pvpadjust'=>'PVP Adjust Code:,racetextarea,30',
			'`^$row = modulehook("pvpadjust"&#44; $row);`nLine: 45 - /pvpsupport.php,note',
			'creatureencounter'=>'Creature Encounter Code:,racetextarea,30',
			'`^$badguy = modulehook("creatureencounter"&#44;$badguy);`nLine: 200 - /lib/forestoutcomes.php,note',
			'battle-victory'=>'Battle Victory:,racetextarea,30',
			'`^$badguy = modulehook("battle-victory"&#44;$badguy);`nLine: 505 - /battle.php,note',
			'battle-defeat'=>'Battle Defeat:,racetextarea,30',
			'`^$badguy = modulehook("battle-defeat"&#44;$badguy);`nLine: 506 - /battle.php,note',
			'`@Of the 109 race modules I looked at&#44; these 4 module hooks were the only ones that anybody ever added.,note',
		'Racialbenefit Buff,title',
			'rcbuffname'=>'Buff name:,',
			'`b`i`#Messages:`i`b,note',
			'rcbuffroundmsg'=>'Buff Round Message:,',
			'rcbuffwearoff'=>'Buff Wearoff Message:,',
			'rcbuffeffectmsg'=>'Buff Effect Message:,',
			'rcbuffeffectnodmgmsg'=>'Buff No Damage Message:,',
			'rcbuffeffectfailmsg'=>'Buff Fail Message:,',
			'`3Message replacements:`n{badguy}&#44; {goodguy}&#44; {weapon}&#44; {armor}&#44; {creatureweapon}&#44; and where applicable {damage}.,note',
			'`b`i`#Effects:`i`b,note',
			'rcbuffrounds'=>'Rounds To Last:,int',
			'rcbuffallowinpvp'=>'Allow in PVP:,bool',
			'rcbuffallowintrain'=>'Allow in Training:,bool',
			'rcbuffinvulnerable'=>'Player is Invulnerable:,bool',
			'rcbuffatkmod'=>'Player Attack Mod (multiplier):,',
			'rcbuffdefmod'=>'Player Defence Mod (multiplier):,',
			'rcbuffregen'=>'Regeneration (healing):,',
			'rcbuffminioncount'=>'Minion Count:,',
			'rcbuffminbadguydamage'=>'Min Badguy Damage:,',
			'rcbuffmaxbadguydamage'=>'Max Badguy Damage:,',
			'rcbuffmingoodguydamage'=>'Min Goodguy Damage:,',
			'rcbuffmaxgoodguydamage'=>'Max Goodguy Damage:,',
			'rcbufflifetap'=>'Lifetap (multiplier):,',
			'rcbuffdamageshield'=>'Damageshield (multiplier):,',
			'rcbuffbadguydmgmod'=>'Badguy Damage Mod (multiplier):,',
			'rcbuffbadguyatkmod'=>'Badguy Attack Mod (multiplier):,',
			'rcbuffbadguydefmod'=>'Badguy Defence Mod (multiplier):,',
			'`b`i`#On Dynamic Buffs:`i`b,note',
			'`3In the above&#44; for most fields&#44; you can choose to enter valid PHP code&#44; substituting <fieldname> for fields in the user\'s account table.`nExamples of code you might enter:`n
			`^&lt;charm&gt;`nround(&lt;maxhitpoints&gt;/10)`nround(&lt;level&gt;/max(&lt;gems&gt;&#44;1)),note',
			'`3Fields you might be interested in for this:`n`Qname&#44; sex `7(0=male 1=female)`Q&#44; specialty `7(DA=darkarts MP=mystical TS=thief)`Q&#44; 
			experience&#44; gold&#44; weapon `7(name)`Q&#44; armor `7(name)`Q&#44; level&#44;`ndefense&#44; attack&#44; alive&#44; goldinbank&#44; 
			spirits `7(-2 to +2 or -6 for resurrection)`Q&#44; hitpoints&#44; maxhitpoints&#44; gems&#44; 
			weaponvalue `7(gold value)`Q&#44; armorvalue `7(gold value)`Q&#44; turns&#44; title&#44; weapondmg&#44; armordef&#44; 
			age `7(days since last DK)`Q&#44; charm&#44; playerfights&#44; dragonkills&#44; resurrections `7(times died since last DK)`Q&#44; 
			soulpoints&#44; gravefights&#44; deathpower `7('.getsetting('deathoverlord', '`$Ramius').' `7favor)`Q&#44; race&#44; dragonage&#44; bestdragonage.,note',
			'`3You can also use module preferences by using &lt;modulename|preference&gt;`n(for instance &#34;&lt;specialtymystic|uses&gt;&#34; or &#34;&lt;drinks|drunkeness&gt;&#34;,note',
			'`@Finally&#44; starting a field with &#34;debug:&#34; will enable debug output for that field to help you locate errors in your implementation. While testing new buffs&#44; you should be sure to debug fields before you release them on the world&#44; as the PHP script will otherwise throw errors to the user if you have any&#44; and this can break the site at various spots (as in places that redirects should happen).,note',
			'`n`#More information on buffs can be found at <a href="http://wiki.dragonprime.net/index.php?title=Buffs" target="_blank">wiki.dragonprime.net</a>.`n`n,note',
	);

	//
	// Get the names of the modules that have 'prefs-races' setting.
	//
	$sql = "SELECT formalname, modulename
			FROM " . db_prefix('modules') . "
			WHERE infokeys
			LIKE '%|prefs-races|%'
			ORDER BY formalname";
	$result = db_query($sql);
	while( $row2 = db_fetch_assoc($result) )
	{
		$formalname = $row2['formalname'];
		$modulename = modulename_sanitize($row2['modulename']);
		$info = get_module_info($modulename);
		if( count($info['prefs-races']) > 0 )
		{
			//
			// Get all the settings for each module and add to the array.
			//
			$form[] = $formalname.',title'; // Each module gets its own title.
			while( list($key, $val) = each($info['prefs-races']) )
			{
				if( ($pos = strpos($val, ',title')) !== FALSE )
				{	// Any titles get converted to notes.
					$val = '`^`i'.str_replace(',title', '`i,note', $val);
				}
				if( is_array($val) )
				{
					$v = $val[0];
					$x = explode("|", $v);
					$val[0] = $x[0];
					$x[0] = $val;
				}
				else
				{
					$x = explode("|", $val);
				}
				$form[$modulename.'-'.$key] = $x[0];
				// Set up default values.
				$row[$modulename.'-'.$key] = ( isset($x[1]) ) ? $x[1] : '';
			}

			//
			// Now get any data for the settings.
			//
			$sql = "SELECT setting, value
					FROM " . db_prefix('module_objprefs') . "
					WHERE modulename = '$modulename'
						AND objtype = 'races'
						AND objid = '$raceid'";
			$result2 = db_query($sql);
			while( $row3 = db_fetch_assoc($result2) )
			{
				$row[$modulename.'-'.$row3['setting']] = stripslashes($row3['value']);
			}
		}
	}

	//
	// Display form.
	//
	rawoutput('<form action="'.$from.'&op=save" method="POST">');
	addnav('',$from.'&op=save');
	require_once('lib/showform.php');
	showform($form, $row);
	rawoutput('<input type="hidden" name="oldvalues" value="'.htmlentities(serialize($row), ENT_COMPAT, getsetting("charset", "ISO-8859-1")).'" /></form>');

	addnav('Editor');
	addnav('Add a Race',$from.'&op=edit');
	addnav('Main Page',$from);
?>