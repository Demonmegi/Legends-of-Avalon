<?php
	include_once('lib/gamelog.php');

	//
	// Save submitted mount data.
	//
	// These fields are the ones we want so there can be no mistake.
	$field_array = array('raceactive','raceid','raceauthor','racename','racevillage','racecolour','racechoose','raceset','racenewday','raceturns','racetravel','racepvp','racegrave','alter-gemchance','pvpadjust','creatureencounter','battle-victory','battle-defeat');
	$field_array2 = array('rcbuffname','rcbuffroundmsg','rcbuffwearoff','rcbuffeffectmsg','rcbuffeffectnodmgmsg','rcbuffeffectfailmsg','rcbuffrounds','rcbuffallowinpvp','rcbuffallowintrain','rcbuffatkmod','rcbuffdefmod','rcbuffinvulnerable','rcbuffregen','rcbuffminioncount','rcbuffminbadguydamage','rcbuffmaxbadguydamage','rcbuffmingoodguydamage','rcbuffmaxgoodguydamage','rcbufflifetap','rcbuffdamageshield','rcbuffbadguydmgmod','rcbuffbadguyatkmod','rcbuffbadguydefmod');
	$race = array();

	if( $_POST['racename'] == '' )
	{
		$_POST['racename'] = RACE_UNKNOWN; 
	}
	else
	{
		require_once('lib/sanitize.php');
		$_POST['racename'] = full_sanitize(str_replace(array('"',"'"), '', strip_tags($_POST['racename'])));
	}
	$_POST['raceauthor'] = ( $_POST['raceauthor'] != '' ) ? strip_tags($_POST['raceauthor']) : $session['user']['login'];
	if( $_POST['addnew'] == 1 ) $_POST['raceid'] = 0;

	$post = httpallpost();
	$raceid = httppost('raceid');

	$sql = "SELECT modulename
			FROM " . db_prefix('modules') . "
			WHERE infokeys
			LIKE '%|prefs-races|%'
			ORDER BY formalname";
	$result = db_query($sql);
	$module_array = array();
	while( $row = db_fetch_assoc($result) )
	{
		$module_array[] = $row['modulename'];
	}

	if( $raceid > 0 )
	{
		//
		// An existing race.
		//
		$oldvalues = @unserialize(stripslashes($post['oldvalues']));
		unset($post['oldvalues'], $post['raceid']);

		//
		// Deal with the race table data first.
		//
		$sql = '';
		reset($post);
		while( list($key,$val) = each($post) )
		{
			if( in_array($key, $field_array) )
			{
				if( $key == 'racename' && $val != $oldvalues[$key] ) db_query("UPDATE " . db_prefix('accounts') . " SET race = '$val' WHERE race = '{$oldvalues[$key]}'");
				$sql .= "`$key` = '".addslashes($val)."', ";
				unset($post[$key], $oldvalues[$key]);
			}
			elseif( in_array($key, $field_array2) )
			{	// Deal with the buff.
				if( !empty($val) )
				{
					$len = strlen($key);
					$keyname = substr($key,6,$len); // Remove the 'rcbuff' part from the names.
					$race[$keyname] = $val;
				}
				unset($post[$key], $oldvalues[$key]);
			}
		}
		if( count($race) > 0 )
		{
			$race['schema'] = 'race_creator';
			$sql .= "newdaybuff = '".mysql_real_escape_string(serialize($race))."'";
		}
		else
		{
			$sql .= "newdaybuff = ''";
		}
		db_query("UPDATE " . db_prefix('races') . " SET " . $sql . " WHERE raceid = '$raceid'");
		if( db_affected_rows() > 0 )
		{
			output('`@Race was successfully updated!`n');
		}
		else
		{
			output('`$Race was NOT updated as nothing was changed!`n');
		}
		//
		// Now deal with the different module data.
		//
		foreach( $module_array as $mkey => $modulename )
		{
			$len = strlen($modulename);
			foreach( $post as $key => $val )
			{
				if( substr($key,0,$len) == $modulename )
				{
					if( isset($oldvalues[$key]) && $oldvalues[$key] != $val )
					{	// Only take data that has been changed.
						$keyname = substr($key,$len+1,strlen($key));
						set_module_objpref('races', $raceid, $keyname, $val, $modulename);
						output('`7Module: `&%s `7Setting: `&%s `7ObjectID: `&%s `7Value changed from "`&%s`7" to "`&%s`7"`n', $modulename, $keyname, $raceid, $oldvalues[$key], $val);
						gamelog("`7Module: `&$modulename `7Setting: `&$keyname `7ObjectID: `&$raceid `7Value changed from '`&{$oldvalues[$key]}`7' to '`&$val`7'`0","races");
						unset($post[$key], $oldvalues[$key]);
					}
				}
			}
		}
	}
	else
	{
		//
		// A new race has been submitted. Don't need these bits.
		//
		unset($post['oldvalues'], $post['raceid'], $post['addnew']);

		//
		// Deal with the race table data first.
		//
		$cols = array();
		$vals = array();

		reset($post);
		while( list($key,$val) = each($post) )
		{
			if( in_array($key, $field_array) )
			{
				array_push($cols,"`$key`");
				array_push($vals,addslashes($val));
				unset($post[$key]);
			}
			elseif( in_array($key, $field_array2) )
			{	// Deal with the buff.
				if( !empty($val) )
				{
					$len = strlen($key);
					$keyname = substr($key,6,$len);
					$race[$keyname] = $val;
				}
				unset($post[$key]);
			}
		}
		if( count($race) > 0 )
		{
			$race['schema'] = 'race_creator';
			array_push($cols, 'newdaybuff');
			array_push($vals, mysql_real_escape_string(serialize($race)));
		}
		db_query("INSERT INTO " . db_prefix('races') . " (" . join(",",$cols) . ") VALUES (\"" . join("\",\"",$vals) . "\")");
		$raceid = db_insert_id();
		if( db_affected_rows() > 0 )
		{
			output('`@Race was successfully saved!`n');
		}
		else
		{
			output('`$Race was NOT saved!`n');
		}

		//
		// Now deal with the different module data.
		//
		foreach( $module_array as $mkey => $modulename )
		{
			$len = strlen($modulename);
			foreach( $post as $key => $val )
			{
				if( substr($key,0,$len) == $modulename )
				{
					if( $val != '' )
					{
						$len2 = strlen($key);
						$keyname = substr($key,$len+1,$len2);
						set_module_objpref('races', $raceid, $keyname, $val, $modulename);
						output('`7Module: `&%s `7Setting: `&%s `7ObjectID: `&%s `7Value: `&%s`7.`n', $modulename, $keyname, $raceid, $val);
						gamelog("`7Module: `&$modulename `7Setting: `&$keyname `7ObjectID: `&$raceid `7Value: `&$val`7.`0","races");
						unset($post[$key]);
					}
				}
			}
		}
	}

	modulehook('raceinvalidatecache',array('raceid'=>$raceid,'racename'=>$_POST['racename']));

	addnav('Editor');
	addnav('Re-Edit Race',$from.'&op=edit&raceid='.$raceid);
	addnav('Add a Race',$from.'&op=form');
	addnav('Main Page',$from);
?>