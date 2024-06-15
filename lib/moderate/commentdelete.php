<?php
	$comdb  = db_prefix("commentary");
	$accdb  = db_prefix("accounts");
	$bandb  = db_prefix("bans");
	$clandb = db_prefix("clans");
	
	$comment = httppost('comment');
	if (httppost('delnban')>''){
		$sql = "SELECT DISTINCT uniqueid,author FROM $comdb INNER JOIN $accdb ON acctid=author WHERE commentid IN ('" . join("','",array_keys($comment)) . "')";
		$result = db_query($sql);
		$untildate = date("Y-m-d H:i:s",strtotime("+3 days"));
		$reason = httppost("reason");
		$reason0 = httppost("reason0");
		$default = "Banned for comments you posted.";
		if ($reason0 != $reason && $reason0 != $default) $reason = $reason0;
		if ($reason=="") $reason = $default;
		while ($row = db_fetch_assoc($result)){
			$sql = "SELECT * FROM $bandb WHERE uniqueid = '{$row['uniqueid']}'";
			$result2 = db_query($sql);
			$sql = "INSERT INTO $bandb (uniqueid,banexpire,banreason,banner) VALUES ('{$row['uniqueid']}','$untildate','$reason','".addslashes($session['user']['name'])."')";
			$sql2 = "UPDATE $accdb SET loggedin=0 WHERE acctid={$row['author']}";
			if (db_num_rows($result2)>0){
				$row2 = db_fetch_assoc($result2);
				if ($row2['banexpire'] < $untildate){
					//don't enter a new ban if a longer lasting one is
					//already here.
					db_query($sql);
					db_query($sql2);
				}
			}else{
				db_query($sql);
				db_query($sql2);
			}
		}
	} //end delnban
	
	if (!isset($comment) || !is_array($comment)) $comment = array();
	$sql = "SELECT $comdb.*, $accdb.name, $accdb.login, $accdb.clanrank, " .
		"$clandb.clanshort FROM $comdb INNER JOIN $accdb ON ".
		"$accdb.acctid = $comdb.author LEFT JOIN $clandb ON ".
		"$clandb.clanid=$accdb.clanid WHERE commentid IN ('".join("','",array_keys($comment))."')";
	$result = db_query($sql);
	$invalsections = array();
	while ($row = db_fetch_assoc($result)){
		$sql = "INSERT LOW_PRIORITY INTO ".db_prefix("moderatedcomments").
			" (moderator,moddate,comment) VALUES ('{$session['user']['acctid']}','".date("Y-m-d H:i:s")."','".addslashes(serialize($row))."')";
		db_query($sql);
		$invalsections[$row['section']] = 1;
	}
	$sql = "DELETE FROM $comdb WHERE commentid IN ('" . join("','",array_keys($comment)) . "')";
	db_query($sql);
	$return = httpget('return');
	$return = cmd_sanitize($return);
	$return = substr($return,strrpos($return,"/")+1);
	if (strpos($return,"?")===false && strpos($return,"&")!==false){
		$x = strpos($return,"&");
		$return = substr($return,0,$x-1)."?".substr($return,$x+1);
	}
	foreach($invalsections as $key=>$dummy) {
		invalidatedatacache("comments-$key");
	}
	//update moderation cache
	invalidatedatacache("comments-or11");
	redirect($return);
?>