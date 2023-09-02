<?php
	$sop = httpget('sop');
	if( $sop == 'install' )
	{
		$races = httppost('races');
		$allraces = httppost('allraces');
		$fields = "`raceauthor`,`raceactive`,`racename`,`racevillage`,`racecolour`,`racechoose`,`raceset`,`racenewday`,`raceturns`,`racetravel`,`racepvp`,`racegrave`,`newdaybuff`,`pvpadjust`,`alter-gemchance`,`creatureencounter`,`battle-victory`,`battle-defeat`,`module`";
		if( $races['race0'] == 1 || $allraces == 1 )
		{
			db_query("INSERT INTO " . db_prefix('races') . " ($fields) VALUES ('Eric Stevens', 0, 'Human', 'Degolburg', '`Q', 'On the plains in the city of Degolburg, the city of `&men`0; always following your father and looking up to his every move, until he sought out the `@Green Dragon`0, never to be seen again.`n`n', '`&As a human, your size and strength permit you the ability to effortlessly wield weapons, tiring much less quickly than other races.`n`^You gain 2 extra forest fights each day!', '`&Because you are human, you gain `^2 extra`& forest fights for today!`0', 2, 0, 0, 0, '', '', 0, '', '', '', 'race_creator')");
			if( db_affected_rows() > 0 ) output('`&The `QHuman `&race has been `@successfully `&installed.`0`n');
			else output('`&The `QHuman `&race `$failed `&to install.`0`n');
		}
		if( $races['race1'] == 1 || $allraces == 1 )
		{
			db_query("INSERT INTO " . db_prefix('races') . " ($fields) VALUES ('Eric Stevens', 0, 'Elf', 'Degolburg', '`2', 'High among the trees of the Degolburg forest, in frail looking elaborate `^Elvish`0 structures that look as though they might collapse under the slightest strain, yet have existed for centuries.`n`n', '`^As an elf, you are keenly aware of your surroundings at all times; very little ever catches you by surprise.`nYou gain extra defense!', '', 0, 0, 0, 0, '".mysql_real_escape_string(serialize(array("name"=>"`@Elvish Awareness`0","rounds"=>"-1","allowinpvp"=>"1","allowintrain"=>"1","defmod"=>"(<defense>?(1+((1+floor(<level>/5))/<defense>)):0)","schema"=>"module-race_creator")))."', 'global \$args;\r\n\$args[\"creaturedefense\"]+=(1+floor(\$args[\"creaturelevel\"]/5));', 0, '', '', '', 'race_creator')");
			if( db_affected_rows() > 0 ) output('`&The `2Elf `&race has been `@successfully `&installed.`0`n');
			else output('`&The `2Elf `&race `$failed `&to install.`0`n');
		}
		if( $races['race2'] == 1 || $allraces == 1 )
		{
			db_query("INSERT INTO " . db_prefix('races') . " ($fields) VALUES ('Eric Stevens', 0, 'Dwarf', 'Degolburg', '`e', 'Deep in the subterranean strongholds of Qexelcrag, home to the noble and fierce `#Dwarven`0 people whose desire for privacy and treasure bears no resemblance to their tiny stature.`n`n', '`#As a dwarf, you are more easily able to identify the value of certain goods.`n`^You gain extra gold from forest fights!', '', 0, 0, 0, 0, '', '', 0, 'global \$args;\r\n\$args[\"creaturegold\"]=round(\$args[\"creaturegold\"]*1.2,0);', '', '', 'race_creator')");
			if( db_affected_rows() > 0 ) output('`&The `eDwarf `&race has been `@successfully `&installed.`0`n');
			else output('`&The `eDwarf `&race `$failed `&to install.`0`n');
		}
		if( $races['race3'] == 1 || $allraces == 1 )
		{
			db_query("INSERT INTO " . db_prefix('races') . " ($fields) VALUES ('Eric Stevens', 0, 'Troll', 'Degolburg', '`@', '`2In the swamps of Glukmoore as a `@Troll`2, fending for yourself from the very moment you crept out of your leathery egg, slaying your yet unhatched siblings, and feasting on their bones.`n`n', '`@As a troll, and having always fended for yourself, the ways of battle are not foreign to you.`n`^You gain extra attack!', '', 0, 0, 0, 0, '".mysql_real_escape_string(serialize(array("name"=>"`@Trollish Strength`0","rounds"=>"-1","allowinpvp"=>"1","allowintrain"=>"1","atkmod"=>"(<attack>?(1+((1+floor(<level>/5))/<attack>)):0)","schema"=>"module-race_creator")))."', 'global \$args;\r\n\$args[\"creatureattack\"]+=(1+floor(\$args[\"creaturelevel\"]/5));', 0, '', '', '', 'race_creator')");
			if( db_affected_rows() > 0 ) output('`&The `@Troll `&race has been `@successfully `&installed.`0`n');
			else output('`&The `@Troll `&race `$failed `&to install.`0`n');
		}
	}
	else
	{
		require_once('lib/showform.php');

		output("`3Which of the following races do you wish to install?.`n`n");

		$row = array(
			'allraces'=>'',
			'races'=>array()
		);
		$form = array(
			'Install Which Races?,title',
			'allraces'=>'Install ALL races?,bool',
			'races'=>'Races:,checklist,race0,'.appoencode('`Q').'Human,race1,'.appoencode('`2').'Elf,race2,'.appoencode('`e').'Dwarf,race3,'.appoencode('`@').'Troll'
		);

		rawoutput('<form action="runmodule.php?module=race_creator&op=installraces&sop=install" method="POST">');
		addnav('','runmodule.php?module=race_creator&op=installraces&sop=install');
		showform($form,$row);
		rawoutput('</form>');
	}

	addnav('Editor');
	addnav('Add a Race',$from.'&op=form');
	addnav('Main Page',$from);
?>