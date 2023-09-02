<?php
/**
	29/09/2010 - v1.0.0
	Based on Iori's 'mountprereq' module v1.01
	01/06/2013 - v1.0.1
	+ Added 'donationconfig' code.
	12/07/2014 - v1.0.2
	+ Added brackets to some IF lines to order the requirements better. Thanks Doctor. :)
*/
function race_prerequisites_getmoduleinfo()
{
	$info = array(
		"name"=>"Race Prerequisites",
		"description"=>"Required conditions for races.",
		"version"=>"1.0.2",
		"author"=>"`@MarcTheSlayer`2, based on`#Iori's `2'mountprereq'`0",
		"category"=>"Races",
		"download"=>"",
		"requires"=>array(
			"race_creator"=>"1.0.1|`@MarcTheSlayer`2, available on Dragonprime.net"
		),
		"prefs-races"=>array(
			"Dragon Kills,title",
				"dks"=>"Dragon kill condition for availability:,enum,0,Ignore,1,Below Low DK,2,Between Low and High,3,Above High DK",
				"dkslo"=>"`\$Low Dragon Kills:,int",
				"dkshi"=>"`2High Dragon Kills:,int",
			"Alignment,title",
				"`i`2Requires the 'alignment' module to be installed.`i,note",
				"alignment"=>"Alignment condition for availability:,enum,0,Ignore,1,Below Low alignment,2,Between Low and High,3,Above High allignment",
				"alignlo"=>"`\$Low Alignment:,int",
				"alignhi"=>"`2High Alignment:,int",
			"Required Charm,title",
				"charmreq"=>"`&Charm:,int",
			"Required Gender,title",
				"sexreq"=>"Player gender:,enum,0,Ignore,1,Male,2,Female",
			"Donation Points,title",
				"donationreq"=>"Required available Donation Points:,int",
				"donationcost"=>"or Cost to purchase race at the Lodge:,int",
				"`2Race will always be available if they've bought it&#44; else all the other requirements must be met.,note",
		),
		"prefs"=>array(
			"bought"=>"Races bought at the Lodge:,viewonly",
		),
	);
	return $info;
}

function race_prerequisites_install()
{
	output("`c`b`Q%s 'race_prerequisites' Module.`b`n`c", translate_inline(is_module_active('race_prerequisites')?'Updating':'Installing'));
	module_addhook('raceinvalidatecache');
	module_addhook('racedeleted');
	module_addhook('raceprerequisite');
	module_addhook('racerequirements');
	module_addhook('lodge');
	module_addhook('lodge_incentives');
	module_addhook('pointsdesc');
	return TRUE;
}

function race_prerequisites_uninstall()
{
	output("`n`c`b`Q'race_prerequisites' Module Uninstalled`0`b`c");
	return TRUE;
}

