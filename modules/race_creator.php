<?php
/**
	29/09/2010 - v0.0.1
	14/04/2013 - v1.0.0

	Disclaimer:
	The races that come supplied are Human, Elf, Dwarf and Troll. All text and code supplied with
	these races come from the 4 core race modules supplied with LotGD and belong to Eric Stevens.
	I make no claim to the text or code which I simply copied from the module files.
*/
function race_creator_getmoduleinfo()
{
	$info = array(
		"name"=>"Race Creator",
		"description"=>"Create all the races you want.",
		"version"=>"1.0.0",
		"author"=>"`@MarcTheSlayer",
		"category"=>"Races",
		"download"=>"",
		"settings"=>array(
			"Settings,title",
				"userview"=>"Change the user editor race box to a dropdown menu of active races?,bool",
				"`^When editing a user you can have a drop down menu of all the active races instead of a text box.,note",
		),
		"prefs"=>array(
			"Race Prefs,title",
				"race"=>"Current race name:,text",
				"raceid"=>"Current race ID:,int",
			"Your Race,title",
				"user_showrace"=>"Show race on stats?,bool|1",
		)
	);
	return $info;
}

function race_creator_install()
{
	require_once('lib/tabledescriptor.php');
	$fields = array(
		'raceid'		=>array('name'=>'raceid',					'type'=>'tinyint(3)		unsigned',	'null'=>'0',	'extra'=>'auto_increment'),
		'racename'		=>array('name'=>'racename',					'type'=>'varchar(30)',				'null'=>'0'),
		'raceauthor'	=>array('name'=>'raceauthor',				'type'=>'varchar(30)',				'null'=>'1'),
		'raceactive'	=>array('name'=>'raceactive',				'type'=>'tinyint(1)		unsigned',	'null'=>'0',	'default'=>'0'),
		'racevillage'	=>array('name'=>'racevillage',				'type'=>'varchar(30)',				'null'=>'0'),
		'racecolour'	=>array('name'=>'racecolour',				'type'=>'varchar(2)',				'null'=>'0',	'default'=>'`&'),
		'racechoose'	=>array('name'=>'racechoose',				'type'=>'text',						'null'=>'1'),
		'raceset'		=>array('name'=>'raceset',					'type'=>'text',						'null'=>'1'),
		'racenewday'	=>array('name'=>'racenewday',				'type'=>'text',						'null'=>'1'),
		'raceturns'		=>array('name'=>'raceturns',				'type'=>'smallint(3)	signed',	'null'=>'0',	'default'=>'0'),
		'racetravel'	=>array('name'=>'racetravel',				'type'=>'smallint(3)	signed',	'null'=>'0',	'default'=>'0'),
		'racepvp'		=>array('name'=>'racepvp',					'type'=>'smallint(3)	signed',	'null'=>'0',	'default'=>'0'),
		'racegrave'		=>array('name'=>'racegrave',				'type'=>'smallint(3)	signed',	'null'=>'0',	'default'=>'0'),
		'newdaybuff'	=>array('name'=>'newdaybuff',				'type'=>'text',						'null'=>'1'),
		'pvpadjust'			=>array('name'=>'pvpadjust',			'type'=>'text',						'null'=>'1'),
		'`alter-gemchance`'	=>array('name'=>'`alter-gemchance`',		'type'=>'tinyint(3)		unsigned',	'null'=>'0',	'default'=>'0'),
		'creatureencounter'	=>array('name'=>'creatureencounter',	'type'=>'text',						'null'=>'1'),
		'`battle-victory`'	=>array('name'=>'`battle-victory`',		'type'=>'text',						'null'=>'1'),
		'`battle-defeat`'		=>array('name'=>'`battle-defeat`',		'type'=>'text',						'null'=>'1'),
		'module'		=>array('name'=>'module',					'type'=>'varchar(30)',				'null'=>'1'),
		'key-PRIMARY'	=>array('name'=>'PRIMARY',	'type'=>'primary key',	'unique'=>'1',	'columns'=>'raceid'),
		'key-raceid'	=>array('name'=>'raceid',	'type'=>'key',							'columns'=>'raceid')
	);
	synctable(db_prefix('races'), $fields);

	if( is_module_active('race_creator') )
	{
		output("`c`b`QUpdating 'race_creator' Module.`0`b`c`n");
	}
	else
	{
		output("`c`b`QInstalling 'race_creator' Module.`0`b`c`n");
		output("`3Installing 'races' table...`0`n");
	}

	module_addhook_priority('header-superuser',49);
	module_addhook('changesetting');
	module_addhook('raceinvalidatecache');
	module_addhook('modifyuserview');
	module_addhook('charstats');
	module_addhook('racenames');
	module_addhook('raceids');
	module_addhook_priority('chooserace',1);
	module_addhook('setrace');
	module_addhook_priority('newday',1);
	module_addhook('count-travels');
	module_addhook('alter-gemchance');
	module_addhook('pvpadjust');
	module_addhook('creatureencounter');
	module_addhook('battle-victory');
	module_addhook('battle-defeat');
	module_addhook('showformextensions');
	return TRUE;
}

