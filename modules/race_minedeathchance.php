<?php
/**
	13/10/2010 - v1.0.0
	I decided to write this module even though my other one, 'metalmine_raceminedeath'
	does more or less the same thing. With that module you had to go into the settings
	page, but with this it will be a tab when you edit a race with the editor. :)
*/
function race_minedeathchance_getmoduleinfo()
{
	$info = array(
		"name"=>"Race Mine Death Chance",
		"description"=>"Race chances of dying in the metal mine.",
		"version"=>"1.0.0",
		"author"=>"`@MarcTheSlayer`0",
		"category"=>"Races",
		"download"=>"",
		"requires"=>array(
			"race_creator"=>"1.0.0|`@MarcTheSlayer`2, available on Dragonprime.net",
			"metalmine"=>"5.0|By DaveS, available on DragonPrime",
		),
		"prefs-races"=>array(
			"Mine Death Chance,title",
				"chance"=>"Chance to die in the mine:,range,0,100,1",
				"savetext"=>"Text to display when saved:,",
				"`^Default text will be used if no text is entered.`n`n`&\"`7Fortunately you're able to escape unscathed by the skin of your teeth.`&\",note"
		),
	);
	return $info;
}

function race_minedeathchance_install()
{
	output("`c`b`Q%s 'race_minedeathchance' Module.`b`n`c", translate_inline(is_module_active('race_minedeathchance')?'Updating':'Installing'));
	module_addhook('raceminedeath');
	return TRUE;
}

function race_minedeathchance_uninstall()
{
	output("`n`c`b`Q'race_minedeathchance' Module Uninstalled`0`b`c");
	return TRUE;
}

function race_minedeathchance_dohook($hookname, $args)
{
	global $session;

	$raceid = get_module_pref('raceid','race_creator',$session['user']['acctid']);
	$args['chance'] = get_module_objpref('races',$raceid,'chance');
	$savetext = get_module_objpref('races',$raceid,'savetext');
	$args['racesave'] = ( $savetext != '' ) ? $savetext : translate_inline("Fortunately you're able to escape unscathed by the skin of your teeth.`n");
	$args['schema'] = 'module-race_minedeathchance';

	return $args;
}

function race_minedeathchance_run()
{
}
?>