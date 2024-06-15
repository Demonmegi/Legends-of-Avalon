<?php
// translator ready
// addnews ready
// mail ready
define("OVERRIDE_FORCED_NAV",true);
require_once("common.php");
require_once("lib/villagenav.php");

tlschema("badnav");
debug($session['lastsql']);
if ($session['user']['loggedin'] && $session['loggedin']){
	if (isset($session['output']) && strpos($session['output'],"<!--CheckNewDay()-->")){
		checkday();
	}
	foreach ($session['allowednavs'] as $key=>$val){
		//hack-tastic.
		if (
			trim($key)=="" ||
			$key===0 ||
			substr($key,0,8)=="motd.php" ||
			substr($key,0,8)=="mail.php"
		) unset($session['allowednavs'][$key]);
	}
	$sql="SELECT output FROM ".db_prefix("accounts_output")." WHERE acctid={$session['user']['acctid']};";
	$result=db_query($sql);
	$row=db_fetch_assoc($result);
	if (!is_array($session['allowednavs']) ||
			count($session['allowednavs'])==0 || (!isset($row)) || $row['output']=="") {
		$session['allowednavs']=array();
		page_header("Your Navs Are Corrupted");
		if ($session['user']['alive']) {
			villagenav();
			output("Your navs are corrupted, please return to %s.",
					$session['user']['location']);
		} else {
			addnav("Return to Shades", "shades.php");
			output("Your navs are corrupted, please return to the Shades.");
		}
		page_footer();
	}
	echo $row['output'];
	$session['debug']="";
	$session['user']['allowednavs']=$session['allowednavs'];
	saveuser();
}else{
	$session=array();
	translator_setup();
	redirect("index.php");
}

?>