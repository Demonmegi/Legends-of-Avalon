<?php
/**
	24/10/2010 - v1.0.0
*/
function race_weaponarmour_getmoduleinfo()
{
	$info = array(
		"name"=>"Race Weapon/Armour Names",
		"description"=>"Customise the weapon/armour names for each race.",
		"version"=>"1.0.0",
		"author"=>"`@MarcTheSlayer",
		"category"=>"Races",
		"download"=>"",
		"requires"=>array(
			"race_creator"=>"1.0.0|`@MarcTheSlayer`2, available on Dragonprime.net"
		),
		"prefs-races"=>array(
			"Weapon Names,title",
				"`2Names will only be changed if player is in the race's home village.,note",
				"weapon1"=>"Damage 1:,string,60",
				"weapon2"=>"Damage 2:,string,60",
				"weapon3"=>"Damage 3:,string,60",
				"weapon4"=>"Damage 4:,string,60",
				"weapon5"=>"Damage 5:,string,60",
				"weapon6"=>"Damage 6:,string,60",
				"weapon7"=>"Damage 7:,string,60",
				"weapon8"=>"Damage 8:,string,60",
				"weapon9"=>"Damage 9:,string,60",
				"weapon10"=>"Damage 10:,string,60",
				"weapon11"=>"Damage 11:,string,60",
				"weapon12"=>"Damage 12:,string,60",
				"weapon13"=>"Damage 13:,string,60",
				"weapon14"=>"Damage 14:,string,60",
				"weapon15"=>"Damage 15:,string,60",
			"Armour Names,title",
				"`2Names will only be changed if player is in the race's home village.,note",
				"armor1"=>"Damage 1:,string,60",
				"armor2"=>"Damage 2:,string,60",
				"armor3"=>"Damage 3:,string,60",
				"armor4"=>"Damage 4:,string,60",
				"armor5"=>"Damage 5:,string,60",
				"armor6"=>"Damage 6:,string,60",
				"armor7"=>"Damage 7:,string,60",
				"armor8"=>"Damage 8:,string,60",
				"armor9"=>"Damage 9:,string,60",
				"armor10"=>"Damage 10:,string,60",
				"armor11"=>"Damage 11:,string,60",
				"armor12"=>"Damage 12:,string,60",
				"armor13"=>"Damage 13:,string,60",
				"armor14"=>"Damage 14:,string,60",
				"armor15"=>"Damage 15:,string,60",
			"Weapon Cost,title",
				"weaponcost"=>"Make weapons cheaper by:,range,0,50,1|0",
				"`^This is a percentage value. Setting it at 10 will take 10% off the cost.,note",
			"Armour Cost,title",
				"armourcost"=>"Make armour cheaper by:,range,0,50,1|0",
				"`^This is a percentage value. Setting it at 10 will take 10% off the cost.,note",
			"Village Shops,title",
				"weaponshop"=>"Weapon shop only available in homecity?,bool",
				"armorshop"=>"Armour shop only available in homecity?,bool",
				"`^Note: That's the home city of the player's race&#44; not the player.,note",
		)
	);
	return $info;
}

function race_weaponarmour_install()
{
	output("`c`b`Q%s 'race_weaponarmour' Module.`b`n`c", translate_inline(is_module_active('race_weaponarmour')?'Updating':'Installing'));
	module_addhook('raceinvalidatecache');
	module_addhook('village');
	module_addhook('modify-weapon');
	module_addhook('modify-armor');

	return TRUE;
}

function race_weaponarmour_uninstall()
{
	output("`n`c`b`Q'race_weaponarmour' Module Uninstalled`0`b`c");
	return TRUE;
}

// Each modify hook gets called 15 times each and to cut down on queries I've
// put the racevillage, name and deduction costs in this array that's called globally.
if( !isset($race_creator_array) ) $race_creator_array = array();

function race_weaponarmour_dohook($hookname,$args)
{
	global $race_creator_array;

	switch( $hookname )
	{
		case 'raceinvalidatecache':
			invalidatedatacache('race_weaponarmournames-'.$args['raceid']);
			return $args;
		break;

		case 'village':
			global $session;
			$raceid = get_module_pref('raceid','race_creator');
			$sql = "SELECT racevillage
					FROM " . db_prefix('races') . "
					WHERE raceid = '$raceid'";
			$result = db_query($sql);
			$row = db_fetch_assoc($result);
			if( $session['user']['location'] != $row['racevillage'] )
			{
				if( get_module_objpref('races',$raceid,'weaponshop') == 1 ) blocknav('weapons.php');
				if( get_module_objpref('races',$raceid,'armorshop') == 1 ) blocknav('armor.php');
			}
			else
			{	// In case it has been blocked elsewhere. I wont waste 2 queries here. :)
				unblocknav('weapons.php');
				unblocknav('armor.php');
			}
			return $args;
		break;

		case 'modify-weapon':	$name = 'weapon';	break;
		case 'modify-armor':	$name = 'armor';	break;
	}

	$raceid = get_module_pref('raceid','race_creator');

	if( !isset($race_creator_array['racevillage']) )
	{	// Get the village for the player's race.
		global $session;
		$sql = "SELECT racevillage
				FROM " . db_prefix('races') . "
				WHERE raceid = '$raceid'";
		$result = db_query($sql);
		$row = db_fetch_assoc($result);
		$race_creator_array['racevillage'] = ( $session['user']['location'] == $row['racevillage'] ) ? 1 : 0;
	}
	if( $race_creator_array['racevillage'] == 0 ) return $args; // Location doesn't match current location then stop here.


	if( !isset($race_creator_array[$name.'cost']) )
	{	// First time called. Set it.
		$sql = "SELECT setting, value FROM " . db_prefix('module_objprefs') . "
				WHERE modulename = 'race_weaponarmour'
					AND objtype = 'races'
					AND objid = '$raceid'
					AND setting LIKE '$name%'";
		$result = db_query_cached($sql, "race_weaponarmournames-$raceid", 86400);
		while( $row = db_fetch_assoc($result) )
		{
			$race_creator_array[$row['setting']] = $row['value'];
		}
	}
	if( $race_creator_array[$name.'cost'] > 0 )
	{
		$args['value'] = round($args['value']-(($args['value']*($race_creator_array[$name.'cost']/100))),0);
	}

	if( $race_creator_array[$name.$args['damage']] != '' ) $args[$name.'name'] = stripslashes($race_creator_array[$name.$args['damage']]);

	return $args;
}

function race_weaponarmour_run()
{
}
?>