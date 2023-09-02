<?php
function house_appraise(){
    global $session;

    if (get_module_setting("appon")==1){
            if (get_module_pref("housesize")>0 && get_module_pref("village")==$session['user']['location']){
            if (get_module_pref("praise")==0){
            switch (e_rand(1,5)){
                case 1:
                    if (get_module_pref("housesize") >= (get_module_setting("maxsize")-1)){
                    $goldrec = get_module_setting("goldrec")*get_module_pref("housesize");
                    output("`2An architect wanders by your house and sees the beauty and majesty all around your estate.");
                    output(" `2He walks over to you and his eyes are rather wide and he appears to be overwhelmed with joy.");
                    output(" `2He reaches out his hand and hands you a small sactchel full of gold.");
                    output(" `2You open it and see `^%s gold.`0`n`n",$goldrec);
                    $session['user']['gold']+=$goldrec;
                    set_module_pref("praise",1);
                    debuglog("gained $goldrec gold for good housekeeping");
                }else{
                    $goldgone = get_module_setting("goldrec")*get_module_pref("housesize");
                    output("`2An architect wanders by your house and sees the disgusting filth that lays about the estate.");
                    output(" `2He walks over to you and his eyes are wide and he looks slightly disgusted.");
                    output(" `2He reaches out his hand and takes your small sactchel full of gold.");
                    output(" `2He gives it back, and `^%s gold `2is missing.`0`n`n",$goldgone);
                    if ($session['user']['gold'] <= $goldgone){
                        $session['user']['gold'] = 0;
                    }else{
                    $session['user']['gold']-=$goldgone;
                    }
                    set_module_pref("praise",1);
                    debuglog("lost $goldgone gold for bad housekeeping");
                }
                    break;
                case 2:
                    $tpturn = get_module_setting("tpturn");
                    output("`2You walk down the long alley to your home, and sense some danger in the air.");
                    output(" `2You look upon your estate and see that it has been attacked by vandals.");
                    output(" `2Your house has been TP'd.");
                    output(" `2It takes you `\$%s forest fights`2 worth of energy, to take down the toilet paper.`0`n`n",$tpturn);
                    if ($session['user']['turns'] <= $tpturn){
                        $session['user']['turns'] = 0;
                    }else{
                    $session['user']['turns']-=$tpturn;
                    }
                    set_module_pref("praise",1);
                    debuglog("lost $tpturn turns due to vandals");
                    break;
                case 3:
                    $pidgeon = get_module_setting("pidgeon");
                    output("`2You walk down the narrow street to your house and see many shadows on the ground.");
                    output(" `2You look up and see `3%s pidgeons`2, that are swarming in the skies.",$pidgeon);
                    output(" `2You toss a rock up, only to see it come down, with the pidgeons following it.");
                    output(" `2Each pidgeons hits you, dealing `\$%s damage`2 to you.`0`n`n",$pidgeon);
                    if ($session['user']['hitpoints'] <= $pidgeon){
                        $session['user']['hitpoints'] = 0;
                        $session['user']['alive']=false;
                        addnews("%s was destroyed by Pidgeons around their estate.",$session['user']['name']);
                    }else
                    $session['user']['hitpoints']-=$pidgeon;
                    set_module_pref("praise",1);
                    debuglog("lost $pidgeon hitpoints to pidgeons");
                    break;
                case 4:
                    $mystery = get_module_setting("mystery");
                    output("`2You walk down the narrow alleyway, that leads to your house.");
                    output(" `2You see a faint shadow in the distance, that is moving rather rapidly.");
                    output(" `2You hear a small chink of glass on stone, and rush over to see what it is.");
                    output(" `2You pick up a glass vial and decide, `iWhat the hey?`i.");
                    output(" `2You down the vial and feel empowered... for just about `@%s forest fights`2.`0`n`n",$mystery);
                    $session['user']['turns']+=$mystery;
                    set_module_pref("praise",1);
                    debuglog("gained $mystery turns from the vial dropped in the alley");
                    break;
                case 5:
                    $hpgain = get_module_setting("hpgain");
                    output("`2You are walking back to your estate, you just came from a large party and your friends estate.");
                    output(" `2You see an Old Lady on the ground, she appears to be unconsious.");
                    output(" `2You walk over to her and nudge her a bit and she wakes up..");
                    output("\"`%Thank you my child, for caring enough to come to my aide.`2\"");
                    output(" `2She pokes you with a stick and you feel a bit empowered.");
                    output(" `2You have gained `^%s hitpoints.`0`n`n",$hpgain);
                    $session['user']['hitpoints']+=$hpgain;
                    set_module_pref("praise",1);
                    debuglog("gained $hpgain hitpoints from helping Old Baba");
                    break;
        }
        }else{
        output("`2You feel an emptyness...best to wait until the morrow.`0`n`n");
        }
    }
    }
}
function house(){
global $session;
    $id = httpget("id");
    $op = httpget("op");
	$op2 = httpget("op2");
    $gold = httppost ("gold");
    $gems = httppost ("gems");
    $estloc = translate_inline("Estate Housing");
    $gemdone = get_module_pref("gemdone");
    $golddone = get_module_pref("golddone");
    $gemwith = get_module_setting("gemwith");
    $goldwith = get_module_setting("goldwith");
    $goldperlevel = get_module_setting("goldperlevel");
    $gemperlevel = get_module_setting("gemperlevel");
    $dgoldperlevel = get_module_setting("dgoldperlevel");
    $dgemperlevel = get_module_setting("dgemperlevel");
	$keyamnt = get_module_pref("keyamnt");
	page_header(array("The residential area of %s", $session['user']['location']));

    blocknav ("runmodule.php?module=house&lo=house&id=".$session['user']['acctid']);
    blocknav ("runmodule.php?module=house&lo=sellhouse");
    blocknav ("runmodule.php?module=house&lo=buildhouse");
    if (get_module_pref("housesize", "house", $id) > 0){
    if ($session['user']['location'] == $estloc) {
        page_header(array("The residential area of %s", get_module_pref("location_saver", "house")));
    } else {
        page_header(array("The residential area of %s", $session['user']['location']));
    }

    if ($session['user']['location'] == $estloc) {
        $session['user']['location'] = get_module_pref("location_saver", "house");
        set_module_pref("location_saver", "", "house");
    }
        output_notl ("`&`c`b%s`b`c`3`n", stripslashes(get_module_pref("name", "house", $id)));

        addnav ("Actions");
        if (get_module_setting("sleepon")==1){
			if (get_module_setting("slmas") == 1){
				if ($id == $session['user']['acctid']) addnav ("Sleep (Logout)", "runmodule.php?module=house&lo=house&id=$id&op=sleep");
			}else{
				addnav ("Sleep (Logout)", "runmodule.php?module=house&lo=house&id=$id&op=sleep");
			}
		}
        if ($id == $session['user']['acctid']){
            if (get_module_pref("housesize") < get_module_setting("maxsize")){
                addnav ("Extend your House", "runmodule.php?module=house&lo=house&id=$id&op=extend");
            }
            addnav ("Estate Description", "runmodule.php?module=house&lo=house&id=$id&op=welcome");
            addnav ("Rename your House", "runmodule.php?module=house&lo=house&id=$id&op=rename");
            addnav ("Keys");
            if((get_module_pref('keysgiven')) < (get_module_pref('keyamnt'))) addnav("Give Key","runmodule.php?module=house&lo=house&id=$id&op=givek");
            if(get_module_pref('keysgiven') > 0) addnav("Withdraw Key", "runmodule.php?module=house&lo=house&id=$id&op=withk");
			if(get_module_pref('keyamnt') < get_module_setting('maxkeys')) addnav("Purchase More Keys","runmodule.php?module=house&lo=house&id=$id&op=buyk");
        }
        if (get_module_setting ("enabletreasure","house",$id)){
            addnav ("House Treasure");
            addnav ("Withdraw Gold from Chest","runmodule.php?module=house&lo=house&id=$id&op=goldw");
            addnav ("Deposit Gold in Chest","runmodule.php?module=house&lo=house&id=$id&op=goldd");
        }
        if (get_module_setting ("enablegems","house",$id)){
            addnav ("House Treasure");
            addnav ("Withdraw Gems from Chest","runmodule.php?module=house&lo=house&id=$id&op=gemsw");
            addnav ("Deposit Gems in Chest","runmodule.php?module=house&lo=house&id=$id&op=gemsd");
        }
        switch ($op){
			case "sleep":
            set_module_pref("location_saver", $session['user']['location'], "house");
            if ($session['user']['loggedin']){
                $session['user']['restorepage'] = "runmodule.php?module=house&lo=house&id=$id&op=wakeup";
                  $sql = "UPDATE " . db_prefix("accounts") . " SET loggedin=0, location='$estloc', restorepage='{$session['user']['restorepage']}' WHERE acctid = ".$session['user']['acctid'];
                db_query($sql);
                invalidatedatacache("charlisthomepage");
                invalidatedatacache("list.php-warsonline");
            }
            $session=array();
            redirect("index.php");
        break;
		case "buyk":
			if ($id != $session['user']['acctid']) redirect ("runmodule.php?module=house&lo=house&id=$id&op=");
			$goldkeycost = get_module_setting("goldkeycost");
			$gemkeycost = get_module_setting("gemkeycost");
			if ($op2 == "done"){
				$session['user']['gems']-=$gemkeycost;
				$session['user']['gold']-=$goldkeycost;
				$keyamnt++;
				set_module_pref("keyamnt",$keyamnt);
				output("`3You have bought a key.");
				output(" Don't you feel proud?");
				output(" This brings your total to: `^%s `3Keys.",$keyamnt);
			}elseif($op2 == "mid"){
				if ($keyamnt >= get_module_setting("maxsize") * get_module_setting("keyspersize")){
					output("`3You have no more room in your Key Cubby...");
					output(" You should charge rent for those `^%s `3People.",get_module_setting("maxsize") * get_module_setting("keyspersize"));
				}
				if ($keyamnt >= get_module_setting("mxkop")){
					output("`3You have no more room in your Key Cubby...");
					output(" You should charge rent for those `^%s `3People.",get_module_setting("mxkop"));
				}
				if ($session['user']['gold'] < $goldkeycost){
					output("`3You do not have enough Gold for the Key.");
					output(" Please aquire `^%s `3more gold.`n`n",$goldkeycost - $session['user']['gold']);
				}
				if ($session['user']['gems'] < $gemkeycost){
					output("`3You do not have enough gems for the Key.");
					output(" Please aquire `5%s `3more gems.`n`n",$gemkeycost - $session['user']['gems']);
				}
			}else{
				if ($session['user']['gems'] < $gemkeycost || $session['user']['gold'] < $goldkeycost) redirect ("runmodule.php?module=house&lo=house&id=$id&op=buyk&op2=mid");
				blocknav("runmodule.php?module=house&lo=house&id=$id&op=givek");
				blocknav("runmodule.php?module=house&lo=house&id=$id&op=withk");
				blocknav("runmodule.php?module=house&lo=house&id=$id&op=extend");
				blocknav("runmodule.php?module=house&lo=house&id=$id&op=welcome");
				blocknav("runmodule.php?module=house&lo=house&id=$id&op=rename");
				blocknav("runmodule.php?module=house&lo=house&id=$id&op=goldd");
				blocknav("runmodule.php?module=house&lo=house&id=$id&op=goldw");
				blocknav("runmodule.php?module=house&lo=house&id=$id&op=gemsd");
				blocknav("runmodule.php?module=house&lo=house&id=$id&op=gemsw");
				blocknav("runmodule.php?module=house&lo=house&id=$id&op=buyk");
				output("`3Do you wish to purchase a new Key?");
				output(" They cost `^%s `3Gold and `5%s `3Gems.",$goldkeycost,$gemkeycost);
				addnav("Choices");
				addnav("Yes","runmodule.php?module=house&lo=house&id=$id&op=buyk&op2=done");
				addnav("No","runmodule.php?module=house&lo=house&id=$id&op=");
			}
			break;
        case "extend":
            if ($id != $session['user']['acctid']) redirect ("runmodule.php?module=house&lo=house&id=$id&op=");

            $gemcosts = get_module_setting("gemcosts") * get_module_setting("multiplicator");
            $goldcosts = get_module_setting("goldcosts") * get_module_setting("multiplicator");
            if (($gems > 0) || ($gold > 0)){
                if ($gold > 0){
                    if ($gold <= $session['user']['gold']){
                        $goldpaid= get_module_pref ("goldpaid");
                        if (($goldpaid + $gold) > $goldcosts){
                            $gold = $goldcosts - $goldpaid;
                        }
                        set_module_pref ("goldpaid", $goldpaid + $gold);
                        $session['user']['gold'] -= $gold;
                        output ("`3You paid `^%s`3 gold!`n", $gold);
                    }else{
                        output ("`3You don't have enough gold!`n");
                    }
                }
                if ($gems > 0){
                    if ($gems <= $session['user']['gems']){
                        $paidgems = get_module_pref ("gemspaid");
                        if (($paidgems + $gems) > $gemcosts){
                            $gems = $gemcosts - $paidgems;
                        }
                        set_module_pref ("gemspaid", get_module_pref ("gemspaid") + $gems);
                        $session['user']['gems'] -= $gems;
                        output ("`3You paid `%%s`3 gem%s!`n", $gems, translate_inline($gems > 1?"s":""));
                    }else{
                        output ("`3You don't have enough gems!`n");
                    }
                }
                if ((get_module_pref ("gemspaid") >= $gemcosts) &&
                    (get_module_pref ("goldpaid") >= $goldcosts)){
                    output ("`3Congratulations!`nYou successfully extended your house!");
                    set_module_pref ("goldpaid", 0);
                    set_module_pref ("gemspaid", 0);
                    set_module_pref ("housesize", get_module_pref ("housesize") + 1);
					$keyamnt++;
					set_module_pref("keyamnt",$keyamnt);
                }
            }else{
                output ("`3You have paid `^%s `3gold and `%%s `3gems.`n", get_module_pref ("goldpaid"), get_module_pref ("gemspaid"));
                output ("`3You need `^%s`3 gold and `%%s`3 gems to finish the extension of your house!`n", ($goldcosts-get_module_pref ("goldpaid")), ($gemcosts-get_module_pref ("gemspaid")));
                rawoutput ("<form action='runmodule.php?module=house&lo=house&id=$id&op=extend' method='POST'>");
                output ("Pay Gold:");
                rawoutput ("<input name='gold'>");
                output ("`nPay Gems:");
                rawoutput ("<input name='gems'>");
                rawoutput ("<br><input type='submit' class='button' value='".translate_inline("Pay")."'>");
                rawoutput ("</form>");
                addnav ("", "runmodule.php?module=house&lo=house&id=$id&op=extend");
            }
            addnav ("Return");
            addnav("Back to the House","runmodule.php?module=house&lo=house&id=$id&op=");
        break;
        case "welcome":
            if ($id != $session['user']['acctid']) redirect ("runmodule.php?module=house&lo=house&id=$id&op=");
            $welcome = httppost("welcome");
            if ($welcome == ""){
                output ("`3Here you can change your Estate Description:");
                rawoutput("<form action='runmodule.php?module=house&lo=house&id=$id&op=welcome' method='POST'>");
                rawoutput("<textarea name=\"welcome\" rows=\"10\" cols=\"60\" class=\"input\">".htmlentities(get_module_pref("welcometitle"))."</textarea>");
                rawoutput("<input type='submit' class='button' value='".translate_inline("Change")."'></form>");
            }else{
                output ("`3Your new Estate Description is:`n%s", $welcome);
                set_module_pref("welcometitle", $welcome);
            }
            addnav("Return");
            addnav("Back to the House","runmodule.php?module=house&lo=house&id=$id&op=");
            addnav ("", "runmodule.php?module=house&lo=house&id=$id&op=welcome");
        break;
        case "rename":
            if ($id != $session['user']['acctid']) redirect ("runmodule.php?module=house&lo=house&id=$id&op=");
            $name = httppost ("name");
            if ($name == ""){
                output ("`3A change of the houses name will cost `^%s`3 gold an `%%s`3 gems!`n",get_module_setting("renamecostsgold"),get_module_setting("renamecostsgems"));
                rawoutput("<form action='runmodule.php?module=house&lo=house&id=$id&op=rename' method='POST'>");
                output("`^New Name:");
                rawoutput("<input id='input' name='name' width=5> <input type='submit' class='button' value='".translate_inline("Rename")."'>");
                rawoutput("</form>");
                output("<script language='javascript'>document.getElementById('input').focus();</script>",true);
                addnav ("", "runmodule.php?module=house&lo=house&id=$id&op=rename");
            }else{
                if ($session['user']['gold'] < get_module_setting("renamecostsgold")){
                    output ("You need `^%s`3 gold to rename your house!", get_module_setting("renamecostsgold"));
                }elseif ($session['user']['gems'] < get_module_setting("renamecostsgems")){
                    output ("You need `%%s`3 gems to rename your house!", get_module_setting("renamecostsgems"));
                }else{
                    $sql = "UPDATE ".db_prefix("housekeys")." SET housename='$name' WHERE housename='".get_module_pref ("name")."'";
                    output ("You paid `^%s`3 gold and `%%s`3 gems.`n", get_module_setting("renamecostsgold"), get_module_setting("renamecostsgems"));
                    $session['user']['gold'] -= get_module_setting("renamecostsgold");
                    $session['user']['gems'] -= get_module_setting("renamecostsgems");
                    output ("The name of your house is now: `&%s", stripslashes($name));
                    set_module_pref ("name", $name);
					$sql = "UPDATE ".db_prefix("housekeys")." SET housename='$name' WHERE houseid='".$session['user']['acctid']."' AND ownerid !='".$session['user']['acctid']."'";
					db_query($sql);
                }
            }
            addnav("Return");
            addnav("Back to the House","runmodule.php?module=house&lo=house&id=$id&op=");
        break;
        case "givek":
            if ($id != $session['user']['acctid']) redirect ("runmodule.php?module=house&lo=house&id=$id&op=");
            $to = httppost("to");
            $nick = httppost("nick");
            if ($to != ""){
                $to = explode ("|", $to, 2);
                $sql = "SELECT ownerid FROM ".db_prefix("housekeys")." WHERE ownerid='".$to[0]."' AND houseid='".$id."'";
                $result = db_query($sql);
                if (db_num_rows ($result) == 0){
                    $sql = "INSERT INTO ".db_prefix("housekeys")." (ownerid, houseid, housename, location) VALUES ('".$to[0]."', '$id', ' ?".addslashes(get_module_pref("name"))."', '".get_module_pref("village")."')";
                    db_query($sql);
                    $thehousezone=get_module_pref("village");
                    $mailgivekeysubject = sprintf("You have been granted residence by %s.`0",$session['user']['name']);
                    $mailgivekeybody = sprintf("`^It appears as though you have been granted permission to live at %s`^ in %s!  You should have your key and you can drop by any time`n`n.",get_module_pref("name"),$thehousezone);
					$subject = translate_inline($mailgivekeysubject);
					$body = translate_inline($mailgivekeybody);
                    systemmail($to[0],$subject,$body.$session['user']['name']);
                    set_module_pref('keysgiven',get_module_pref('keysgiven')+1);
                    output("Your key will be delivered to that player.");
                    blocknav("runmodule.php?module=house&lo=house&id=$id&op=givek");
                }else{
                    output ("`3This Player already has a key to your house!");
                }
            }elseif ($nick != ""){
                $search="%";
                for ($x=0;$x<strlen($nick);$x++){
                    $search .= substr($nick,$x,1)."%";
                }
                $search=" AND name LIKE '".addslashes($search)."' ";
                $sql = "SELECT acctid,name,login FROM " . db_prefix("accounts") . " WHERE locked=0 $search ORDER BY level DESC, dragonkills DESC, login ASC $limit";
                $result = db_query($sql);
                if(db_num_rows($result)>=1){
                    rawoutput("<form action='runmodule.php?module=house&lo=house&id=$id&op=givek' method='POST'>");
                    output("`3Give a key to your house to");
                    $msg = translate_inline("Give");
                    rawoutput("<select name='to' class='input'>");
                    for ($i=0;$i<db_num_rows($result);$i++){
                        $row = db_fetch_assoc($result);
                        rawoutput("<option value=\"".HTMLEntities($row['acctid'])."|".HTMLEntities($row['name'])."\">".full_sanitize($row['name'])."</option>");
                    }
                    rawoutput("</select><input type='submit' class='button' value='$msg'></form>",true);
                }else{
                    output ("`3Sorry, but there is no player with that name.");
                }
            }else{
                $keysthatareleft=((get_module_pref('keyamnt')) - (get_module_pref('keysgiven')));
                output("You have %s keys left to give.  Who would you like to give one to?`n",$keysthatareleft);
                $search = translate_inline("Search by name: ");
                $search2 = translate_inline("Search");

                rawoutput("<form action='runmodule.php?module=house&lo=house&id=$id&op=givek' method='POST'>$search<input name='nick'><input type='submit' class='button' value='$search2'></form>");
            }
            addnav("Return");
            addnav("Back to the House","runmodule.php?module=house&lo=house&id=$id&op=");
            addnav("","runmodule.php?module=house&lo=house&id=$id&op=givek");
        break;
        case "withk":
            if ($id != $session['user']['acctid']) redirect ("runmodule.php?module=house&lo=house&id=$id&op=");
            $acc=httppost('acc');
            $nick=httppost('nick');
            if ($acc != ""){
                $sql = "DELETE FROM ".db_prefix("housekeys")." WHERE ownerid=$acc AND houseid=".$session['user']['acctid'];
                db_query($sql);
                output("`3You withdrew the Key to your House!");
                $subject = sprintf("%s has revoked your access to their home!", $session['user']['name']);
                $body = sprintf("`^It has been decided that you will no longer be able to stay at %s`^.  You will find you've already been relieved of your key.  If you feel this is in error, please mail the owner.", $session['user']['name'], get_module_pref("name"));
				$subject = translate_inline($subject);
				$body = translate_inline($body);
                systemmail($acc,$subject,$body);
                set_module_pref('keysgiven',get_module_pref('keysgiven')-1);
                if(get_module_pref('keysgiven')==0) blocknav("runmodule.php?module=house&lo=house&id=$id&op=withk");
            }else{
                output ("`6Flatmates:`&");
                $sql = "SELECT ownerid FROM ".db_prefix("housekeys")." WHERE houseid=$id";
                $result = db_query($sql);
                $sql = "SELECT acctid,name FROM ".db_prefix("accounts")." WHERE acctid=";
                while ($row = mysql_fetch_row ($result)) $sql .= $row[0]." OR acctid=";
                $sql = substr($sql, 0, -11);
                $result = db_query($sql);
                $i = 0;
                while ($row = mysql_fetch_array ($result)){
                    $i ++;
                    if ($row['acctid'] == $session['user']['acctid']) output_notl("`n$i. ".ereg_replace("`.","",$row['name']));
                    else
                    {
                        rawoutput("<br><form name='delete$i' action='runmodule.php?module=house&lo=house&id=$id&op=withk' method='POST'>");
                        rawoutput("<input type='hidden' name='nick' value='".$row['name']."'>");
                        rawoutput("<input type='hidden' name='acc' value='".$row['acctid']."'>");
                        rawoutput("$i. <a href='javascript:document.delete$i.submit();'>".ereg_replace("`.","",$row['name'])."</a></form>");
                    }
                }
                addnav("","runmodule.php?module=house&lo=house&id=$id&op=withk");
            }
            addnav("Return");
            addnav("Back to the House","runmodule.php?module=house&lo=house&id=$id&op=");
        break;
        case "goldw":
            $treasure = get_module_objpref("house", $id, "treasure", "house");
            if ($gold <= 0){
                if ($treasure != 0){
                    if ($golddone>=$goldwith){
                        output ("You cannot withdraw more than %s times a day!",$goldwith);
                    }else{
                        output("`3There is `^%s`3 gold in the chest`n", $treasure, true);
                        output("You are allowed to withdraw `6%s`3 times up to `^%s`3 gold at a time!", $goldwith - $golddone, $goldperlevel * $session['user']['level']);
                        rawoutput("<form action='runmodule.php?module=house&lo=house&id=$id&op=goldw' method='POST'>");
                        output("`^Withdraw how much?");
                        rawoutput("<input id='input' name='gold' width=5> <input type='submit' class='button' value='".translate_inline("Withdraw")."'>");
                        rawoutput("</form>");
                        rawoutput("<script language='javascript'>document.getElementById('input').focus();</script>",true);
                    }
                }else{
                    output("`\$There is no gold in the Chest!");
                }
            }else{
                $maxtfer = $session['user']['level']*$goldperlevel;
                if ($gold > $maxtfer){
                    $gold = $maxtfer;
                }
                if ($gold > $treasure){
                    $gold = $treasure;
                }
                output ("`3You withdrew `^%s`3 gold from the chest!", $gold);
                $session['user']['gold'] += $gold;
                set_module_objpref("house", $id, "treasure", $treasure - $gold,"house");
                $golddone++;
                set_module_pref("golddone",$golddone);
                $sql = "SELECT acctid FROM " . db_prefix("accounts") . " WHERE acctid=$id";
                $result = db_query ($sql);
                $row = db_fetch_assoc($result);
            if ($row['acctid'] != $session['user']['acctid']){
                $subject = sprintf("%s has Withdrawn Gold", $session['user']['name']);
                $body = sprintf("%s `3has withdrawn `^%s gold `3from your vault", $session['user']['name'], $gold);
				$subject = translate_inline($subject);
				$body = translate_inline($body);
                systemmail($row['acctid'],$subject,$body);
                }
            }
            addnav("Return");
            addnav("Back to the House","runmodule.php?module=house&lo=house&id=$id&op=");
            addnav("","runmodule.php?module=house&lo=house&id=$id&op=goldw");
        break;
        case "goldd":
            $treasure = get_module_objpref("house", $id, "treasure", "house");
            $maxdeposit = $session['user']['level']* $dgoldperlevel;
            if ($maxdeposit > (get_module_setting ("treasuresize") - $treasure)) $maxdeposit = get_module_setting ("treasuresize") - $treasure;
            if ($maxdeposit > $session['user']['gold']) $maxdeposit = $session['user']['gold'];
            if ($maxdeposit <= 0){
                output ("`3You are not able to deposit any more gold in the chest!");
            }else{
                if ($gold <= 0){
                    output("`3There is `^%s`3 gold in the chest`n", $treasure, true);
                    output("You are allowed to deposit up to `^%s`3 gold at a time!", $maxdeposit);
                    rawoutput("<form action='runmodule.php?module=house&lo=house&id=$id&op=goldd' method='POST'>");
                    output("`^Deposit how much?");
                    rawoutput("<input id='input' name='gold' width=5> <input type='submit' class='button' value='".translate_inline("Deposit")."'>");
                    rawoutput("</form>");
                    rawoutput("<script language='javascript'>document.getElementById('input').focus();</script>",true);
                }else{
                    if ($gold > $maxdeposit){
                        $gold = $maxdeposit;
                    }
                    output ("`3You deposit `^%s`3 gold into the chest!", $gold);
                    $session['user']['gold'] -= $gold;
                    set_module_objpref("house", $id, "treasure", $treasure + $gold,"house");
                    $sql = "SELECT acctid FROM " . db_prefix("accounts") . " WHERE acctid=$id";
                    $result = db_query ($sql);
                    $row = db_fetch_assoc($result);
                if ($row['acctid'] != $session['user']['acctid']){
                    $subject = sprintf("%s has deposited gold", $session['user']['name']);
                    $body = sprintf("%s `3has deposited `^%s gold `3into your vault", $session['user']['name'], $gold);
					$subject = translate_inline($subject);
					$body = translate_inline($body);
                    systemmail($row['acctid'],$subject,$body);
                }
                }
            }
            addnav("Return");
            addnav("Back to the House","runmodule.php?module=house&lo=house&id=$id&op=");
            addnav("","runmodule.php?module=house&lo=house&id=$id&op=goldd");
        break;
        case "gemsw":
            $gemtreasure = get_module_objpref("house", $id, "gemtreasure", "house");
            if ($gems <= 0){
                if ($gemtreasure != 0){
                    if ($session['user']['transferredtoday']>=$gemwith){
                        output ("`3You cannot withdraw more than %s times a day!", $gemwith);
                    }else{
                        output("`3There are `^%s`3 gems in the chest`n", $gemtreasure, true);
                        output("You are allowed to withdraw `6%s`3 times up to `^%s`3 gems at a time!",  $gemwith - $gemdone, $gemperlevel * $session['user']['level']);
                        rawoutput("<form action='runmodule.php?module=house&lo=house&id=$id&op=gemsw' method='POST'>");
                        output("`^Withdraw how much?");
                        rawoutput("<input id='input' name='gems' width=5> <input type='submit' class='button' value='".translate_inline("Withdraw")."'>");
                        rawoutput("</form>");
                        rawoutput("<script language='javascript'>document.getElementById('input').focus();</script>",true);
                    }
                }else{
                    output("`\$There are no gems in the chest!");
                }
            }else{
                $maxtfer = $session['user']['level']*$gemperlevel;
                if ($gems > $maxtfer){
                    $gems = $maxtfer;
                }
                if ($gems > $gemtreasure){
                    $gems = $gemtreasure;
                }
                output ("`3You withdrew `^%s`3 gems from the chest!", $gems);
                $session['user']['gems'] += $gems;
                set_module_objpref("house", $id, "gemtreasure", $gemtreasure - $gems,"house");
                $gemdone ++;
                set_module_pref("gemdone",$gemdone);
                $sql = "SELECT acctid FROM " . db_prefix("accounts") . " WHERE acctid=$id";
                $result = db_query ($sql);
                $row = db_fetch_assoc($result);
            if ($row['acctid'] != $session['user']['acctid']){
                $subject = sprintf("%s has Withdrawn Gems", $session['user']['name']);
                $body = sprintf("%s `3has withdrawn `^%s gems `3from your vault", $session['user']['name'], $gems);
				$subject = translate_inline($subject);
				$body = translate_inline($body);
                systemmail($row['acctid'],$subject,$body);
                }
            }
            addnav("Return");
            addnav("Back to the House","runmodule.php?module=house&lo=house&id=$id&op=");
            addnav("","runmodule.php?module=house&lo=house&id=$id&op=gemsw");
        break;
        case "gemsd":
            $gemtreasure = get_module_objpref("house", $id, "gemtreasure", "house");
            $maxdeposit = $session['user']['level']*$dgemperlevel;
            if ($maxdeposit > (get_module_setting ("maxgems") - $gemtreasure)) $maxdeposit = get_module_setting ("maxgems") - $gemtreasure;
            if ($maxdeposit > $session['user']['gems']) $maxdeposit = $session['user']['gems'];
            if ($maxdeposit <= 0){
                output ("You are not able to deposit any more gems into the chest!");
            }else{
                if ($gems <= 0){
                    output("`3There are `^%s`3 gems in the chest`n", $gemtreasure, true);
                    output("You are allowed to deposit up to `^%s`3 gems at a time!", $maxdeposit);
                    rawoutput("<form action='runmodule.php?module=house&lo=house&id=$id&op=gemsd' method='POST'>");
                    output("`^Deposit how much?");
                    rawoutput("<input id='input' name='gems' width=5> <input type='submit' class='button' value='".translate_inline("Deposit")."'>");
                    rawoutput("</form>");
                    rawoutput("<script language='javascript'>document.getElementById('input').focus();</script>",true);
                }else{
                    if ($gems > $maxdeposit){
                        $gems = $maxdeposit;
                    }
                    output ("`3You deposited `^%s`3 gems into the chest!", $gems);
                    $session['user']['gems'] -= $gems;
                    set_module_objpref("house", $id, "gemtreasure", $gemtreasure + $gems,"house");
                    $sql = "SELECT acctid FROM " . db_prefix("accounts") . " WHERE acctid=$id";
                    $result = db_query ($sql);
                    $row = db_fetch_assoc($result);
                if ($row['acctid'] != $session['user']['acctid']){
                    $subject = sprintf("%s has Deposited Gems", $session['user']['name']);
                    $body = sprintf("%s `3has deposited `^%s gems `3into your vault", $session['user']['name'], $gems);
					$subject = translate_inline($subject);
					$body = translate_inline($body);
                    systemmail($row['acctid'],$subject,$body);
                }
                }
            }
            addnav("Return");
            addnav("Back to the House","runmodule.php?module=house&lo=house&id=$id&op=");
            addnav("","runmodule.php?module=house&lo=house&id=$id&op=gemsd");
        break;
        case "wakeup":
            $session['user']['alive'] = 1;
            $session['user']['location'] = get_module_pref("village","house",$id);
        default:
            output_notl ("`&`c%s`c`3`n", stripslashes(get_module_pref("welcometitle", "house", $id)));
            output("`3The clock on your mantle reads `^%s`@.`n", getgametime());
            $secstonewday = secondstonextgameday();
			output("`@Next new game day in: `$%s`0`n`n",
			date("G \\h\\o\\u\\r\\s, i \\m\\i\\n\\u\\t\\e\\s \\a\\n\\d s \\s\\e\\c\\o\\n\\d\\s",	$secstonewday));
            if (get_module_setting("enabletreasure")==1) output("`3There is `^%s`3 gold in the chest`n`n", get_module_objpref("house", $id, "treasure", "house"), true);
            if (get_module_setting("enablegems")==1) output("`3There are `%%s`3 gems in the chest`n`n", get_module_objpref("house", $id, "gemtreasure", "house"), true);
                addcommentary();
                viewcommentary ("House - ".$id, "Speak", 25, "says");
            if (get_module_setting("enablekeys")) {
                output ("`6`nFlatmates:`n");
                $sql = "SELECT ownerid FROM ".db_prefix("housekeys")." WHERE houseid=$id";
                $result = db_query($sql);
                $sql = "SELECT name FROM ".db_prefix("accounts")." WHERE acctid=";
                while ($row = mysql_fetch_array ($result)) $sql .= $row['ownerid']." OR acctid=";
                $sql = substr($sql, 0, -11);
                $result = db_query($sql);
                $i = 0;
                while ($row = mysql_fetch_row ($result)){
                    $i ++;
                    output_notl ("`&%s. %s`n", $i, $row[0]);
                }
            }
        break;
        }
    }else{
        output ("`&`c`bOther Houses`b`c`3`n");
        output ("Error! This house doesn't exist anymore!");
        $sql = "DELETE FROM ".db_prefix("housekeys")." WHERE houseid='".$id."' OR ownerid='".$id."'";
        db_query($sql);
        villagenav();
    }
}
function house_build(){
    global $session;
    page_header(array("The residential area of %s", $session['user']['location']));
    $hname = httppost ("housename");
    $goldpay = httppost ("gold");
    $gemspay = httppost ("gems");

    output ("`&`c`bBuilding a House`b`c`3`n");

    if (get_module_pref("name") == ""){
        if ($hname == ""){
            addnav ("", "runmodule.php?module=house&lo=buildhouse");
            output ("`3You don't have a house so you should start building one right now!`n");
            output ("Please type in a name for your house:`n");
            rawoutput ("<form action='runmodule.php?module=house&lo=buildhouse' method='POST'>");
            rawoutput ("<input name='housename'>");
            rawoutput ("<input type='submit' class='button' value='".translate_inline("Submit")."'>");
            rawoutput ("</form>");
        }else{
            set_module_pref("name", $hname);
            set_module_pref("village", $session['user']['location']);
            output ("You started building a house!`nPlease come again to pay the costs of the house.");
        }
    }else{
        if (get_module_pref("village") == $session['user']['location']){
            if (($gemspay > 0) || ($goldpay > 0)){
                if ($goldpay > 0){
                    if ($goldpay <= $session['user']['gold']){
                        $goldpaid = get_module_pref ("goldpaid");
                        if (($goldpaid + $goldpay) > get_module_setting ("goldcosts")){
                            $goldpay = get_module_setting ("goldcosts") - $goldpaid;
                        }
                        set_module_pref ("goldpaid", $goldpaid + $goldpay);
                        $session['user']['gold'] -= $goldpay;
                        output ("`3You paid `^%s`3 gold!`n", $goldpay);
                    }else{
                        output ("`3You don't have enough gold!`n");
                    }
                }
                if ($gemspay > 0){
                    if ($gemspay <= $session['user']['gems']){
                        $paidgems = get_module_pref ("gemspaid");
                        if (($paidgems + $gemspay) > get_module_setting ("gemcosts")){
                            $gemspay = get_module_setting ("gemcosts") - $paidgems;
                        }
                        set_module_pref ("gemspaid", get_module_pref ("gemspaid") + $gemspay);
                        $session['user']['gems'] -= $gemspay;
                        output ("`3You paid `%%s`3 gems!`n", $gemspay);
                    }else{
                        output ("`3You don't have enough gems!`n");
                    }
                }
                if ((get_module_pref ("gemspaid") >= get_module_setting("gemcosts")) &&
                (get_module_pref ("goldpaid") >= get_module_setting("goldcosts"))){
                    output ("Congratulations! You have finished your house!");
                    set_module_pref ("goldpaid", 0);
                    set_module_pref ("gemspaid", 0);
                    set_module_pref ("housesize", 1);
                    $sql = "INSERT INTO ".db_prefix("housekeys")." (ownerid, houseid, housename, location) VALUES ('".$session['user']['acctid']."', '".$session['user']['acctid']."', '', '".get_module_pref("village")."')";
                    db_query($sql);
                    addnav ("Own House");
                    addnav ("My House", "runmodule.php?module=house&lo=house&id=".$session['user']['acctid']);
                    addnav ("Sell House", "runmodule.php?module=house&lo=sellhouse");
                    blocknav ("runmodule.php?module=house&lo=buildhouse");
                    addnews ("`%%s`3 has finished the house `&%s`3!",$session['user']['name'],stripslashes(get_module_pref("name")));
                }
            }else{
                output ("`3You have paid `^%s`3 gold and `%%s`3 gems.`n", get_module_pref ("goldpaid"), get_module_pref ("gemspaid"));
                output ("`3You need `^%s`3 gold and `%%s`3 gems to finish your house!`n", (get_module_setting ("goldcosts")-get_module_pref ("goldpaid")), (get_module_setting ("gemcosts")-get_module_pref ("gemspaid")));
                rawoutput ("<form action='runmodule.php?module=house&lo=buildhouse' method='POST'>");
                output ("Pay Gold:");
                rawoutput ("<input name='gold'>");
                output ("`nPay Gems:");
                rawoutput ("<input name='gems'>");
                rawoutput ("<br><input type='submit' class='button' value='".translate_inline("Pay")."'>");
                rawoutput ("</form>");
                addnav ("", "runmodule.php?module=house&lo=buildhouse");
            }
        }else{
            output ("`3Sorry, but you already started to build a house in another village!");
        }
    }
}
function house_sell(){
    global $session;
	$id = $session['user']['acctid'];
    page_header(array("The residential area of %s", $session['user']['location']));
    $op = httpget("op");

    output ("`&`c`bSelling your House`b`c`3`n");

    $gemsget = get_module_setting("gemcosts")/2 + get_module_setting("gemcosts") * (get_module_pref ("housesize") - 1) * get_module_setting ("multiplicator");
    $goldget = get_module_setting("goldcosts")/2 + get_module_setting("goldcosts") * (get_module_pref ("housesize") - 1) * get_module_setting ("multiplicator");
    if ($op == "yes"){
        $sql = "DELETE FROM ".db_prefix("housekeys")." WHERE houseid=".$session['user']['acctid']."";
		db_query($sql);
        $session['user']['gold'] += $goldget;
        $session['user']['gems'] += $gemsget;
        set_module_pref ("name", "");
        set_module_pref ("welcometitle", "");
        set_module_pref ("village", "");
        set_module_pref ("treasure", 0);
        set_module_pref ("goldpaid", 0);
        set_module_pref ("gemspaid", 0);
        set_module_pref ("housesize", 0);
		set_module_pref ("keysgiven", 0);
		set_module_pref ("keyamnt", 0);
		set_module_objpref("house", $id, "treasure", 0,"house");
		set_module_objpref("house", $id, "gemtreasure", 0,"house");
        output ("`3You got `^%s`3 gold and `%%s`3 gems for your House", $goldget, $gemsget);
        db_query("DELETE FROM ".db_prefix("commentary")." WHERE section='House - ".$id."'");
        blocknav ("runmodule.php?module=house&lo=house&id=".$session['user']['acctid']);
        blocknav ("runmodule.php?module=house&lo=sellhouse");
    }else{
        output ("You would get `^%s`3 gold and `%%s`3 gems for your house!`n", $goldget, $gemsget);
        output ("Do you really want to sell it?`n");
		rawoutput("<big>");
		output ("`bYou will also lose all of your Gold and Gems in your Treasure boxes.`b");
		rawoutput("</big>");
        blocknav ("runmodule.php?module=house&lo=house&id=".$session['user']['acctid']);
        blocknav ("runmodule.php?module=house&lo=sellhouse");
        blocknav ("runmodule.php?module=house&lo=buildhouse");
        blocknav ("runmodule.php?module=house");
        blocknav ("village.php");
        addnav ("Sure?");
        addnav ("Yes", "runmodule.php?module=house&lo=sellhouse&op=yes");
        addnav ("No", "runmodule.php?module=house&op=");
    }
}
?>