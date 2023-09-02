<?php
	addnav('Editor');
	addnav('Add a Race',$from.'&op=edit');

	//
	// Secondary ops.
	//
	switch( $sop )
	{
		case 'del':
			// Get name of race being deleted.
			$sql = "SELECT racename, racecolour
					FROM " . db_prefix('races') . "
					WHERE raceid = '$raceid'";
			$result = db_query($sql);
			$row = db_fetch_assoc($result);
			$racename = $row['racename'];
			$racecolour = $row['racecolour'];

			// Get players who are affected by the deletion.
			require_once('lib/systemmail.php');
			$subject = translate_mail(array("`#Race %s is no more!`0", $racename));
			$message = translate_mail(array('`3Dear Player,`n`nThe race known as `#%s `3is sadly no more. Please select one of the other races at the next opportunity.`n`n-The Staff', $racename));
			$sql = "SELECT acctid
					FROM " . db_prefix('accounts') . "
					WHERE race = '$racename'";
			$result = db_query($sql);
			while( $row = db_fetch_assoc($result) )
			{
				set_module_pref('race',FALSE,'race_creator',$row['acctid']);
				set_module_pref('raceid',FALSE,'race_creator',$row['acctid']);
				systemmail($row['acctid'], $subject, $message);
			}
			db_query("UPDATE " . db_prefix('accounts') . " SET race = '" . RACE_UNKNOWN . "' WHERE race = '$racename'");
			db_query("DELETE FROM " . db_prefix('races') . " WHERE raceid = '$raceid'");
			if( db_affected_rows() > 0 )
			{
				output('`n`2The race %s%s `2has been successfully deleted.`0`n`n', $racecolour, $racename);
				// Hook to invalidate any cache files.
				modulehook('raceinvalidatecache',array('raceid'=>$raceid,'racename'=>$racename));
				// Hook to allow modules to delete any prefs a player might have.
				modulehook('racedeleted',array('raceid'=>$raceid,'racename'=>$racename));
				// Delete object prefs for this race.
				module_delete_objprefs('races',$raceid);
			}
			else
			{
				db_query("UPDATE " . db_prefix('races') . " SET raceactive = 0 WHERE raceid = '$raceid'");
				output('`n`$The race %s%s `$could not be deleted because: `&%s`$, deactivated instead.`0`n`n', $racecolour, $racename, db_error(LINK));
			}
		break;

		case 'deactivate':
			db_query("UPDATE " . db_prefix('races') . " SET raceactive = 0 WHERE raceid = '$raceid'");
			$sql = "SELECT racename, racecolour
					FROM " . db_prefix('races') . "
					WHERE raceid = '$raceid'";
			$result = db_query($sql);
			$row = db_fetch_assoc($result);
			modulehook('raceinvalidatecache',array('raceid'=>$raceid,'racename'=>$racename));
			output('`n`2The race %s%s `2has been `@Deactivated`2.`0`n`n', $row['racecolour'], $row['racename']);
		break;

		case 'activate':
			db_query("UPDATE " . db_prefix('races') . " SET raceactive = 1 WHERE raceid = '$raceid'");
			$sql = "SELECT racename, racecolour
					FROM " . db_prefix('races') . "
					WHERE raceid = '$raceid'";
			$result = db_query($sql);
			$row = db_fetch_assoc($result);
			modulehook('raceinvalidatecache',array('raceid'=>$raceid,'racename'=>$racename));
			output('`n`2The race %s%s `2has been `@Activated`2.`0`n`n', $row['racecolour'], $row['racename']);
		break;

		case 'select':
			set_module_pref('race','');
			set_module_pref('raceid',0);
			$session['user']['race'] = '';
			redirect('newday.php');
		break;

		case 'test':
			$racedata = race_creator_getrace($session['user']['race']);
			if( has_buff($racedata['newdaybuff']['name']) ) strip_buff($racedata['newdaybuff']['name']);
			$racedata = race_creator_getrace($raceid);
			$session['user']['race'] = $racedata['racename'];
			$session['user']['location'] = $racedata['racevillage'];
			set_module_pref('race',$session['user']['race']);
			set_module_pref('raceid',$raceid);
			if( !has_buff($racedata['newdaybuff']['name']) )
			{
				$buff['schema'] = 'module-race_creator';
				apply_buff('racialbenefit',$racedata['newdaybuff']);
			}
			output('`n`2Your race is now %s%s `2and your races\' home city is %s%s`2.`0`n`n', $racedata['racecolour'], $session['user']['race'], $racedata['racecolour'], $session['user']['location']);
		break;
	}


	//
	// Count how many players have which race.
	//
	
	$sql = "SELECT value AS raceid
			FROM " . db_prefix('module_userprefs') . "
			WHERE modulename = 'race_creator'
				AND setting = 'raceid'";
	$result = db_query($sql);
	$races = array();
	while( $row = db_fetch_assoc($result) )
	{
		if( isset($races[$row['raceid']]) ) $races[$row['raceid']]++;
		else $races[$row['raceid']] = 1;
	}

	$opshead = translate_inline('Ops');
	$name = translate_inline('Name');
	$homecity = translate_inline('Home City');
	$requirements = translate_inline('Requirements');
	$author = translate_inline('Author');
	$owners = translate_inline('Owners');

	$activity = translate_inline('Activity');
	$edit = translate_inline('Edit');
	$del = translate_inline('Del');
	$deac = translate_inline('Deactivate');
	$act = translate_inline('Activate');
	$test = translate_inline('Test');
	$conf = translate_inline('There are %s user(s) who are this race, are you sure you wish to delete it?');
	$conf2 = translate_inline('This race was installed by another module, are you sure you wish to delete it?');

	//
	// Table header links for ordering.
	//
	$order = httpget('order');
	$order2 = ( $order == 1 ) ? 'DESC' : 'ASC';
	$sortby = httpget('sortby');
	$orderby = 'racevillage '.$order2;
	if( !empty($sortby) )
	{
		if( $sortby == 'name' ) $orderby = 'racename '.$order2;
	}

	addnav('',$from.'&sortby=name&order='.($sortby=='name'?!$order:1));
	addnav('',$from.'&sortby=village&order='.($sortby=='village'?!$order:1));

	//
	// Get race data and output to page.
	//
	$sql = "SELECT *
			FROM " . db_prefix('races') . "
			ORDER BY $orderby";
	$result = db_query($sql);

	if( db_num_rows($result) > 0 )
	{
		rawoutput('<table border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" align="center">');
		rawoutput("<tr class=\"trhead\"><td>$opshead</td><td align=\"center\"><a href=\"$from&sortby=name&order=".($sortby=='name'?!$order:1)."\">$name</a></td><td align=\"center\"><a href=\"$from&sortby=village&order=".($sortby=='village'?!$order:1)."\">$homecity</a></td><td align=\"center\">$requirements</td><td align=\"center\">$author</td><td>$owners</td></tr>");

		$i = 0;
		while( $row = db_fetch_assoc($result) )
		{
			rawoutput('<tr class="'.($i%2?'trlight':'trdark').'">');
			rawoutput('<td align="center" nowrap="nowrap">[ <a href="'.$from.'&op=edit&raceid='.$row['raceid'].'">'.$edit.'</a> |');
			addnav('',$from.'&op=edit&raceid='.$row['raceid']);

			if( $row['raceactive'] == 1 )
			{
				rawoutput('<a href="'.$from.'&sop=deactivate&raceid='.$row['raceid'].'">'.$deac.'</a>');
				addnav('',$from.'&sop=deactivate&raceid='.$row['raceid']);
			}
			else
			{
				$mconf = ( $row['module'] ) ? $conf2 : sprintf($conf, (isset($races[$row['raceid']])?$races[$row['raceid']]:0));
				rawoutput('<a href="'.$from.'&sop=del&raceid='.$row['raceid'].'" onClick="return confirm(\''.$mconf.'\');">'.$del.'</a> |');
				addnav('',$from.'&sop=del&raceid='.$row['raceid']);
				rawoutput('<a href="'.$from.'&sop=activate&raceid='.$row['raceid'].'">'.$act.'</a>');
				addnav('',$from.'&sop=activate&raceid='.$row['raceid']);
			}

			rawoutput(' | <a href="'.$from.'&sop=test&raceid='.$row['raceid'].'">'.$test.'</a>');
			addnav('',$from.'&sop=test&raceid='.$row['raceid']);
			rawoutput(' ]</td><td align="center">');
			output_notl('`&%s%s`0`0', $row['racecolour'], $row['racename']);
			rawoutput('</td><td align="center">');
			output_notl('%s', $row['racevillage']);
			rawoutput('</td><td>');

			//
			// Hook to add columns to table.
			//
			// Didn't want to do this, but it was probably the best way in the long run.
			//
			modulehook('racerequirements', array('raceid'=>$row['raceid']));

			rawoutput('</td><td align="center">');
			output_notl('%s', $row['raceauthor']);
			rawoutput('</td><td align="center">');
			if( isset($races[$row['raceid']]) && $races[$row['raceid']] > 0 )
			{
				rawoutput('<a href="'.$from.'&op=owners&raceid='.$row['raceid'].'">');
				addnav('', $from.'&op=owners&raceid='.$row['raceid']);
		 		output_notl('`#%s`0', $races[$row['raceid']]);
				rawoutput('</a>');
			}
			else
			{
				output_notl('`30`0');
			}
			rawoutput('</td></tr>');
			$i++;
		}
		rawoutput('</table><br /><br />');

		output('`2If you wish to delete a race, you have to deactivate it first. If there is anyone with this race when it\'s deleted then they will be turned into the default "`@%s`2" race which is hard coded into the game.`0`n`n', RACE_UNKNOWN);
	}
	else
	{
		output('`n`3There are no races installed, how about adding a few?`0`n`n');
	}

	addnav('Install');
	addnav('Eric Stevens\' Races',$from.'&op=installraces');
?>