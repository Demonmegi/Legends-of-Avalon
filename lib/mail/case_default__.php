<?php
output("`b`iMail Box`i`b");
if (isset($session['message'])) {
	output($session['message']);
}
$session['message']="";
$ordering = httpget('ordering');
$direction=httpget('direction');


$mail = db_prefix("mail");
$accounts = db_prefix("accounts");

$detail=httpget("detail");
$displaymode=get_module_pref("user_layout","gameoptions");
if ($detail=="" && $displaymode!=2) {
	if ($ordering=="") {
		if ($displaymode==0) $ordering="unread";
		if ($displaymode==1) $ordering="sent";
	}
	if ($direction=="") $direction='DESC';
	
	//‹bersicht ausgeben
	$sql  = "SELECT msgfrom, a.name, COUNT(messageid) AS total,";
	$sql .= " (SELECT max(sent) FROM mail WHERE msgfrom=m.msgfrom AND msgto={$session['user']['acctid']}) AS sent,";
	$sql .= " (SELECT COUNT(messageid) FROM mail WHERE msgfrom=m.msgfrom AND msgto={$session['user']['acctid']} AND seen=0) AS unread";
	$sql .= " FROM $mail AS m LEFT JOIN $accounts AS a ON a.acctid=m.msgfrom";
	$sql .= " WHERE msgto={$session['user']['acctid']} GROUP BY msgfrom ORDER BY $ordering $direction";

	debug($sql);
	$result = db_query($sql);
	$db_num_rows = db_num_rows($result);
	if ($db_num_rows>0){
		$no_subject = translate_inline("`i(No Subject)`i");
		rawoutput("<table>");
	
		//Ordering area
		//Added by Rohen von Falkenbruch at 2011-08-22 to allow sorting the mails by subject, from or date
		
		rawoutput("<tr class='trhead'>");
		rawoutput("<td><a href='mail.php?ordering=name&direction=" . (($ordering=='name'&& $direction=='ASC')?'DESC':'ASC') . "'>" . translate_inline('from') . "</a></td>");
		rawoutput("<td><a href='mail.php?ordering=seen&direction=" . (($ordering=='total'&& $direction=='ASC')?'DESC':'ASC') . "'>" . translate_inline('total') . "</a></td>");
		rawoutput("<td><a href='mail.php?ordering=subject&direction=" . (($ordering=='unread'&& $direction=='ASC')?'DESC':'ASC') . "'>" . translate_inline('unread') . "</a></td>");
		rawoutput("<td><a href='mail.php?ordering=subject&direction=" . (($ordering=='newest'&& $direction=='ASC')?'DESC':'ASC') . "'>" . translate_inline('newest') . "</a></td>");
		rawoutput("</tr>");
	
		while($row = db_fetch_assoc($result)){
			if ($row['msgfrom']==0 || !is_numeric($row['msgfrom'])){
				if ($row['msgfrom'] == 0 && is_numeric($row['msgfrom'])) {
					$row['name']=translate_inline("`i`^System`0`i");
				} else {
					$row['name']=$row['msgfrom'];
				}
			}

			rawoutput("<tr>");
			rawoutput("<td><a href='mail.php?detail={$row['msgfrom']}'>");
			output_notl($row['name']);
			rawoutput("</a></td><td><a href='mail.php?detail={$row['msgfrom']}'>");
			output_notl($row['total']);
			rawoutput("</a></td><td><a href='mail.php?detail={$row['msgfrom']}'>");
			output_notl($row['unread']);			
			rawoutput("</a></td><td><a href='mail.php?detail={$row['msgfrom']}'>");
			output_notl(date("M d, h:i a",strtotime($row['sent'])));		
			rawoutput("</a></td></tr>");
		}
		rawoutput("</table>");
	}else{
		output("`iAww, you have no mail, how sad.`i");
	}


} else {
	if ($ordering=="") $ordering="sent";
	if ($direction=="") $direction='DESC';

	$sql = "SELECT subject,messageid,$accounts.name,msgfrom,seen,sent FROM $mail LEFT JOIN $accounts ON $accounts.acctid=$mail.msgfrom ";
	$sql .= "WHERE msgto=\"".$session['user']['acctid']."\" ";
	if ($displaymode!=2) $sql.= " AND msgfrom=$detail ";
	$sql .= " ORDER BY $ordering $direction";	

	//debug($sql);
	$result = db_query($sql);
	$db_num_rows = db_num_rows($result);
	if ($db_num_rows>0){
		$no_subject = translate_inline("`i(No Subject)`i");
		rawoutput("<form action='mail.php?op=process' method='post'><table>");
	
		//Ordering area
		//Added by Rohen von Falkenbruch at 2011-08-22 to allow sorting the mails by subject, from or date
		
		rawoutput("<tr class='trhead'>");
		rawoutput("<td><a href='mail.php?ordering=seen&direction=" . (($ordering=='seen'&& $direction=='ASC')?'DESC':'ASC') . "'>" . translate_inline('seen') . "</a></td>");
		rawoutput("<td><a href='mail.php?ordering=subject&direction=" . (($ordering=='subject'&& $direction=='ASC')?'DESC':'ASC') . "'>" . translate_inline('subject') . "</a></td>");
		rawoutput("<td><a href='mail.php?ordering=name&direction=" . (($ordering=='name'&& $direction=='ASC')?'DESC':'ASC') . "'>" . translate_inline('from') . "</a></td>");
		rawoutput("<td><a href='mail.php?ordering=sent&direction=" . (($ordering=='sent'&& $direction=='ASC')?'DESC':'ASC') . "'>" . translate_inline('date') . "</a></td>");
		rawoutput("</tr>");
	
		while($row = db_fetch_assoc($result)){
			rawoutput("<tr>");
			rawoutput("<td nowrap><input type='checkbox' name='msg[]' value='{$row['messageid']}'>");
			rawoutput("<img src='images/".($row['seen']?"old":"new")."scroll.GIF' width='16px' height='16px' alt='".($row['seen']?"Old":"New")."'></td>");
			rawoutput("<td>");
			if ($row['msgfrom']==0 || !is_numeric($row['msgfrom'])){
				if ($row['msgfrom'] == 0 && is_numeric($row['msgfrom'])) {
					$row['name']=translate_inline("`i`^System`0`i");
				} else {
					$row['name']=$row['msgfrom'];
				}
				// Only translate the subject if it's an array, ie, it came from the game.
				$row_subject = @unserialize($row['subject']);
				if ($row_subject !== false) {
					$row['subject'] = call_user_func_array("sprintf_translate", $row_subject);
				} else {
						$row['subject'] = translate_inline($row['subject']);
					}
			}
			// In one line so the Translator doesn't screw the Html up
			output_notl("<a href='mail.php?op=read&id={$row['messageid']}'>".((trim($row['subject']))?$row['subject']:$no_subject)."</a>", true);
			rawoutput("</td><td><a href='mail.php?op=read&id={$row['messageid']}'>");
			output_notl($row['name']);
			rawoutput("</a></td><td><a href='mail.php?op=read&id={$row['messageid']}'>".date("M d, h:i a",strtotime($row['sent']))."</a></td>");
			rawoutput("</tr>");
		}
		rawoutput("</table>");
		$checkall = htmlentities(translate_inline("Check All"), ENT_COMPAT, getsetting("charset", "ISO-8859-1"));
		rawoutput("<input type='button' value=\"$checkall\" class='button' onClick='
			var elements = document.getElementsByName(\"msg[]\");
			for(i = 0; i < elements.length; i++) {
				elements[i].checked = true;
			}
		'>");
		$delchecked = htmlentities(translate_inline("Delete Checked"), ENT_COMPAT, getsetting("charset", "ISO-8859-1"));
		rawoutput("<input type='submit' class='button' value=\"$delchecked\">");
		rawoutput("</form>");
	}else{
		output("`iAww, you have no mail, how sad.`i");
	}
} //Detailview

if (db_num_rows($result) == 1) {
	output("`n`n`iYou currently have 1 message in your inbox.`nYou will no longer be able to receive messages from players if you have more than %s unread messages in your inbox.  `nMessages are automatically deleted (read or unread) after %s days.",getsetting('inboxlimit',50),getsetting("oldmail",14));
} else {
	output("`n`n`iYou currently have %s messages in your inbox.`nYou will no longer be able to receive messages from players if you have more than %s unread messages in your inbox.  `nMessages are automatically deleted (read or unread) after %s days.",db_num_rows($result),getsetting('inboxlimit',50),getsetting("oldmail",14));
}
?>