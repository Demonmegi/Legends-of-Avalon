<?php
/*
* runmodule.php?module=house&lo=house& - House module for Legend of the Green Dragon 0.9.8+
* by Kujaku
* Version 1.47 released on December 26, 2004
* Couple of fixes by: Arune - (Location Login/Logout - Other Location Issues - Grammatical Fixes - Text Filtration - Mailing Locations)
* WARNING: BE SURE TO DELETE THE TABLE keys FROM OLDER VERSIONS!!!!
*/
require_once "common.php";
require_once "lib/commentary.php";
require_once "lib/systemmail.php";
require_once "lib/http.php";
require_once "lib/addnews.php";
function house_getmoduleinfo(){
    $info = array(
        "name"=>"House System",
        "author"=>"Kujaku - `^Chris Vorndran<br>`3Updates by: `#Kevin Hatfield/Arune `3& Lonny Luberts",
        "version"=>"2.0",
        "category"=>"House System",
        "download"=>"http://dragonprime.net/users/Sichae/house.zip",
		"vertxtloc"=>"http://dragonprime.net/users/Sichae/",
        "settings"=>array(
            "House System General Settings,title",
				"sleepon"=>"Is sleep in the estate turned on,bool|1",
				"slmas"=>"Is sleeping only on for the Owner of the Estate,bool|0",
				"goldcosts" => "Basic gold costs of a House,int|20000",
				"gemcosts" => "Basic gem costs of a House,int|30",
				"multiplicator" => "Multiplicator for building extension costs,float|0.2",
				"mindks" => "Minimum number of Dragonkills to build a House,int|0",
				"renamecostsgold" => "Amount of Gold a Namechange of the house costs,int|1000",
				"renamecostsgems" => "Amount of Gems a Namechange of the house costs,int|1",
				"housesperpage" => "Maximum Number of Houses shown per Page in the Residential Area,range,5,50,5|10",
				"doncost"=>"Cost in donation points before houses are available,int|0",
            "House System Treasure Settings,title",
				"enabletreasure" => "Enable the storage of Gold,bool|1",
				"treasuresize" => "Maximum Amount of Gold in the Chest,int|35000",
				"resettreasure" => "Reset Treasure after DK,bool|0",
				"goldperlevel"=>"Level multiplier to get amount of gold to withdraw,int|25",
				"dgoldperlevel"=>"Level multiplier to get amount of gold to deposit,int|25",
				"goldwith"=>"How many times for a gold withdraw,int|5",
            "House System Gem Storage Settings,title",
				"enablegems" => "Enable the storage of Gems,bool|0",
				"maxgems" => "Maximum Amount of Gems in the Chest,int|50",
				"resetgems" => "Reset Gemtreasure after DK,bool|0",
				"gemperlevel"=>"Level multilpier to get amount of gems to withdraw,int|1",
				"dgemperlevel"=>"Level multilpier to get amount of gems to deposit,int|1",
				"gemwith"=>"How many times for a gem withdraw,int|5",
            "House System Key Settings,title",
				"enablekeys"=>"Are keys enabled?,bool|1",
				"maxkeys" => "Maximum Number of keys to give,int|8",
                "goldkeycost" => "Cost for a key in gold,int|5000",
                "gemkeycost" => "Cost for a key in gems,int|5",
				"maxsize" => "Maximum Size of the House,int|10",
            "Appraisal Settings,title",
				"appon" => "Are the Appraisals on,bool|1",
				"pidgeon" => "How many pidgeons are swarming around your estate `ieffects hitpoints`i`0,range,1,25,1,|5",
				"goldrec" => "Multiply by house size to get the amount that architecht gives/takes from player,int|100",
				"tpturn" => "If house gets TPed how many turns are taken away for cleanup,range,1,10,1|2",
				"mystery" => "Mystery solution on the ground provides this many turns,range,1,10,1|2",
				"hpgain" => "Hitpoints gained from encounter with Old Baba,range,1,25,1|10",
        ),
        "prefs-house"=>array(
            "treasure" => "Goldtreasure,int|0",
            "gemtreasure" => "Gemtreasure,int|0",
            ),
        "prefs"=>array(
            "Housing System,title",
				"name" => "House Name|",
				"welcometitle" => "Welcome Title|",
				"village" => "Village of the House|",
				"praise" => "Has the house been praised today,bool|0",
				"location_saver" => "From where was the houselogoff used?, viewonly",
			"Treasure,title",
				"treasure" => "Goldtreasure,int|0",
				"gemtreasure" => "Gemtreasure,int|0",
				"golddone" => "Number of times you withdrew Gold for today,int|0",
				"gemdone"=>"Number of times you withdrew Gems for today,int|0",
			"House Specifications,title",
				"goldpaid" => "Gold paid,int|0",
				"gemspaid" => "Gems paid,int|0",
				"housesize" => "House Size,int|0",
                "keyamnt"=> "Number of keys bought,int|0",
                "keysgiven"=> "Number of keys given,int|0",
        )
    );
    return $info;
}
function house_install(){
    module_addhook("village");
    module_addhook("dragonkilltext");
    module_addhook("newday");
	module_addhook("pointsdesc");
    if (!db_table_exists(db_prefix("housekeys"))){
        db_query("CREATE TABLE `".db_prefix("housekeys")."` (
            `ownerid` int( 11 ) unsigned NOT NULL default '0',
            `houseid` int( 11 ) unsigned NOT NULL default '0',
            `housename` varchar( 50 ) NOT NULL default '',
            `location` varchar( 50 ) NOT NULL default ''
            ) TYPE = MYISAM ;");
    }
    return true;
}
function house_uninstall(){
    if (db_table_exists(db_prefix("housekeys")))
        db_query ("DROP TABLE ".db_prefix("housekeys").";");
    return true;
}
function house_dohook($hookname, $args){
    global $session;
    $city = getsetting("villagename", LOCATION_FIELDS);
	$cost = get_module_setting("doncost");
    switch ($hookname){
    case "village":
        tlschema($args['schemas']['gatenav']);
        addnav($args["gatenav"]);
        tlschema();
        addnav(array("%s Estates",$session['user']['location']),"runmodule.php?module=house");
    break;
	case "pointsdesc":
    if ($cost > 0){
        $args['count']++;
        $format = $args['format'];
        $str = translate("`^Estates are only available, after %s Dragon Kills and %s Donation Points.");
        $str = sprintf($str, get_module_setting("mindks"),$cost);
        output($format, $str, true);
		}
	break;
    case "dragonkilltext":
		$id = $session['user']['acctid'];
	if (get_module_pref("housesize", "house", $id) > 0){
        if (get_module_setting("resettreasure")) set_module_objpref("house", $id, "treasure", 0,"house");
        if (get_module_setting("resetgems")) set_module_objpref("house", $id, "gemtreasure", 0,"house");
	}
    break;
    case "newday":
        set_module_pref("gemdone",0);
        set_module_pref("golddone",0);
        set_module_pref("praise",0);
    break;
    }
    return $args;
}

function house_run(){
	global $SCRIPT_NAME;
	if ($SCRIPT_NAME == "runmodule.php"){
		require_once("modules/lib/house_func.php");
		include("modules/lib/house.php");
	}
}

?>