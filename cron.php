<?php

if (!defined("ALLOW_ANONYMOUS")) define("ALLOW_ANONYMOUS",true);

require_once("common.php");
savesetting("newdaySemaphore",gmdate("Y-m-d H:i:s"));
modulehook("newday-runonce",array());

if (getsetting("usedatacache",0)){
	$handle = opendir($datacachefilepath);
	while (($file = readdir($handle)) !== false) {
		if (substr($file,0,strlen(DATACACHE_FILENAME_PREFIX)) ==
				DATACACHE_FILENAME_PREFIX){
			$fn = $datacachefilepath."/".$file;
			$fn = preg_replace("'//'","/",$fn);
			$fn = preg_replace("'\\\\'","\\",$fn);
			if (is_file($fn) &&
					filemtime($fn) < strtotime("-24 hours")){
				unlink($fn);
			}else{
			}
		}
	}
}

//Expire Chars
//require_once("lib/expire_chars.php");

//Clean up old mails
$sql = "DELETE FROM " . db_prefix("mail") . " WHERE sent<'".date("Y-m-d H:i:s",strtotime("-".getsetting("oldmail",14)."days"))."'";
db_query($sql);
massinvalidate("mail");

if (getsetting("expirecontent",180)>0){
	//Clean up debug log, moved from there
  	$timestamp = date("Y-m-d H:i:s",strtotime("-".getsetting("expirecontent",180)." days"));
	$sql = "DELETE FROM " . db_prefix("debuglog") . " WHERE date <'$timestamp'";
 	db_query($sql);
   require_once("lib/gamelog.php");
   gamelog("Cleaned up ".db_affected_rows()." from ".db_prefix("debuglog")." older than $timestamp.",'maintenance');

	//Clean up game log
	$timestamp = date("Y-m-d H:i:s",strtotime("-1 month"));
	$sql = "DELETE FROM ".db_prefix("gamelog")." WHERE date < '$timestamp' ";
	db_query($sql);
	gamelog("Cleaned up ".db_prefix("gamelog")." table removing ".db_affected_rows()." older than $timestamp.","maintenance");

	//Clean up old comments

	$sql = "DELETE FROM " . db_prefix("commentary") . " WHERE postdate<'".date("Y-m-d H:i:s",strtotime("-".getsetting("expirecontent",180)." days"))."'";
	db_query($sql);
	gamelog("Deleted ".db_affected_rows()." old comments.","comment expiration");
}

# if (strtotime(getsetting("lastdboptimize", date("Y-m-d H:i:s", strtotime("-1 day")))) < strtotime("-1 day"))
# require_once("lib/newday/dbcleanup.php");
require_once("lib/expire_chars.php");
# massinvalidate("mail");
?>