function race_creator_uninstall()
{
	global $session;
	output("`n`c`b`Q'race_creator' Module Uninstalled`0`b`c");
	db_query("DROP TABLE IF EXISTS " . db_prefix('races'));
	db_query("UPDATE  " . db_prefix('accounts') . " SET race = '" . RACE_UNKNOWN . "'");
	$session['user']['race'] = RACE_UNKNOWN;
	return TRUE;
}

$racecreator_racedata = array();

function race_creator_getrace($race = FALSE)
{
	global $racecreator_racedata;

	if( isset($racecreator_racedata['racename']) && ($racecreator_racedata['racename'] == $race || $racecreator_racedata['raceid'] == $race) )
	{
		return $racecreator_racedata;
	}

	$where = FALSE;
	if( is_numeric($race) && $race > 0 ) $where = "raceid = '$race'";
	elseif( is_string($race) ) $where = "racename = '$race' LIMIT 1";
	else $racecreator_racedata['racename'] = RACE_UNKNOWN;
	if( $where )
	{
		$sql = "SELECT *
				FROM " . db_prefix('races') . "
				WHERE $where";
		$result = db_query_cached($sql,"race_creator-$race",86400);
		$racecreator_racedata = db_fetch_assoc($result);
		if( $racecreator_racedata['newdaybuff'] != '' ) $racecreator_racedata['newdaybuff'] = @unserialize($racecreator_racedata['newdaybuff']);
	}
	return $racecreator_racedata;
}

