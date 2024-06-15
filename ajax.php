<?php
define("ALLOW_ANONYMOUS",true);
define("OVERRIDE_FORCED_NAV",true);
require_once("common.php");
require_once("lib/http.php");
require_once("lib/output_array.php");
// require_once("lib/commentary.php");
global $session;
global $navbysection;
$op=httpget('op');


function viewcommentary($section) {
	// Let's add a hook for modules to block commentary sections
	$clanrankcolors=array("`!","`#","`^","`&","`\$");

	// Needs to be here because scrolling through the commentary pages, entering a bio, then scrolling again forward
	// then re-entering another bio will lead to $com being smaller than 0 and this will lead to an SQL error later on.
	$commdb = db_prefix('commentary');
	$accdb  = db_prefix('accounts');
	$clandb = db_prefix('clans');

	$commentbuffer = array();
	$sql = "SELECT c.*, a.name, a.acctid, a.clanrank, cl.clanshort, b.name as originalname FROM ";
	$sql .= $commdb . " as c LEFT JOIN $accdb as a ON a.acctid = c.author ";
	$sql .= "LEFT JOIN $clandb as cl ON cl.clanid=a.clanid ";
	$sql .= "LEFT JOIN $accdb as b ON b.acctid=c.original ";
	$sql .= "WHERE section = '$section' AND (a.locked=0 OR a.locked is null) ";
	$sql .= "ORDER BY commentid DESC ";
	$sql .= "LIMIT 25";
	$result = db_query($sql);
	while($row = db_fetch_assoc($result)) $commentbuffer[] = $row;

	$rowcount = count($commentbuffer);

	$counttoday=0;
	$nextrow=array();
	for ($i=0; $i < $rowcount; $i++){
		$row = $commentbuffer[$i];
		$nextrow=array();
		if (($i+1)<$rowcount) $nextrow=$commentbuffer[$i+1];


		if (isset($nextrow['acctid']) && isset($row['acctid']) && $nextrow['acctid']==$row['acctid'] && (strpos(substr(strrev($nextrow['comment']),0,5),">")!==false)) {
			$ft = "";
			if (substr($row['comment'],0,2)=="::") {
				$ft = '::';
			} elseif (substr($row['comment'],0,1)==":") {
				$ft = ':';
			} elseif (substr($row['comment'],0,3)=="/me") {
				$ft = '/me';
			} elseif (substr($row['comment'],0,5)=="/game") {
				$ft = '/game';
			} elseif (substr($row['comment'],0,2)=="/x") {
				$ft = '/x';
			}
			$x = strpos($row['comment'],$ft);
			$checkline=substr($row['comment'],$x+strlen($ft));
		}

		$row['comment'] = comment_sanitize($row['comment']);
		$commentids[$i] = $row['commentid'];
		$x=0;
		$ft="";
		for ($x=0;strlen($ft)<5 && $x<strlen($row['comment']);$x++){
			if (substr($row['comment'],$x,1)=="`" && strlen($ft)==0) {
				$x++;
			}else{
				$ft.=substr($row['comment'],$x,1);
			}
		}

		if (substr($ft,0,2)=="::")
			$ft = substr($ft,0,2);
		elseif (substr($ft,0,1)==":")
			$ft = substr($ft,0,1);
		elseif (substr($ft,0,3)=="/me")
			$ft = substr($ft,0,3);
		elseif (substr($ft,0,2)=="/x")
			$ft = substr($ft,0,2);


		if ($row['clanrank']) {
			$row['name'] = ($row['clanshort']>""?"{$clanrankcolors[ceil($row['clanrank']/10)]}&lt;`2{$row['clanshort']}{$clanrankcolors[ceil($row['clanrank']/10)]}&gt; `&":"").$row['name'];
		}
		if ($ft=="::" || $ft=="/me" || $ft==":"){
			$x = strpos($row['comment'],$ft);
			if ($x!==false){
				$op[$i] = str_replace("&amp;","&",HTMLEntities(substr($row['comment'],0,$x), ENT_COMPAT, "ISO-8859-1"))."`0`&{$row['name']}`0`& ".str_replace("&amp;","&",HTMLEntities(substr($row['comment'],$x+strlen($ft)), ENT_COMPAT, "ISO-8859-1"))."`0`n";
				$rawc[$i] = str_replace("&amp;","&",HTMLEntities(substr($row['comment'],0,$x), ENT_COMPAT, "ISO-8859-1"))."`0`&{$row['name']}`0`& ".str_replace("&amp;","&",HTMLEntities(substr($row['comment'],$x+strlen($ft)), ENT_COMPAT, "ISO-8859-1"))."`0`n";
			}
		}
		if (($ft=="/game" || $ft=="/x") && !$row['name']) {
			$x = strpos($row['comment'],$ft);
			if ($x!==false){
			$commentstr=substr($row['comment'],0,$x);
			$commentstr2=substr($row['comment'],$x+strlen($ft));
			if ($ft=="/x") $commentstr2 = '`7(' . $row['originalname'] . '`7) `0' . $commentstr2;

			$op[$i] = str_replace("&amp;","&",HTMLEntities($commentstr, ENT_COMPAT, "ISO-8859-1"))."`0`&".str_replace("&amp;","&",HTMLEntities($commentstr2, ENT_COMPAT, "ISO-8859-1"))."`0`n";
			}
		}
		if (!isset($op) || !is_array($op)) $op = array();
		if (!array_key_exists($i,$op) || $op[$i] == "")  {
			if (substr($ft,0,5)=='/game' && !$row['name'])
				$op[$i] = str_replace("&amp;","&",HTMLEntities($row['comment'], ENT_COMPAT, "ISO-8859-1"));
			else
				$op[$i] = "`&{$row['name']}`3 says, \"`#".str_replace("&amp;","&",HTMLEntities($row['comment'], ENT_COMPAT, "ISO-8859-1"))."`3\"`0`n";
			$rawc[$i] = "`&{$row['name']}`3 says, \"`#".str_replace("&amp;","&",HTMLEntities($row['comment'], ENT_COMPAT, "ISO-8859-1"))."`3\"`0`n";
		}

		$time = strtotime($row['postdate']);
		$s=date("`7" . "[m/d h:ia]" . "`0 ",$time);
		$op[$i] = $s.$op[$i];

		$auth[$i] = $row['author'];
		if (isset($rawc[$i])) {
			$rawc[$i] = full_sanitize($rawc[$i]);
			$rawc[$i] = htmlentities($rawc[$i], ENT_QUOTES, "ISO-8859-1");
		}
	}
// $i--;
	$i = $rowcount;
	$outputcomments=array();
	$sect="x";

	$scriptname=substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
	$pos=strpos($_SERVER['REQUEST_URI'],"?");
	$return=$scriptname.($pos==false?"":substr($_SERVER['REQUEST_URI'],$pos));
	$one=(strstr($return,"?")==false?"?":"&");
	for (;$i>=0;$i--){
		$out="";
		if (isset($op[$i])) $out.=$op[$i];
		if (!array_key_exists($sect,$outputcomments) || !is_array($outputcomments[$sect])) $outputcomments[$sect]=array();
		array_push($outputcomments[$sect],$out);
	}

	//output the comments
	ksort($outputcomments);
	reset($outputcomments);

	// foreach ($outputcomments as $sec=>$v) {
	// 	foreach ($v as $key=>$val) {
	// 		// $args = array('commentline'=>$val);
	// 		// $args = modulehook("viewcommentary", $args);
	// 		// $val = $args['commentline'];
	// 		output_notl($val, true);
	// 	}
	// }
	rawoutput("</center>");

	db_free_result($result);
    return $outputcomments;
}

