<?php
/**
	Modified by MarcTheSlayer
	22/02/2012 - v1.1.0
	+ This module has been modified to work with 'city_creator'.
*/	  
function cityprefs_getmoduleinfo()
{
	$info = array(
		"name"=>"City Preferences Addon",
		"description"=>"Gives the ability to use prefs based on cities",
		"version"=>"1.1.0",
		"author"=>"Sixf00t4`2, modified by `@MarcTheSlayer",
		"category"=>"Cities",
		"download"=>"",
		"requires"=>array(
			"cities"=>"1.2|Eric Stevens`2, modified by `@MarcTheSlayer",
			"city_creator"=>"1.0.1|`@MarcTheSlayer",
		),
		"settings"=>array(
			"README,title",
				"`^Just a friendly reminder not to uninstall this module unless you're 100% sure that no other modules rely on its functions.`n`n
				This version is modified to work with 'city_creator' without causing conficts. You can still use it to edit the prefs of each module one at a time&#44; but the 'city_creator' allows you to edit all modules at the same time.`n`n,note",
			"Settings,title",
				"hidenav"=>"Hide 'City Prefs' nav link in Grotto?,bool"
		)
	);
	return $info;
}

function cityprefs_install()
{
	module_addhook_priority('header-superuser',55);
	return TRUE;
}

function cityprefs_uninstall()
{
	output("`4Un-Installing cityprefs Module.`n`n");
	db_query("DROP TABLE " . db_prefix('cityprefs'));
	return TRUE;
}

function cityprefs_dohook($hookname,$args)
{
	if( get_module_setting('hidenav') == 1 ) return $args;

	global $session;

	if( $session['user']['superuser'] & SU_EDIT_USERS )
	{
		addnav('Creators');
		addnav('City Prefs','runmodule.php?module=cityprefs');
	}

	return $args;
}

function cityprefs_run()
{
	global $session;

	$op = httpget('op');
	$cityid = httpget('cityid');

	if( $cityid > 0 )
	{
		require_once('modules/cityprefs/lib.php');
		$cityname = get_cityprefs_cityname('cityid',$cityid);
		page_header("%s Properties",$cityname);
		$modu = get_cityprefs_module("cityid",$cityid);
		if( $modu != 'none' )
		{
			addnav('Operations');
			addnav('Module settings','configuration.php?op=modulesettings&module='.$modu);
		}
		addnav('Navigation');
		addnav(array('Journey to %s',$cityname),"runmodule.php?module=cities&op=travel&city=".urlencode($cityname)."&su=1");
	}
	else
	{
		page_header('City Prefs Editor');
	}


	if( $op != '' ) addnav('Back to city list','runmodule.php?module=cityprefs');

	switch( $op )
	{
		case 'editmodule': //code from clan editor by CortalUX
		case 'editmodulesave':
			addnav('Operations');
			$mdule = httpget('mdule');
			if( $mdule == '' )
			{
				output("`n`2Select a module to edit its prefs for this city.`n`n");
			}
			else
			{
				require_once('lib/showform.php');
				if( $op == 'editmodulesave' )
				{
					// Save module prefs
					$post = httpallpost();
					reset($post);
					while(list($key, $val) = each($post))
					{
						set_module_objpref('city', $cityid, $key, stripslashes($val), $mdule);
						debug('Module: '.$mdule.', Objtype: city, ObjID: '.$cityid.', Name: '.$key.', Value: '.$val);
					}
					output("`^Saved!`0`n");
				}

				rawoutput("<form action='runmodule.php?module=cityprefs&op=editmodulesave&cityid=$cityid&mdule=$mdule' method='POST'>");
				module_objpref_edit('city', $mdule, $cityid);
				rawoutput('</form>');
				addnav('',"runmodule.php?module=cityprefs&op=editmodulesave&cityid=$cityid&mdule=$mdule");
				//code from clan editor by CortalUX
			}
 			addnav('Module Prefs');
			module_editor_navs('prefs-city',"runmodule.php?module=cityprefs&op=editmodule&cityid=$cityid&mdule=");
		break;
		  
		case '':
		default:
			output("`n`2All cities and city prefs can be edited directly and together using the City Creator Editor which you may find more convenient.`n`n");

			$ops = translate_inline('Ops');
			$id = translate_inline("ID");
			$name = translate_inline("City Name");
			$active = translate_inline("Active");
			$edit = translate_inline("Edit Prefs");
			$yesno = translate_inline(array('`@Yes','`$No'));

			$sql = "SELECT cityid, cityname, cityactive, cityauthor
					FROM " . db_prefix('cities') . "
					ORDER BY cityname";
			$result = db_query($sql);

			rawoutput("<table border='0' cellpadding='3' cellspacing='0' align='center'><tr class='trhead'><td style=\"width:50px\">$id</td><td style='width:150px' align=\"center\">$name</td><td align=\"center\">$active</td><td align=\"center\">$ops</td></tr>"); 

			$i = 0;
			while( $row = db_fetch_assoc($result) )
			{
				 rawoutput("<tr class='".($i%2?"trlight":"trdark")."'><td align=center>".$row['cityid']."</td><td align=center>");
				 output_notl('%s', $row['cityname']);
				 rawoutput('</td><td align="center">');
				 output_notl('%s', ($row['cityactive']==1?$yesno[0]:$yesno[1]));
				 rawoutput('</td><td align="center">');
				 rawoutput("[ <a href='runmodule.php?module=cityprefs&op=editmodule&cityid=".$row['cityid']."'>$edit</a> ]</td></tr>");
				 addnav('',"runmodule.php?module=cityprefs&op=editmodule&cityid=".$row['cityid']);  
			}
			rawoutput('</table>');
		break;
	}

	addnav('Leave');	
	addnav('Back to the Grotto','superuser.php');	

	page_footer();
}	 
?>