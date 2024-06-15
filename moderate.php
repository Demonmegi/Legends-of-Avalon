<?php
// translator ready
// addnews ready
// mail ready
require_once("common.php");
require_once("lib/commentary.php");
require_once("lib/sanitize.php");
require_once("lib/http.php");

tlschema("moderate");

addcommentary();

check_su_access(SU_EDIT_COMMENTS);

require_once("lib/superusernav.php");
superusernav();

//install main navigation
addnav("Controls");
addnav("Commentary Overview","moderate.php");
addnav("Reset Seen Comments","moderate.php?seen=".rawurlencode(date("Y-m-d H:i:s")));
addnav("B?Player Bios","bios.php");
if ($session['user']['superuser'] & SU_AUDIT_MODERATION){
	addnav("Audit Moderation","moderate.php?op=audit");
}

addnav("Review by Moderator");

addnav("Commentary");
addnav("Sections");

$op = httpget("op");
//the following section deletes comments and ban the poster. entry to the ban list is set
//outsourced to an lib-file
if ($op=="commentdelete") require_once('lib/moderate/commentdelete.php');

$seen = httpget("seen");
if ($seen>""){
	$session['user']['recentcomments']=$seen;
}

//building main page
page_header("Comment Moderation");

if ($op==""){
	$area = httpget('area');
	$link = "moderate.php" . ($area ? "?area=$area" : "");
	$refresh = translate_inline("Refresh");
	rawoutput("<form action='$link' method='POST'>");
	rawoutput("<input type='submit' class='button' value='$refresh'>");
	rawoutput("</form>");
	addnav("", "$link");
	
	if ($area==""){
		//talkform("X","says");
		$forbidden=array();
		$forbidden=modulehook("forbiddenmoderatelist",$forbidden);
		commentdisplay("", "","",100,"",false,$forbidden,true);
	}else{
		commentdisplay("", $area,"X",100,"",false,true);
		//talkform($area,"says");
	}
}elseif ($op=="audit") require_once('lib/moderate/audit.php');

//allow modules to filter their sections
$sectionfilter=array();
$sectionfilter=modulehook("createmoderatelist",$sectionfilter);
//all sections listed in the sectionfilter are allready listed, so there is no need to display them again
//estimated structure:
// $sectionfilter['areaname']=array("name"=>"name of the area",
//																	"group"=>"groupname");
//

//from hook handled structure
tlschema("notranslate");
if (isset($sectionfilter) && is_array($sectionfilter)) {
	foreach ($sectionfilter as $area=>$data) {
		//at this point name should contain an array of name and groupname
		if (!is_array($data)) {
			addnav($data,"moderate.php?area=$area");
		} else {
			addnav($data['group']);
			addnav($data['name'], "moderate.php?area=$area");
		}
	}
}
tlschema();

addnav("Sections");

//main locations need a manuall check
$mainnav = array();

// the inn name is a proper name and shouldn't be translated.
 tlschema("notranslate");
 $mainnav['inn']=getsetting("innname", LOCATION_INN);
 //addnav($mainnav['inn'],"moderate.php?area=inn");
 tlschema();

tlschema("commentary");
if ($session['user']['superuser'] & ~SU_DOESNT_GIVE_GROTTO) $mainnav['superuser']='Grotto';
$mainnav['village']=array("%s Square", getsetting("villagename", LOCATION_FIELDS));
$mainnav['shade']='Land of the Shades';
$mainnav['grassyfield']='Grassy Field';

$mainnav['motd']='MotD';
$mainnav['veterans']="Veterans Club";
$mainnav['hunterlodge']="Hunter's Lodge";
$mainnav['gardens']="Gardens";
$mainnav['waiting']="Clan Hall Waiting Area";

if (getsetting("betaperplayer", 1) == 1 && @file_exists("pavilion.php")) {
	$mainnav['beta']="Beta Pavilion";
}

// These are already translated in the module.
addnav("Sections");
foreach ($mainnav as $area=>$name) {
	if (!array_key_exists($area,$sectionfilter)) addnav($name, "moderate.php?area=$area");
}
tlschema();

if ($session['user']['superuser'] & SU_MODERATE_CLANS){
	addnav("Clan Halls");
	$sql = "SELECT clanid,clanname,clanshort FROM " . db_prefix("clans") . " ORDER BY clanid";
	$result = db_query($sql);
	// these are proper names and shouldn't be translated.
	tlschema("notranslate");
	while ($row=db_fetch_assoc($result)){
		addnav(array("<%s> %s", $row['clanshort'], $row['clanname']),
				"moderate.php?area=clan-{$row['clanid']}");
	}
	tlschema();
} elseif ($session['user']['superuser'] & SU_EDIT_COMMENTS &&
		getsetting("officermoderate", 0)) {
	// the CLAN_OFFICER requirement was chosen so that moderators couldn't
	// just get accepted as a member to any random clan and then proceed to
	// wreak havoc.
	// although this isn't really a big deal on most servers, the choice was
	// made so that staff won't have to have another issue to take into
	// consideration when choosing moderators.  the issue is moot in most
	// cases, as players that are trusted with moderator powers are also
	// often trusted with at least the rank of officer in their respective
	// clans.
	if (($session['user']['clanid'] != 0) &&
			($session['user']['clanrank'] >= CLAN_OFFICER)) {
		addnav("Clan Halls");
		$sql = "SELECT clanid,clanname,clanshort FROM " . db_prefix("clans") . " WHERE clanid='" . $session['user']['clanid'] . "'";
		$result = db_query($sql);
		// these are proper names and shouldn't be translated.
		tlschema("notranslate");
		if ($row=db_fetch_assoc($result)){
			addnav(array("<%s> %s", $row['clanshort'], $row['clanname']),
					"moderate.php?area=clan-{$row['clanid']}");
		} else {
			debug ("There was an error while trying to access your clan.");
		}
		tlschema();
	}
}

//handle my 
addnav("Modules");
$mods = array();
$mods = modulehook("moderate", $mods);
reset($mods);

// These are already translated in the module.
tlschema("notranslate");
foreach ($mods as $area=>$name) {
	if (!array_key_exists($area,$sectionfilter)) addnav($name, "moderate.php?area=$area");
}
tlschema();

page_footer();
?>