$activetime = get_module_pref('activatetime','ajax_chat');
// if (strtotime("-3600 seconds") > $activetime){
// 	// force the abandoning of the session when the user should have been
// 	// sent to the fields.
// 	$session=array();
// 	translator_setup();
// 	$session['message'].=translate_inline("`nYour session has expired!`n","common");
//         redirect('index.php');
// 		break;
// }

if ($op=='mail') {
    if (isset($activetime) && isset($session['loggedin']) && strtotime("-".getsetting("LOGINTIMEOUT",900)." seconds") > $activetime && $activetime>0 && $session['loggedin']){
        printf("Timeout");
    } else {
        //block a: Mails aktualisieren
        $sql = "SELECT sum(if(seen=1,1,0)) AS seencount, sum(if(seen=0,1,0)) AS notseen FROM " . db_prefix("mail") . " WHERE msgto=\"".$session['user']['acctid']."\"";
        // $result = db_query_cached($sql,"mail-{$session['user']['acctid']}",86400);
        $result = db_query($sql); //,"mail-{$session['user']['acctid']}",86400);
        $row = db_fetch_assoc($result);
        db_free_result($result);
        $row['seencount']=(int)$row['seencount'];
        $row['notseen']=(int)$row['notseen'];
        if ($row['notseen']>0){
            printf("<a href='mail.php' target='_blank' onClick=\"".popup("mail.php").";return false;\" class='hotmotd'>".translate_inline("Ye Olde Mail: %s new, %s old", 'common')."</a>",$row['notseen'],$row['seencount']);
        }else{
            printf("<a href='mail.php' target='_blank' onClick=\"".popup("mail.php").";return false;\" class='motd'>".translate_inline("Ye Olde Mail: %s new, %s old", 'common')."</a>",$row['notseen'],$row['seencount']);
        }
        $seconds = ($activetime-strtotime("-".getsetting("LOGINTIMEOUT",900)." seconds"));
        printf("<br>Logout in " . date('i:s',$seconds));
    }
} elseif ($op=='content') {
    // echo("Time: " . $activetime);
    if (isset($activetime) && isset($session['loggedin']) && strtotime("-".getsetting("LOGINTIMEOUT",900)." seconds") > $activetime && $activetime>0 && $session['loggedin']){
        printf("Timeout - Reload Page!");
    } else {
        $section        =httpget('section'); //get_module_pref("location","ajax_chat");
        $scriptname     =get_module_pref("script","ajax_chat");
        $refreshname    =URLEncode(get_module_pref("request","ajax_chat"));
        $scriptname     =substr($scriptname,strrpos($scriptname,"/")+1);
        $searchscript   =substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'],"/")+1);

        // $session['allowednavs']=array();
        // $session['allowednavs']=unserialize(get_module_pref("allowednavs","ajax_chat"));
        
        $comments=viewcommentary($section);
        foreach ($comments as $sec=>$v) {
            foreach ($v as $key=>$val) {
                    $args = array('commentline'=>$val);
                    $args = modulehook("viewcommentary", $args);
                    $val = $args['commentline'];
                    //Script tauschen
                    $val = str_replace(URLEncode($_SERVER['REQUEST_URI']),$refreshname,$val);
                    $val = str_replace($searchscript,$scriptname,$val);
                    echo(appoencode($val,true));
            }
        }
    }
    // //Umschreiben der Allowed-Navs
    // $target=array();
    // foreach ($session['allowednavs'] as $key => $val) {
    //     //echo $key . "<br>";
    //     $key = str_replace(URLEncode($_SERVER['REQUEST_URI']),$refreshname,$key);
    //     $key = str_replace($searchscript,$scriptname,$key);
    //     $target[$key]=$val;
    // }
    // $session['allowednavs']=$target;
}
//Timer aktualisieren
// saveuser();
?>