function race_creator_dohook($hookname,$args)
{
	global $session;

	switch( $hookname )
	{
		case 'header-superuser':
			if( $session['user']['superuser'] & SU_EDIT_USERS )
			{
				addnav('Actions');
				addnav('Creators');
				addnav('Race Creator','runmodule.php?module=race_creator');
				addnav('Editors');
			}
		break;

		case 'changesetting':
			if( $args['setting'] == 'villagename' )
			{
				db_query("UPDATE " . db_prefix('races') . " SET racevillage = '{$args['new']}' WHERE racevillage = '{$args['old']}'");
				if( $session['user']['location'] == $args['old'] ) $session['user']['location'] = $args['new'];
			}
		break;

		case 'raceinvalidatecache':
			invalidatedatacache('race_creator-'.$args['raceid']);
			invalidatedatacache('race_creator-'.$args['racename']);
			invalidatedatacache('race_creator-chooserace');
		break;

		case 'modifyuserview':
			if( get_module_setting('userview') )
			{
				$racename = httppost('race');
				// When editing a user, change the race text box into a drop down menu of active races.
				$sql = "SELECT raceid, racename
						FROM " . db_prefix('races') . "
						WHERE raceactive = 1
						ORDER BY racename";
				$result = db_query($sql);
				$enum = '';
				$races = array();
				while( $row = db_fetch_assoc($result) )
				{
					if( $racename !== FALSE ) $races[$row['racename']] = $row['raceid'];
					$enum .= ','.$row['racename'].','.$row['racename'];
				}
				$args['userinfo']['race'] = 'Race:,enum'.$enum;
				// If edited player's race has been changed.
				if( $racename !== FALSE && $racename != $args['user']['race'] )
				{
					set_module_pref('race',$racename,'race_creator',$args['user']['acctid']);
					set_module_pref('raceid',$races[$racename],'race_creator',$args['user']['acctid']);
					$args['user']['race'] = $racename;
				}
			}
		break;

		case 'charstats':
			if( get_module_pref('user_showrace') == 1 )
			{
				addcharstat('Vital Info');
				addcharstat('Race', translate_inline($session['user']['race']));
			}
		break;

		case 'racenames':
			$sql = "SELECT racename
					FROM " . db_prefix('races') . "
					WHERE raceactive = 1";
			$result = db_query($sql);
			while( $row = db_fetch_assoc($result) ) $args[$row['racename']] = translate_inline($row['racename']);
		break;

		case 'raceids':
			$sql = "SELECT raceid, racename
					FROM " . db_prefix('races') . "
					WHERE raceactive = 1";
			$result = db_query($sql);
			while( $row = db_fetch_assoc($result) ) $args[$row['raceid']] = translate_inline($row['racename']);
		break;

		case 'chooserace':
			$resline = ( httpget('resurrection') == 'true' ) ? '&resurrection=true' : '';
			$sql = "SELECT raceid, racename, racecolour, racechoose
					FROM " . db_prefix('races') . "
					WHERE raceactive = 1";
			$result = db_query_cached($sql,'race_creator-chooserace',86400);
			while( $row = db_fetch_assoc($result) )
			{
				$prereq = modulehook('raceprerequisite',array('raceid'=>$row['raceid'],'racename'=>$row['racename'],'blocked'=>0));
				if( $prereq['blocked'] == 0 )
				{
					$row['racename'] = translate_inline($row['racename']);
					output_notl('`n%s`0`n', translate_inline(stripslashes($row['racechoose'])));
					addnav(array('%s%s`0', $row['racecolour'], $row['racename']),'newday.php?setrace='.$row['racename'].'&raceid='.$row['raceid'].$resline);
				}
			}
		break;

		case 'setrace':
			$raceid = httpget('raceid');
			if( $raceid > 0 )
			{	// Only do this if it's a race_creator race.
				$racedata = race_creator_getrace($raceid);
				$session['user']['location'] = $racedata['racevillage'];
				set_module_pref('race',$session['user']['race']);
				set_module_pref('raceid',$raceid);
				output_notl('`n%s%s`0`n', $racedata['racecolour'], translate_inline(stripslashes($racedata['raceset'])));
			}
			else
			{
				clear_module_pref('race');
				clear_module_pref('raceid');
			}
		break;

		case 'newday':
			$racedata = race_creator_getrace(get_module_pref('raceid'));
			if( $racedata['raceturns'] <> 0 )
			{
				$args['turnstoday'] .= ", Race ({$session['user']['race']}): {$racedata['raceturns']}";
				$session['user']['turns'] += $racedata['raceturns'];
			}
			if( $args['resurrection'] != 'true' )
			{
				if( $racedata['racepvp'] <> 0 ) $session['user']['playerfights'] += $racedata['racepvp'];
				if( $racedata['racegrave'] <> 0 ) $session['user']['gravefights'] += $racedata['racegrave'];
			}

			if( $racedata['racenewday'] != '' ) output_notl('`n%s%s`0`n', $racedata['racecolour'], translate_inline(stripslashes($racedata['racenewday'])));
			if( $racedata['newdaybuff'] != '' )
			{
				apply_buff('racialbenefit',$racedata['newdaybuff']);
			}
		break;

		case 'count-travels':
			$racedata = race_creator_getrace(get_module_pref('raceid'));
			if( $racedata['racetravel'] <> 0 ) $args['available'] += $racedata['racetravel'];
		break;

		case 'alter-gemchance':
			$racedata = race_creator_getrace(get_module_pref('raceid'));
			if( $racedata['alter-gemchance'] > 0 ) $args['chance'] = round($racedata['alter-gemchance']);
		break;

		case 'pvpadjust':
			$racedata = race_creator_getrace(get_module_pref('raceid','race_creator',$args['acctid']));
			if( $racedata['pvpadjust'] != '' ) eval(stripslashes($racedata['pvpadjust']));
		break;

		case 'creatureencounter':
		case 'battle-victory':
		case 'battle-defeat':
			$racedata = race_creator_getrace(get_module_pref('raceid'));
			if( $racedata[$hookname] != '' ) eval(stripslashes($racedata[$hookname]));
		break;

		case 'showformextensions':
			$args['racetextarea'] = 'race_creator_showform'; // <-- Name of the function.
		break;
	}

	return $args;
}

function race_creator_run()
{
	global $session;

	page_header('Race Creator');

	$op = httpget('op');
	$sop = httpget('sop');
	$raceid = httpget('raceid');

	$from = 'runmodule.php?module=race_creator';

	include("modules/race_creator/run/case_$op.php");

	addnav('Developer');
	addnav('Refresh',$from.'&op='.$op.'&raceid='.$raceid);
	addnav('View Selection Page',$from.'&sop=select');
	addnav('Newday','newday.php');

	addnav('Navigation');
	require_once('lib/superusernav.php');
	superusernav();

	page_footer();
}

function race_creator_showform($name, $val, $info)
{
	// The LoGD textarea code replaces `n with \n which is no good.
	$cols = 0;
	if( isset($info[2]) ) $cols = $info[2];
	if( !$cols ) $cols = 70;
	rawoutput("<script type=\"text/javascript\">function increase(target, value){  if (target.rows + value > 3 && target.rows + value < 50) target.rows = target.rows + value;}</script>");
	rawoutput("<textarea id='textarea$name' class='input' name='$name' cols='$cols' rows='5'>".htmlentities($val, ENT_COMPAT, getsetting("charset", "ISO-8859-1"))."</textarea>");
	rawoutput("<input type='button' onClick=\"increase(textarea$name,1);\" value='+' accesskey='+'><input type='button' onClick=\"increase(textarea$name,-1);\" value='-' accesskey='-'>");
}
?>