function race_prerequisites_dohook($hookname, $args)
{
	global $session;

	switch($hookname)
	{
		case 'raceinvalidatecache':
			invalidatedatacache('race_prerequisites-'.$args['raceid']);
			invalidatedatacache('race_prerequisites-lodge');
		break;

		case 'racedeleted':
			// If the deleted race was lodge point bought then remove it from the 'bought' array.
			$sql = "SELECT a.acctid, m.value AS bought
					FROM " . db_prefix('accounts') . " a
					INNER JOIN " . db_prefix('module_userprefs') . " m
						ON a.acctid = m.userid
					WHERE m.modulename = 'race_prerequisites'
						AND m.setting = 'bought'
						AND m.value != ''";
			$result = db_query($sql);
			while( $row = db_fetch_assoc($result) )
			{
				$bought_races = @unserialize($row['bought']);
				if( is_array($bought_races) )
				{
					$key = array_search($args['raceid'], $bought_races);
					unset($bought_races[$key]);
					set_module_pref('bought',serialize($bought_races),'race_prerequisites',$row['acctid']);
					// Sorry, no lodge point refunds. :)
				}
			}
		break;

		case 'raceprerequisite':
			if( $args['blocked'] == 1 ) break; // If another module has already blocked it.
			$alignment_active = is_module_active('alignment');
			$donationavail = $session['user']['donation'] - $session['user']['donationspent'];
			if( $donationavail < 0 ) $donationavail = 0;
			$bought_races = @unserialize(get_module_pref('bought'));
			if( !is_array($bought_races) ) $bought_races = array();

			$sql = "SELECT setting, value
					FROM " . db_prefix('module_objprefs') . "
					WHERE modulename = 'race_prerequisites'
						AND objtype = 'races'
						AND objid = '{$args['raceid']}'";
			$result = db_query_cached($sql, 'race_prerequisites-'.$args['raceid'], 86400);
			$prereq = array('dks'=>0,'dkslo'=>'','dkshi'=>'','alignment'=>0,'alignlo'=>'','alignhi'=>'','charmreq'=>'','sexreq'=>0,'donationreq'=>0);
			while( $row = db_fetch_assoc($result) )
			{
				$prereq[$row['setting']] = $row['value'];
			}

			// DragonKills
			if( $prereq['dks'] != 0 )
			{
				if( $prereq['dks'] == 1 && $session['user']['dragonkills'] > $prereq['dkslo'] )
				{
					$args['blocked'] = 1;
					debug("Blocked {$args['racename']} - Too many DKs.");
				}
				elseif( $prereq['dks'] == 2 && ($session['user']['dragonkills'] < $prereq['dkslo'] || $session['user']['dragonkills'] > $prereq['dkshi']) )
				{
					$args['blocked'] = 1;
					debug("Blocked {$args['racename']} - Too many or not enough DKs.");
				}
				elseif( $prereq['dks'] == 3 && $session['user']['dragonkills'] < $prereq['dkshi'] )
				{
					$args['blocked'] = 1;
					debug("Blocked {$args['racename']} - Not enough Dks.");
				}
			}
			// Alignment
			if( $alignment_active && $prereq['alignment'] != 0 )
			{
				$align = get_module_pref('alignment','alignment');
				if( $prereq['alignment'] == 1 && $align > $prereq['alignlo'] )
				{
					$args['blocked'] = 1;
					debug("Blocked {$args['racename']} - Alignment too high.");
				}
				elseif( $prereq['alignment'] == 2 && ($align < $prereq['alignlo'] || $align > $prereq['alignhi']) )
				{
					$args['blocked'] = 1;
					debug("Blocked {$args['racename']} - Alignment too low or too high.");
				}
				elseif( $prereq['alignment'] == 3 && $align < $prereq['alignhi'] )
				{
					$args['blocked'] = 1;
					debug("Blocked {$args['racename']} - Alignment too low.");
				}
			}
			// Charm
			if( $prereq['charmreq'] > 0 && $session['user']['charm'] < $prereq['charmreq'] )
			{
				$args['blocked'] = 1;
				debug("Blocked {$args['racename']} - Not enough charm.");
			}
			elseif( $prereq['charmreq'] < 0 && $session['user']['charm'] > $prereq['charmreq'] )
			{
				$args['blocked'] = 1;
				debug("Blocked {$args['racename']} - Too much charm.");
			}
			// Sex
			if( $prereq['sexreq'] > 0 && ($prereq['sexreq'] == 1 && $session['user']['sex'] != 0 || $prereq['sexreq'] == 2 && $session['user']['sex'] != 1) )
			{
				$args['blocked'] = 1;
				debug("Blocked {$args['racename']} - wrong sex.");
			}
			// Donation
			if( !in_array($args['raceid'], $bought_races) )
			{
				if( $donationavail < $prereq['donationreq'] && $prereq['donationreq'] > 0 )
				{
					$args['blocked'] = 1;
					debug("Blocked {$args['racename']} - Not enough available lodge points.");
				}
			}
		break;

		case 'racerequirements':
			$sql = "SELECT setting, value
					FROM " . db_prefix('module_objprefs') . "
					WHERE modulename = 'race_prerequisites'
						AND objtype = 'races'
						AND objid = '{$args['raceid']}'";
			$result = db_query_cached($sql, 'race_prerequisites-'.$args['raceid'], 86400);
			$prereq = array('dks'=>0,'dkslo'=>'','dkshi'=>'','alignment'=>0,'alignlo'=>'','alignhi'=>'','charmreq'=>'','sexreq'=>0,'donationreq'=>0,'donationcost'=>0);
			while( $row = db_fetch_assoc($result) )
			{
				$prereq[$row['setting']] = $row['value'];
			}
			if( $prereq['dks'] > 0 )
			{
				if( $prereq['dks'] == 1 ) output('`3DKs <%s`0`n', $prereq['dkslo']);
				elseif( $prereq['dks'] == 2 ) output('`3DKs >%s <%s`0`n', $prereq['dkslo'], $prereq['dkshi']);
				elseif( $prereq['dks'] == 3 ) output('`3DKs >%s`0`n', $prereq['dkshi']);
			}
			if( $prereq['charmreq'] > 0 ) output('`2Charm >%s`0`n', $prereq['charmreq']);
			if( $prereq['charmreq'] < 0 ) output('`2Charm <%s`0`n', $prereq['charmreq']);
			if( is_module_active('alignment') )
			{
				if( $prereq['alignment'] > 0 )
				{
					if( $prereq['alignment'] == 1 ) output('`&Alignment <%s`0`n', $prereq['alignlo']);
					elseif( $prereq['alignment'] == 2 ) output('`&Alignment >%s <%s`0`n', $prereq['alignlo'], $prereq['alignhi']);
					elseif( $prereq['alignment'] == 3 ) output('`&Alignment >%s`0`n', $prereq['alignhi']);
				}
			}
			if( $prereq['sexreq'] == 1 ) output('`6Males only`0`n');
			elseif( $prereq['sexreq'] == 2 ) output('`6Females only`0`n');
			if( $prereq['donationreq'] > 0 ) output('`5Lodge points available: %s`0`n', $prereq['donationreq']);
			if( $prereq['donationcost'] > 0 ) output('`4Lodge points cost: %s`0`n', $prereq['donationcost']);
		break;

		case 'lodge':
		case 'lodge_incentives':
		case 'pointsdesc':
			$races = db_prefix('races');
			$objprefs = db_prefix('module_objprefs');
			$sql = "SELECT r.raceid, r.racename, r.racecolour, ob1.value AS cost
					FROM $races r INNER JOIN $objprefs ob1
						ON r.raceid = ob1.objid
					WHERE ob1.modulename = 'race_prerequisites'
						AND ob1.objtype = 'races'
						AND ob1.setting = 'donationcost'
						AND ob1.value+0 > 0
						AND r.raceactive = 1";
			$result = db_query_cached($sql,'race_prerequisites-lodge',86400);
			if( db_num_rows($result) > 0 )
			{
				if( $hookname == 'lodge' ) 
				{
					$bought_races = @unserialize(stripslashes(get_module_pref('bought')));
					if( !is_array($bought_races) ) $bought_races = array();
					$points = translate_inline(array('point','points'));
					addnav('Use Points');
					addnav('Buy Race Blood');
					while( $row = db_fetch_assoc($result) )
					{
						if( !in_array($row['raceid'], $bought_races) )
						{
							addnav(array('%s%s`0 (%s %s)', $row['racecolour'], translate_inline($row['racename']), $row['cost'], ($row['cost']==1?$point[0]:$points[1])),'runmodule.php?module=race_prerequisites&raceid='.$row['raceid']);
						}
					}
				}
				elseif( $hookname == 'lodge_incentives' )
				{
					while( $row = db_fetch_assoc($result) )
					{
						$points = $args['points'];
						$str = translate("`&The %s%s `&Race.`0");
						$str = sprintf($str, $row['racecolour'], translate_inline($row['racename']));
						$points[$row['cost']][] = $str;
						$args['points'] = $points;
					}
				}
				elseif( $hookname == 'pointsdesc' )
				{
					while( $row = db_fetch_assoc($result) )
					{
						$args['count']++;
						$str = translate("The %s%s`0 race costs %s %s.");
						$points = translate_inline($row['cost']==1?'point':'points');
						$str = sprintf($str, $row['racecolour'], translate_inline($row['racename']), $row['cost'], $points);
						output($args['format'], $str, TRUE);
					}
				}
			}
		break;
	}

	return $args;
}

