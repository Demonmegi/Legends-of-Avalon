<?php
// translator ready
// addnews ready
// mail ready

function newdayreview_getmoduleinfo(){
	$info = array(
		"name"=>"NewdayRückblick",
		"version"=>"0.1",
		"author"=>"`2R`@o`ghe`2n `Qvon `2Fa`@lk`genbr`@uch`0",
		"category"=>"Character",
		"download"=>"on request",
		"override_forced_nav"=>true,
	);
	return $info;
}
function newdayreview_install(){
    module_addhook("footer-prefs");

	return true;
}

function newdayreview_uninstall(){
	return true;
}

function newdayreview_dohook($hookname,$args){
	global $session;
	switch($hookname){
        case "footer-prefs":
            // case "lodge":
            addnav("Mein Charakter");
            addnav("Letzter Newday", "runmodule.php?module=newdayreview",false,true);
			break;
	}
	return $args;
}

function newdayreview_run(){
	global $session;
	popup_header("Mein letzter Newday");
	$sql = "SELECT newdaytext FROM ".db_prefix("accounts_output")." WHERE acctid={$session['user']['acctid']}";
	$result = db_query($sql);
	$row=db_fetch_assoc($result);
	
	global $block_new_output;
	$temp = $block_new_output;
	set_block_new_output(false);
	rawoutput("<div>{$row['newdaytext']}</div>");
	set_block_new_output($temp);
	// echo($row['newdaytext']);
	popup_footer();
}
?>