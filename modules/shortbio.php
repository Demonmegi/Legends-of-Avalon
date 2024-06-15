<?php
// translator ready
// addnews ready
// mail ready

function shortbio_getmoduleinfo(){
	$info = array(
		"name"=>"Bio Popup System",
		"version"=>"0.1",
		"author"=>"`2R`@o`ghe`2n `Qvon `2Fa`@lk`genbr`@uch`0, slim popup version of the core bio",
		"category"=>"RPG",
		"download"=>"on request",
		"override_forced_nav"=>true,
	);
	return $info;
}
function shortbio_install(){
	return true;
}

function shortbio_uninstall(){
	return true;
}

function shortbio_dohook($hookname,$args){
}

function shortbio_run(){
	global $session;
	if (!defined("OVERRIDE_FORCED_NAV")) define("OVERRIDE_FORCED_NAV", true);

	tlschema("bio");
	$char = httpget('char');
	//Legacy support
	if (is_numeric($char)){
		$where = "acctid = $char";
	} else {
		$where = "login = '$char'";
	}
	$sql = "SELECT login, name, level, sex, title, specialty, hashorse, acctid, resurrections, bio, dragonkills, race, clanname, clanshort, clanrank, ".db_prefix("accounts").".clanid, laston, loggedin FROM " . db_prefix("accounts") . " LEFT JOIN " . db_prefix("clans") . " ON " . db_prefix("accounts") . ".clanid = " . db_prefix("clans") . ".clanid WHERE $where";
	$result = db_query($sql);
	if ($target = db_fetch_assoc($result)) {
		$target['login'] = rawurlencode($target['login']);
		$id = $target['acctid'];
		$target['return_link']=""; //$return;

		//popup_header("Character Biography: %s", full_sanitize($target['name']));
		popup_header("Character Biography");
		modulehook("biotop", $target);

	output("`^Biography for %s`^.",$target['name']);
	$write = translate_inline("Write Mail");
	if ($session['user']['loggedin'])
	rawoutput("<a href=\"mail.php?op=write&to={$target['login']}\" target=\"_blank\" onClick=\"".popup("mail.php?op=write&to={$target['login']}").";return false;\"><img src='images/newscroll.GIF' width='16' height='16' alt='$write' border='0'></a>");
		output_notl("`n`n");
		if ($target['clanname']>"" && getsetting("allowclans",false)){
			$ranks = array(CLAN_APPLICANT=>"`!Applicant`0",CLAN_MEMBER=>"`#Member`0",CLAN_OFFICER=>"`^Officer`0",CLAN_LEADER=>"`&Leader`0", CLAN_FOUNDER=>"`\$Founder");
			$ranks = modulehook("clanranks", array("ranks"=>$ranks, "clanid"=>$target['clanid']));
			tlschema("clans"); //just to be in the right schema
			array_push($ranks['ranks'],"`\$Founder");
			$ranks = translate_inline($ranks['ranks']);
			tlschema();
			output("`@%s`2 is a %s`2 to `%%s`2`n", $target['name'], $ranks[$target['clanrank']], $target['clanname']);
		}

		$race = $target['race'];
		if (!$race) $race = RACE_UNKNOWN;
		tlschema("race");
		$race = translate_inline($race);
		tlschema();
		output("`^Race: `@%s`n",$race);
	
		$genders = array("Male","Female");
		$genders = translate_inline($genders);
		output("`^Gender: `@%s`n",$genders[$target['sex']]);
	
		$specialties = modulehook("specialtynames",
		array(""=>translate_inline("Unspecified")));
		if (isset($specialties[$target['specialty']])) {
			output("`^Specialty: `@%s`n",$specialties[$target['specialty']]);
		}
		$sql = "SELECT * FROM " . db_prefix("mounts") . " WHERE mountid='{$target['hashorse']}'";
		$result = db_query_cached($sql, "mountdata-{$target['hashorse']}", 3600);
		$mount = db_fetch_assoc($result);
	
		$mount['acctid']=$target['acctid'];
		$mount = modulehook("bio-mount",$mount);
		$none = translate_inline("`iNone`i");
		if (!isset($mount['mountname']) || $mount['mountname']=="")
		$mount['mountname'] = $none;
		output("`^Creature: `@%s`0`n",$mount['mountname']);
	
		$target['shortbio']=true;
		modulehook("biostat", $target);
	
		if ($target['bio']>"")
		output("`^Bio: `@`n%s`n",soap($target['bio']));
	
		modulehook("bioinfo", $target);
	
//		modulehook("bioend", $target);
	}
	popup_footer();
}
?>