function race_prerequisites_run()
{
	global $session;

	page_header("Hunter's Lodge");

	$raceid = httpget('raceid');
	if( $raceid > 0 )
	{
		$sql = "SELECT racename, racecolour
				FROM " . db_prefix('races') . "
				WHERE raceid = '$raceid'
				LIMIT 1";
		$result = db_query($sql);
		$row = db_fetch_assoc($result);
		$row['racename'] = translate_inline($row['racename']);
	}
	$cost = get_module_objpref('races',$raceid,'donationcost');

	$op = httpget('op');
	switch( $op )
	{
		case 'yes':
			output("`3J. C. Petersen hands you a tiny vial, with a cold crimson liquid in it.`n`n");
			output("\"`\$That is pure %s%s Blood`\$.", $row['racecolour'], $row['racename']);
			output("Now, drink it all up!`3\"`n`n");
			output("You double over, spasming on the ground.");
			output("J. C. Petersen grins, \"`\$Your body shall finish its change upon newday... I suggest you rest.`3\"");
			$session['user']['race'] = $row['racename'];
			set_module_pref('race',$row['racename'],'race_creator');
			set_module_pref('raceid',$raceid,'race_creator');
			$bought_races = @unserialize(get_module_pref('bought'));
			if( !is_array($bought_races) ) $bought_races = array();
			$bought_races[] = $raceid;
			set_module_pref('bought',serialize($bought_races));
			$session['user']['donationspent'] += $cost;
			$dconfig = @unserialize($session['user']['donationconfig']);
			if( !is_array($dconfig) ) $dconfig = array();
			$dconfig = array_push($dconfig, "spent $cost points for access to the {$row['racename']} race.");
			$session['user']['donationconfig'] = serialize($dconfig);

			addnav('Return');
			addnav('L?Return to the Lodge','lodge.php');
		break;

		case 'no':
			output("`3J. C. Petersen looks at you and shakes his head. \"`\$I swear to you, this stuff is top notch.`3\" he says. \"`\$This isn't like the crud that %s `\$is selling.`3\"", getsetting('barkeep','`tCedrik'));
			addnav('Return');
			addnav('L?Return to the Lodge','lodge.php');
		break;

		default:
			$bought_races = @unserialize(get_module_pref('bought'));
			if( !is_array($bought_races) ) $bought_races = array();
			$pointsavailable = $session['user']['donation'] - $session['user']['donationspent'];
			if( $pointsavailable >= $cost && !in_array($raceid, $bought_races) && $raceid > 0 )
			{
				output("`3J. C. Petersen looks upon you with a caustic grin.`n`n\"`\$So, you wish to purchase the %s%s Blood`\$?`3\" he says with a smile.", $row['racecolour'], $row['racename']);
				addnav('Choices');
				addnav('Yes','runmodule.php?module=race_prerequisites&op=yes&raceid='.$raceid);
				addnav('No','runmodule.php?module=race_prerequisites&op=no');
			}
			elseif( in_array($raceid, $bought_races) )
			{
				output("`3J. C. Petersen stares at you for a moment then looks away as you realize that you've already bought %s%s Blood`3.", $row['racecolour'], $row['racename']);
				addnav('Return');
				addnav('L?Return to the Lodge','lodge.php');
			}
			else
			{
				output("`3J. C. Petersen stares at you for a moment then looks away as you realize that you don't have enough points to purchase this item.");
				addnav('Return');
				addnav('L?Return to the Lodge','lodge.php');
			}
		break;
	}

	page_footer();
}
?>