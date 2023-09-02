<?php
function cityimages_getmoduleinfo(){
    $info = array(
        "name"=>"City Images",
        "version"=>"20070207",
        "author"=>"<a href='http://www.sixf00t4.com' target=_new>Sixf00t4</a>",
        "category"=>"Cities",
		"download"=>"http://dragonprime.net/index.php?module=Downloads;sa=dlview;id=1198",
		"vertxtloc"=>"http://www.legendofsix.com/",
        "description"=>"Allows images to be attached to each village",
		"prefs"=>array(
			"city Images,title",
			"user_show"=>"Show images of villages if available,bool|1",
        ), 
		"prefs-city"=>array(
            "cityimg"=>"Where is the image for this city?,text|",
            "cityimgtags"=>"What tags to use after the image?,text|",
        ),    
		"requires"=>array(
            "cityprefs"=>"20051113|By Sixf00t4, available on DragonPrime",
		),
	);
	return $info;
}

function cityimages_install(){
    module_addhook("village-desc"); 
    return true;
}

function cityimages_uninstall() {
	return true;
}

function cityimages_dohook($hookname,$args) {
	global $session;
    

	switch ($hookname) {
        case "village-desc":
			require_once("modules/cityprefs/lib.php");
			$cityid=get_cityprefs_cityid("cityname",$session['user']['location']);
            if(get_module_objpref("city",$cityid,"cityimg")!="" && get_module_pref("user_show")){
                rawoutput("<br><center><img src='".get_module_objpref("city",$cityid,"cityimg")."' ".get_module_objpref("city",$cityid,"cityimgtags")."></center><br>");
            }
        break;
              
	}
	return $args;
}

function cityimages_run(){}
php?>