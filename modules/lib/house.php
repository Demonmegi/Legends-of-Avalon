<?php
    global $session;
	$points = $session['user']['donation'];
    page_header(array("The residential area of %s", $session['user']['location']));
    require_once "lib/villagenav.php";
	require_once "modules/lib/house_func.php";
    checkday();
    if (get_module_pref("housesize") > 0){
        if ($session['user']['location'] == get_module_pref("village")){
            addnav ("Own House");
            addnav ("My House", "runmodule.php?module=house&lo=house&id=".$session['user']['acctid']);
            addnav ("Sell House", "runmodule.php?module=house&lo=sellhouse");
        }else{
            addnav ("", "runmodule.php?module=house&lo=house&id=".$session['user']['acctid']);
            addnav ("", "runmodule.php?module=house&lo=sellhouse");
        }
        addnav ("", "runmodule.php?module=house&lo=buildhouse");
    }else{
        if ($session['user']['dragonkills'] >= get_module_setting ("mindks") && $points >= get_module_setting("doncost")){
            addnav ("Own House");
            addnav ("Build House", "runmodule.php?module=house&lo=buildhouse");
        }else{
            addnav ("", "runmodule.php?module=house&lo=buildhouse");
        }
        addnav ("", "runmodule.php?module=house&lo=house");
        addnav ("", "runmodule.php?module=house&lo=sellhouse");
    }
    modulehook("housenavs");
    $loc = httpget("lo");
    if ($loc == ""){
        $sql = "SELECT * FROM ".db_prefix("housekeys")." WHERE ownerid=".$session['user']['acctid']." AND location='".$session['user']['location']."'";
        $result = db_query($sql);
        $rownumber = mysql_num_rows ($result);
        $i = 0;
        $row = array();
        while ($row[$i] = mysql_fetch_row($result)) $i++;
        if ($rownumber > 0){
            addnav ("Other Houses");
            for ($i = 0; $i < $rownumber; $i++){
                addnav (stripslashes($row[$i][2]), "runmodule.php?module=house&lo=house&id=".$row[$i][1]);
            }
        }
    }
    switch ($loc){
        case "house":
            house();
        break;
        case "buildhouse":
            page_header(array("The residential area of %s", $session['user']['location']));
            house_build();
        break;
        case "sellhouse":
            page_header(array("The residential area of %s", $session['user']['location']));
            house_sell();
        break;
        default:
            page_header(array("The residential area of %s", $session['user']['location']));
            output ("`&`c`bResidential Quarter`b`c`3`n");
            output ("`3You start off down a long street.  A `ilong`i street.  Gosh, this is a long street.  What could such a long street be for?`n`n");
            house_appraise();
            $sql = "SELECT count(userid) AS c FROM ".db_prefix("module_userprefs")." WHERE modulename='house' AND setting='village' AND value='".$session['user']['location']."'";
            $result = db_query ($sql);
            $row = db_fetch_assoc($result);
            $totalhouses = $row['c'];
            $housesperpage = get_module_setting("housesperpage");

            $page = (int)httpget('page');
            if ($page == 0) $page = 1;
            $pageoffset = $page;
            if ($pageoffset > 0) $pageoffset--;
            $pageoffset *=$housesperpage;
            $limit = $pageoffset.",".$housesperpage;
            addnav("Pages");
            for($i = 0; $i < $totalhouses; $i+= $housesperpage) {
                $pnum = ($i/$housesperpage+1);
                $min = ($i+1);
                $max = min($i+$housesperpage,$totalhouses);
                addnav(array("Page %s (%s-%s)", $pnum, $min, $max), "runmodule.php?module=house&page=$pnum");
            }

            $sql = "SELECT userid FROM ".db_prefix("module_userprefs")." WHERE modulename='house' AND setting='village' AND value='".$session['user']['location']."' LIMIT $limit";
            $result = db_query ($sql);
            $i = 0;
            $housename = get_module_pref("name");
            $houseinvillage = get_module_pref("village");
            $housesize = get_module_pref("housesize");
            if (db_num_rows ($result) > 0) {
                output ("`3A mish-mash of homes of different shapes and sizes extends down the street as far as you can see, this arouses your interest somewhat.");
				output("`n`nEach house has a label on the side indicating the name of both Estate and owner.`n`n");
                if ($session['user']['location'] == get_module_pref("village")){
            if ($housename != "") {
                    output ("After walking for a little, you spot your own house, `^%s`3,", stripslashes($housename));
                    if ($housesize >= 8) output ("`3which is nothing short of a marvel, a pinnacle of house design.  Your home is a veritable Adonis of architecture.  You take a moment to bask in its Godliness.`n`n");
                    elseif ($housesize >= 6) output ("`3which is a sight indeed, you often hear people regard its grandeur with jealousy and you can see why!  Yours is a truly beautiful home.`n`n");
                    elseif ($housesize >= 3) output ("`3which is quite magnificent and stands pridefully amongst the others, yours is a home to be proud of.`n`n");
                    elseif ($housesize == 2) output ("`3which appears to be a modest family house at best, it's home but still it's nothing to write home about.`n`n");
                    elseif ($housesize == 1) output ("`3which in comparison to some of the other houses here is nothing more than a hut!  A bungalow at best.`n`n");
                }
            }
			}else{ output ("`3After walking for a while you decide quite assuredly that there's simply nothing here!");
			output(" You're most perplexed by this lack of anything, the openness of this road almost scares you.");
			output(" Perhaps it's best to simply go back to %s Central for now.", $session['user']['location']);
			}
            $number = translate_inline("Number");
            $name = translate_inline("Name");
            $owner = translate_inline("Owner");
            $size = translate_inline("House Size");
            $location = translate_inline("Location");

            rawoutput("<table border='1' cellpadding='3' cellspacing='0'>");
            rawoutput("<tr class='trhead'><td>$number</td><td>$name</td><td>$owner</td><td>$location</td><td>$size</td></tr>");
            while ($row = db_fetch_assoc($result)) {
                $i ++;
                rawoutput("<tr class='".($i%2?"trlight":"trdark")."'>");
                rawoutput("<td>$i</td><td>");
                output_notl(stripslashes(get_module_pref("name","house",$row['userid'])));
                rawoutput("</td><td>");
                $sql = "SELECT name FROM ".db_prefix("accounts")." WHERE acctid=".$row['userid'];
                $result2 = db_query ($sql);
                $row2 = db_fetch_assoc($result2);
                output_notl($row2['name']);
                rawoutput ("</td><td>".get_module_pref("village","house",$row['userid']));
                $housesize = get_module_pref("housesize","house",$row['userid']);
                rawoutput ("</td><td>");
                if ($housesize > 0) output_notl("$housesize");
                else output("`6In Construction");
                rawoutput("</td></tr>");
            }
            rawoutput("</table>");

            if ($session['user']['dragonkills'] < get_module_setting ("mindks")){
				rawoutput("<big>");
                output ("`n`3You need at least `5%s`3 Dragonkills to build a house!", get_module_setting ("mindks"));
				rawoutput("</big>");
            }
            blocknav ("runmodule.php?module=house");
        break;
    }
    modulehook ("houseroomshook");
    addnav ("Return");
    addnav ("Back to the Residential Quarter", "runmodule.php?module=house");
    villagenav();
    page_footer();
?>