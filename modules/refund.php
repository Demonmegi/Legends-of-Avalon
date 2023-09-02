<?php

function refund_getmoduleinfo(){
	$info = array(
		"name"=>"Estates Refund",
		"author"=>"Chris Vorndran",
		"category"=>"General",
		"version"=>"1.0",
		"settings"=>array(
			"gold"=>"How much gold is refunded?,int|5000",
			"gems"=>"How many gems are refunded?,int|50",
		),
		"prefs"=>array(
			"refund"=>"Has user been refunded?,bool|0",
		),
	);
	return $info;
}
function refund_install(){
	module_addhook("newday");
	return true;
}
function refund_uninstall(){
	return true;
}
function refund_dohook($hookname,$args){
	global $session;
	switch ($hookname){
		case "newday":
			if (get_module_pref("housesize","house") > 0 && !get_module_pref("refund","refund")){
				$gold = get_module_setting("gold");
				$gems = get_module_setting("gems");
				$session['user']['gold']+=$gold;
				$session['user']['gems']+=$gems;
				set_module_pref("refund",1);
				require_once("lib/systemmail.php");
				$subject = translate_inline("Refund!");
				$body = sprintf("In accordance with the demolition of the Estates District, you have been refunded %s gold and %s gems. Thank you for your cooperation.",$gold,$gems);
				systemmail($session['user']['acctid'],$subject,$body);
				debuglog("recieved $gold gold and $gems gems for refunded Estate");
				}
			break;
		}
	return $args;
}
?>		