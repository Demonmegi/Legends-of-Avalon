<?php
/*Weather, version 2.5
- Added weather display in gardens
- Added climate for shades
*/
/**
	Modified by MarcTheSlayer 
	04/02/2013 - v3.0.0
	+ Added weather for each city with a percentage chance it of being displayed instead of the default weather.
	+ Changed name to 'City Weather'.
	06/02/2013 - v3.0.1
	+  Fixed a bug in the newday runonce code, missed out the get_module_objpref call. Thanks Shadeless. :)
*/
function city_weather_getmoduleinfo()
{
	$info = array(
		"name"=>"City Weather",
		"description"=>"Adds weather report to each city, garden and shades.",
		"author"=>"`4Talisman`2, modified by `@MarcTheSlayer",
		"version"=>"3.0.1",
		"category"=>"Cities",
		"download"=>"http://dragonprime.net/index.php?module=Downloads;sa=dlview;id=1451",
		"requires"=>array(
		   "cityprefs"=>"20070417|By Sixf00t4, available at Dragonprime"
		),
		"settings"=>array(
			"ReadMe,title",
				"To edit each city's weather you need to use the 'city prefs' module. Link can be found under Editors in the grotto.,note",
			"Default Weather Settings,title",
				"wxreport"=>"Default weather message:,text|`n`&Today's weather is expected to be `^%s `&in most parts of the Realm.`n",
				"weather"=>"Current Weather:,text|sunny",
				"weather1"=>"Weather Condition 1:,text|overcast and cool, with sunny periods",
				"weather2"=>"Weather Condition 2:,text|warm and sunny",
				"weather3"=>"Weather Condition 3:,text|rainy",
				"weather4"=>"Weather Condition 4:,text|foggy",
				"weather5"=>"Weather Condition 5:,text|cool with blue skies",
				"weather6"=>"Weather Condition 6:,text|hot and sunny",
				"weather7"=>"Weather Condition 7:,text|high winds with scattered showers",
				"weather8"=>"Weather Condition 8:,text|thundershowers",
			"Shades Weather Settings,title",
				"shadeswxreport"=>"Shades weather message:,text|`n`7The atmosphere in Shades is currently `^%s`&.`n`n",
				"shadeswx"=>"Current Weather:,text|`Qraining fire and brimstone",
				"shadeswx1"=>"Weather Condition 1:,text|`7a thick, bitter fog",
				"shadeswx2"=>"Weather Condition 2:,text|`Qraining fire and brimstone",
				"shadeswx3"=>"Weather Condition 3:,text|`7dark, dank and depressingly dismal",
				"shadeswx4"=>"Weather Condition 4:,text|`#suffering from acidic rainfall",
				"shadeswx5"=>"Weather Condition 5:,text|`#frozen over",
				"shadeswx6"=>"Weather Condition 6:,text|`qprone to cyclonic dust devils",
				"shadeswx7"=>"Weather Condition 7:,text|`6oppresively hot and uncomfortably muggy",
				"shadeswx8"=>"Weather Condition 8:,text|`^blowing winds of hellfire",
		),
		"prefs-city"=>array(
			"Custom Climate Settings,title",
				"chance"=>"Chance of unique weather (%):,range,0,100,1|50",
				"Set to 0 to turn off unique weather for this city.`nSet to 100 to always replace default weather.,note",
				"wxreport"=>"Weather message:,text|`n`&The weather elf is predicting `^%s`& today.`n",
				"wx"=>"Current Weather:,text|snow flurries",
				"wx1"=>"Custom Weather 1:,text|snow flurries",
				"wx2"=>"Custom Weather 2:,text|clear and cold",
				"wx3"=>"Custom Weather 3:,text|snow blizzards",
				"wx4"=>"Custom Weather 4:,text|frost",
				"wx5"=>"Custom Weather 5:,text|soft falling snow",
				"wx6"=>"Custom Weather 6:,text|some great skiing weather",
				"wx7"=>"Custom Weather 7:,text|a possibility of snow",
				"wx8"=>"Custom Weather 8:,text|fog and frost",
		)
	);
	return $info;
}

function city_weather_install()
{
	module_addhook('newday-runonce');
	module_addhook('newday');
 	module_addhook('village');
 	module_addhook('gardens');
 	module_addhook('shades');
	module_addhook('index');
	return TRUE;
}

function city_weather_uninstall()
{
	return TRUE;
}

function city_weather_dohook($hookname,$args)
{
	switch( $hookname )
	{
		case "newday-runonce":
			$sql = "SELECT objid
					FROM " . db_prefix('module_objprefs') . "
					WHERE modulename = 'city_weather'
						AND objtype = 'city'
						AND setting = 'chance'
						AND value+0 > 0";
			$res = db_query($sql);
			while( $row = db_fetch_assoc($res) )
			{
				$custwx = e_rand(1,8);
				$fetchwxa = "wx$custwx";
				set_module_objpref('city',$row['objid'],'wx',get_module_objpref('city',$row['objid'],$fetchwxa,'city_weather'),'city_weather');
			}

			$wx = e_rand(1,8);
			$fetchwx = "weather$wx";
			set_module_setting('weather', get_module_setting("$fetchwx",'city_weather'));

			$shadeswx = e_rand(1,8);
			$fetchwxb = "shadeswx$shadeswx";
			set_module_setting('shadeswx', get_module_setting("$fetchwxb",'city_weather'));
		break;

		case 'newday':
			global $session;
			require_once('modules/cityprefs/lib.php');
			$cityid = get_cityprefs_cityid('location',$session['user']['location']);
			if( get_module_objpref('city',$cityid,'chance','city_weather') > 0 )
			{
				output("`n`@From the ache in your battle weary bones, you know today's weather will be `^%s `@with a chance of `^%s`@.`n", translate_inline(get_module_setting('weather')), translate_inline(get_module_objpref('city',$cityid,'wx','city_weather')));
			}
			else
			{
				output("`n`@From the ache in your battle weary bones, you know today's weather will be `^%s`@.`n", translate_inline(get_module_setting('weather')));
			}
		break;

		case 'village':
			global $session;
			require_once('modules/cityprefs/lib.php');
			$cityid = get_cityprefs_cityid('location',$session['user']['location']);
			if( e_rand(1,100) <= get_module_objpref('city',$cityid,'chance','city_weather') )
			{
				output(get_module_objpref('city',$cityid,'wxreport','city_weather'), translate_inline(get_module_objpref('city',$cityid,'wx','city_weather')));
			}
			else
			{
				output(get_module_setting('wxreport'), translate_inline(get_module_setting('weather')));
			}
		break;

		case 'shades':
			output(get_module_setting('shadeswxreport'), translate_inline(get_module_setting('shadeswx')));
		break;

		case 'gardens':
		case 'index':
			output(get_module_setting('wxreport'), translate_inline(get_module_setting('weather')));
			output_notl('`n');
		break;
	}

	return $args;
}

function city_weather_run()
{
}
?>