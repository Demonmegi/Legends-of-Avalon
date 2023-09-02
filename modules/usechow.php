<?php
//0.9.7 to 0.9.8 conversion Frederic Hutow
//contribs - mprowler
function usechow_getmoduleinfo(){
	$info = array(
		"name"=>"Use Chow",
		"version"=>"1.53",
		"author"=>"`3Lonny Luberts",
		"category"=>"PQcomp",
		"download"=>"http://www.pqcomp.com/modules/mydownloads/visit.php?cid=3&lid=38",
		"vertxtloc"=>"http://www.pqcomp.com/",
		"prefs"=>array(
			"Use Chow Module User Preferences,title",
			"chow"=>"Chow Representation,int|12367",
			"hunger"=>"Hunger Level,int|0",
			"restrict"=>"Restrict Chow Use on Current Page,bool|0",
			"restorepage"=>"Restore Page,viewonly",
		),
		"settings"=>array(
			"Use Chow Module Settings,title",
			"newday"=>"Hunger Increase on New Day,int|10",
			"battle"=>"Hunger Increase in Battle,int|1",
		),
	);
	return $info;
}

function usechow_install(){
	if (!is_module_active('usechow')){
		output("`4Installing Use Chow Module.`n");
	}else{
		output("`4Updating Use Chow Module.`n");
	}
	module_addhook("charstats");
	module_addhook("dragonkill");
	module_addhook("newday");
	module_addhook("village");
	module_addhook("everyhit");
	module_addhook("battle-victory");
	module_addhook("battle-defeat");
	module_addeventhook("forest", "return 100;");
	module_addeventhook("travel", "return 25;");
	return true;
}

function usechow_uninstall(){
	output("`4Un-Installing Use Chow Module.`n");
	return true;
}

function usechow_runevent($type){
		$uchow  = get_module_pref("chow");
		for ($i=0;$i<6;$i+=1){
		$chow[$i]=substr(strval($uchow),$i,1);
		if ($chow[$i] > 0) $userchow++;
		}
		if ($userchow<5){
		switch(e_rand(1,7)){
		case 1:
		rawoutput("<a><img src=\"./images/bread.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\"></a>");
		output("`^Fortune smiles on you and you find a slice of bread!`0");
		for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="1";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
		break;
		case 2:
		rawoutput("<a><img src=\"./images/pork.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\"></a>");
		output("`^Fortune smiles on you and you find a Pork Chop!`0");
		for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="2";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
		break;
		case 3:
		rawoutput("<a><img src=\"./images/ham.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\"></a>");
		output("`^Fortune smiles on you and you find a Ham Steak!`0");
		for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="3";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
		break;
		case 4:
		rawoutput("<a><img src=\"./images/steak.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\"></a>");
		output("`^Fortune smiles on you and you find a Steak!`0");
		for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="4";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
		break;
		case 5:
		rawoutput("<a><img src=\"./images/chicken.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\"></a>");
		output("`^Fortune smiles on you and you find a Whole Chicken!`0");
		for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="5";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
		break;
		case 6:
		rawoutput("<a><img src=\"./images/milk.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\"></a>");
		output("`^Fortune smiles on you and you find a bottle of milk!`0");
		for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="6";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
		break;
		case 7:
		rawoutput("<a><img src=\"./images/water.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\"></a>");
		output("`^Fortune smiles on you and you find a bottle of Water!`0");
		for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="7";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
		break;
		}
		set_module_pref('chow',$newchow,'usechow');
		}else{
			if ($type == "forest"){
				redirect("forest.php?op=search");
			}else{
				redirect("runmodule.php?module=cities&op=travel");
			}
		}
}

function usechow_dohook($hookname,$args){
	global $session;
	switch($hookname){
	case "battle-victory":
		global $session;
		if ($session['user']['alive']){
			set_module_pref('hunger', get_module_pref('hunger') + get_module_setting('battle'));
		}
	break;
	case "battle-defeat":
		global $session;
		if ($session['user']['alive']){
			set_module_pref('hunger', get_module_pref('hunger') + get_module_setting('battle'));
		}
	break;
	case "charstats":
		global $session,$SCRIPT_NAME;
		if ($session['user']['alive'] == 1){
			$currentpage = $SCRIPT_NAME;
			$currentpage2 = "";
			$argspq = $_SERVER['argv'];
			for ($i=0;$i<$_SERVER['argc'];$i+=1){
			    if (strchr($argspq[$i],"&c=")) $argspq[$i] = str_replace(strstr($argspq[$i],"&c="),"",$argspq[$i]);
			    $currentpage2.=$argspq[$i];
			}
			if (strstr($currentpage2,"worldmapen")) $currentpage = "runmodule.php?module=worldmapen&op=continue";
			
			if (get_module_pref('restrict')) {
				$restrict = true;
				set_module_pref('restrict', 0);
			} else {
				set_module_pref('restorepage', $currentpage);
				$restrict = false;
			}
			
			global $badguy;
			$uchow = get_module_pref('chow');
			$chow = "";
			$mychow = array();
			for ($i=0;$i<6;$i+=1){
				if ($uchow>$i){
					$mychow[$i]=substr(strval($uchow),$i,1);
					if ($badguy['creaturehealth'] > 0 or $session['user']['alive']==0 or strstr($currentpage, "newday") or strstr($currentpage, "bio") or strstr($currentpage, "dragon") or (strstr($currentpage, "runmodule") and !strstr($currentpage, "worldmapen")) or $restrict){
						if ($mychow[$i]=="1") $chow.="<img src=\"./images/bread.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\">";
						if ($mychow[$i]=="2") $chow.="<img src=\"./images/pork.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\">";
						if ($mychow[$i]=="3") $chow.="<img src=\"./images/ham.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\">";
						if ($mychow[$i]=="4") $chow.="<img src=\"./images/steak.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\">";
						if ($mychow[$i]=="5") $chow.="<img src=\"./images/chicken.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\">";
						if ($mychow[$i]=="6") $chow.="<img src=\"./images/milk.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\">";
						if ($mychow[$i]=="7") $chow.="<img src=\"./images/water.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\">";
					}else{
						if ($mychow[$i]=="1"){
							$chow.="<a href=\"runmodule.php?module=usechow&op=eat&act=bread\"><img src=\"./images/bread.gif\" title=\"\" alt=\"\" style=\"border: 0px solid ; width: 14px; height: 16px;\"></a>";
							addnav("","runmodule.php?module=usechow&op=eat&act=bread");
						}
						if ($mychow[$i]=="2"){
							$chow.="<a href=\"runmodule.php?module=usechow&op=eat&act=pork\"><img src=\"./images/pork.gif\" title=\"\" alt=\"\" style=\"border: 0px solid ; width: 14px; height: 16px;\"></a>";
							addnav("","runmodule.php?module=usechow&op=eat&act=pork");
						}
						if ($mychow[$i]=="3"){
							$chow.="<a href=\"runmodule.php?module=usechow&op=eat&act=ham\"><img src=\"./images/ham.gif\" title=\"\" alt=\"\" style=\"border: 0px solid ; width: 14px; height: 16px;\"></a>";
							addnav("","runmodule.php?module=usechow&op=eat&act=ham");
						}
						if ($mychow[$i]=="4"){
							$chow.="<a href=\"runmodule.php?module=usechow&op=eat&act=steak\"><img src=\"./images/steak.gif\" title=\"\" alt=\"\" style=\"border: 0px solid ; width: 14px; height: 16px;\"></a>";
							addnav("","runmodule.php?module=usechow&op=eat&act=steak");
						}
						if ($mychow[$i]=="5"){
							$chow.="<a href=\"runmodule.php?module=usechow&op=eat&act=chicken\"><img src=\"./images/chicken.gif\" title=\"\" alt=\"\" style=\"border: 0px solid ; width: 14px; height: 16px;\"></a>";
							addnav("","runmodule.php?module=usechow&op=eat&act=chicken");
						}
						if ($mychow[$i]=="6"){
							$chow.="<a href=\"runmodule.php?module=usechow&op=eat&act=milk\"><img src=\"./images/milk.gif\" title=\"\" alt=\"\" style=\"border: 0px solid ; width: 14px; height: 16px;\"></a>";
							addnav("","runmodule.php?module=usechow&op=eat&act=milk");
						}
						if ($mychow[$i]=="7"){
							$chow.="<a href=\"runmodule.php?module=usechow&op=eat&act=water\"><img src=\"./images/water.gif\" title=\"\" alt=\"\" style=\"border: 0px solid ; width: 14px; height: 16px;\"></a>";
							addnav("","runmodule.php?module=usechow&op=eat&act=water");
						}
					}
				}else{
					$chow.="<img src=\"./images/potionclear.gif\" title=\"\" alt=\"\" style=\"width: 14px; height: 16px;\">";
				}
			}
			$len=0;
		    $len2=0;
		    $max=160;
		    $hungerval = get_module_pref('hunger');
		    for ($i=0;$i<$max/2;$i+=1){
		    if ($hungerval>$i) $len+=2;
		    }
		    $pct = round($len / $max * 100, 0);
		    $nonpct = 100-$pct;
		    if ($pct > 100) {
		    $pct = 100;
		    $nonpct = 0;
		    } elseif ($pct < 0) {
		    $pct = 0;
		    $nonpct = 100;
		    }
		    $color = "`2";
		    $barcolor = "#269A26";
		    $barbgcol = "#777777";
		    $hunger = "";
		    $hunger .= "`b$color$pct%`b";
		    $hunger .= "<br />";
		    $hunger .= "<table style='border: solid 1px #000000' bgcolor='$barbgcol' cellpadding='0' cellspacing='0' width='70' height='5'><tr><td width='$pct%' bgcolor='$barcolor'></td><td width='$nonpct%'></td></tr></table>";
		    setcharstat("Vital Info","Hunger",$hunger);
			setcharstat("Click and use Items","Chow", $chow);
		}
		break;
	case "dragonkill":
		set_module_pref('chow', 12367);
		set_module_pref('hunger', 0);
		break;
	case "newday":
		set_module_pref('hunger', get_module_pref('hunger') + get_module_setting('newday'));
		break;
	case "village":
		tlschema($args['schemas']['tavernnav']);
    	addnav($args['tavernnav']);
    	tlschema();
		addnav("Draco's Diner", "runmodule.php?module=usechow&op=inn");
		break;
	case "everyhit":
		if ($session['user']['alive']==1){
	 	if (get_module_pref('hunger')>160){
			if (get_module_pref('hunger')>200){
			output("<big>`4`c`bYou are starving to death!`0`b`c</big>",true);
			$session['user']['hitpoints']*=.95;
			}else{
			output("<big>`4`c`bYou are very Hungry!`0`b`c</big>",true);
			}
		}
		}
	break;
	}
	return $args;
}

function usechow_run(){
	global $session;

	$op = httpget('op');
	$act = httpget('act');

	set_module_pref('restrict', 1);
	if (is_module_active('potions')) {
		set_module_pref('restrict', 1, 'potions');
	}

	if ($op == "inn") {
		usechow_inn($act);
		return;
	}

	$uchow  = get_module_pref("chow");
	$uhunger = get_module_pref("hunger");

	page_header("Chow");
	
	$chow = array();
	for ($i=0;$i<6;$i+=1){
		$chow[$i]=substr(strval($uchow),$i,1);
	}
	
	if ($uhunger > -10) {
		if ($act == "bread"){
			output("`c`b`&Eat a Piece of Bread`0`b`c`n`n");
			$usedchow=1;
			output("You wolf down the bread leaving not a crumb!`n");
			set_module_pref('hunger', $uhunger - 15);
			$potty=1;
		}
		if ($act == "pork"){
			output("`c`b`&Eat a Pork Chop`0`b`c`n`n");
			$usedchow=2;
			output("You wolf down the Pork Chop!`n");
			set_module_pref('hunger', $uhunger - 22);
			$potty=2;
		}
		if ($act == "ham"){
			output("`c`b`&Eat a Ham Steak`0`b`c`n`n");
			$usedchow=3;
			output("You wolf down the Ham Steak!`n");
			set_module_pref('hunger', $uhunger - 30);
			$potty=2;
		}
		if ($act == "steak"){
			output("`c`b`&Eat a Steak`0`b`c`n`n");
			$usedchow=4;
			output("You wolf down the Steak!`n");
			set_module_pref('hunger', $uhunger - 43);
			$potty=3;
		}
		if ($act == "chicken"){
			output("`c`b`&Eat a Chicken`0`b`c`n`n");
			$usedchow=5;
			output("You wolf down the Entire Chicken!`n");
			set_module_pref('hunger', $uhunger - 50);
			$potty=3;
		}
		if ($act == "milk"){
			output("`c`b`&Drink a milk`0`b`c`n`n");
			$usedchow=6;
			output("You guzzle the Milk!`n");
			set_module_pref('hunger', $uhunger - 12);
			$potty=4;
		}
			if ($act == "water"){
			output("`c`b`&Drink a Water`0`b`c`n`n");
			$usedchow=7;
			output("You guzzle the Water!`n");
			set_module_pref('hunger', $uhunger - 6);
			$potty=4;
		}
		if (is_module_active('bladder')) {
				set_module_pref("bladder", (get_module_pref("bladder","bladder") + $potty),"bladder");
			}
	} else {
		output("`c`b`&You are way too full to eat or drink any more!`0`b`c`n`n");
	}
	
	$rp = get_module_pref('restorepage');
	
	$x = max(strrpos("&",$rp),strrpos("?",$rp));
	if ($x>0) $rp = substr($rp,0,$x);
	if (substr($rp,0,10)=="badnav.php" or substr($rp,0,10)=="newday.php"){
		addnav("Continue","village.php");
	}else{
		addnav("Continue",preg_replace("'[?&][c][=].+'","",$rp));
	}
	$newchow = "";
	for ($i=0;$i<6;$i+=1){
		if ($usedchow<>""){
			if ($usedchow==$chow[$i]){
				$usedchow="";
				$chow[$i]="";
			}
		}
		$newchow.=$chow[$i];
	}
	$newchow.="0";
	set_module_pref('chow', $newchow);
	//I cannot make you keep this line here but would appreciate it left in.
	output("`n`n");
	rawoutput("<div style=\"text-align: left;\"><a href=\"http://www.pqcomp.com\" target=\"_blank\">Chow by Lonny @ http://www.pqcomp.com</a><br>");
	page_footer();
}

function usechow_inn($act) {
	global $session;

	$uchow  = get_module_pref("chow");
	$uhunger = get_module_pref("hunger");

	checkday();
	page_header("Draco's Diner");
	output("`c`b`&Draco's Diner`0`b`c`n`n");
	modulehook("usechow",$texts);
	$chow = array();
	for ($i=0;$i<6;$i+=1){
		$chow[$i]=substr($uchow,$i,1);
		if ($chow[$i] > 0) $userchow+=1;
	}
	$pricebase=$session['user']['dragonkills']*2;
	if ($op == "" and $act == "") {
		output("`2Here is a place to satisfy those pangs in your tummy.  The Diner is named after the");
		output("great flaming dragon found in these parts.  You sit down and look at the menu.`n");
		output("`b`c-=-=-=MENU=-=-=-`c`b`n");
		output("`cBread..........%s gold pieces`c",($pricebase+15));
		output("`cPork Chops...........%s gold pieces`c",($pricebase+25));
		output("`cHam Steak..........%s gold pieces`c",($pricebase+45));
		output("`cSteak..........%s gold pieces`c",($pricebase+65));
		output("`cWhole Chicken..........%s gold pieces`c",($pricebase+100));
		output("`cMilk..........%s gold pieces`c",($pricebase+15));
		output("`cWater..........%s gold pieces`c",($pricebase+5));
		addnav("Menu");
		if ($session['user']['gold'] >= ($pricebase+15)) addnav(array("Bread (`^%s gold`0)",($pricebase+15)),"runmodule.php?module=usechow&op=inn&act=bread");
		if ($session['user']['gold'] >= ($pricebase+25)) addnav(array("Pork Chops (`^%s gold`0)",($pricebase+25)),"runmodule.php?module=usechow&op=inn&act=pork");
		if ($session['user']['gold'] >= ($pricebase+45)) addnav(array("Ham Steak (`^%s gold`0)",($pricebase+45)),"runmodule.php?module=usechow&op=inn&act=ham");
		if ($session['user']['gold'] >= ($pricebase+65)) addnav(array("Steak (`^%s gold`0)",($pricebase+65)),"runmodule.php?module=usechow&op=inn&act=steak");
		if ($session['user']['gold'] >= ($pricebase+100)) addnav(array("Whole Chicken (`^%s gold`0)",($pricebase+100)),"runmodule.php?module=usechow&op=inn&act=chick");
		if ($session['user']['gold'] >= ($pricebase+15)) addnav(array("Milk (`^%s gold`0)",($pricebase+15)),"runmodule.php?module=usechow&op=inn&act=milk");
		if ($session['user']['gold'] >= ($pricebase+5)) addnav(array("Water (`^%s gold`0)",($pricebase+5)),"runmodule.php?module=usechow&op=inn&act=water");
		addnav("Navigation");
	}
	if ($act == "bread"){
		output("`#`bEat it here?  Or take it to go?`b`0");
		addnav("What to do?");
		addnav("Here","runmodule.php?module=usechow&op=inn&act=bread2");
		addnav("To Go","runmodule.php?module=usechow&op=inn&act=bread3");
		addnav("Go Back");
	}
	if ($act == "pork"){
		output("`#`bEat it here?  Or take it to go?`b`0");
		addnav("What to do?");
		addnav("Here","runmodule.php?module=usechow&op=inn&act=pork2");
		addnav("To Go","runmodule.php?module=usechow&op=inn&act=pork3");
		addnav("Go Back");
	}
	if ($act == "ham"){
		output("`#`bEat it here?  Or take it to go?`b`0");
		addnav("What to do?");
		addnav("Here","runmodule.php?module=usechow&op=inn&act=ham2");
		addnav("To Go","runmodule.php?module=usechow&op=inn&act=ham3");
		addnav("Go Back");
	}
	if ($act == "steak"){
		output("`#`bEat it here?  Or take it to go?`b`0");
		addnav("What to do?");
		addnav("Here","runmodule.php?module=usechow&op=inn&act=steak2");
		addnav("To Go","runmodule.php?module=usechow&op=inn&act=steak3");
		addnav("Go Back");
	}
	if ($act == "chick"){
		output("`#`bEat it here?  Or take it to go?`b`0");
		addnav("What to do?");
		addnav("Here","runmodule.php?module=usechow&op=inn&act=chick2");
		addnav("To Go","runmodule.php?module=usechow&op=inn&act=chick3");
		addnav("Go Back");
	}
	if ($act == "milk"){
		output("`#`bEat it here?  Or take it to go?`b`0");
		addnav("What to do?");
		addnav("Here","runmodule.php?module=usechow&op=inn&act=milk2");
		addnav("To Go","runmodule.php?module=usechow&op=inn&act=milk3");
		addnav("Go Back");
	}
	if ($act == "water"){
		output("`#`bEat it here?  Or take it to go?`b`0");
		addnav("What to do?");
		addnav("Here","runmodule.php?module=usechow&op=inn&act=water2");
		addnav("To Go","runmodule.php?module=usechow&op=inn&act=water3");
		addnav("Go Back");
	}
	if ($act == "bread2"){
		if ($uhunger>-10){
			output("You wolf down the bread like the barbarian that you are!`n");
			set_module_pref('hunger', $uhunger - 20);
			if (is_module_active('bladder')) {
				set_module_pref("bladder", (get_module_pref("bladder","bladder") + 1),"bladder");
			}
			$session['user']['gold']-=($pricebase+15);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("You are way too full to eat any more food!");
		}
	}
	if ($act == "bread3"){
		if ($userchow<5){
			output("You stuff the bread in your pack.");
			for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="1";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
			set_module_pref('chow', $newchow);
			$session['user']['gold']-=($pricebase+15);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("Your pack is full!");	
		}
	}
	if ($act == "pork2"){
		if ($uhunger>-10){
			output("You grab the pork chop up with your hand and tear into it.  Good thing no one else here is using utensils either.`n");
			set_module_pref('hunger', $uhunger - 30);
			if (is_module_active('bladder')) {
				set_module_pref("bladder", (get_module_pref("bladder","bladder") + 2),"bladder");
			}
			$session['user']['gold']-=($pricebase+25);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("You are way too full to eat any more food!");
		}
	}
	if ($act == "pork3"){
		if ($userchow<5){
			output("You stuff the pork chop in your pack.");
			for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="2";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
			set_module_pref('chow', $newchow);
			$session['user']['gold']-=($pricebase+25);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("Your pack is full!");	
		}
	}
	if ($act == "ham2"){
		if ($uhunger>-10){
			output("You pick up the Ham Steak with your grubby fingers and rip into it.  Not quite understanding why they even bothered to put it on a plate for you.`n");
			set_module_pref('hunger', $uhunger - 40);
			if (is_module_active('bladder')) {
				set_module_pref("bladder", (get_module_pref("bladder","bladder") + 2),"bladder");
			}
			$session['user']['gold']-=($pricebase+45);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("You are way too full to eat any more food!");
		}
	}
	if ($act == "ham3"){
		if ($userchow<5){
			output("You stuff the ham steak in your pack.");
			for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="3";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
			set_module_pref('chow', $newchow);
			$session['user']['gold']-=($pricebase+45);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("Your pack is full!");	
		}
	}
	if ($act == "steak2"){
		if ($uhunger>-10){
			output("You pick up the steak and start chewing, rather loudly as a matter of fact.  You wonder what those shiny metal things are there by your plate.`n");
			set_module_pref('hunger', $uhunger - 50);
			if (is_module_active('bladder')) {
				set_module_pref("bladder", (get_module_pref("bladder","bladder") + 3),"bladder");
			}
			$session['user']['gold']-=($pricebase+65);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("You are way too full to eat any more food!");
		}
	}
	if ($act == "steak3"){
		if ($userchow<5){
			output("You stuff the steak in your pack.");
			for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="4";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
			set_module_pref('chow', $newchow);
			$session['user']['gold']-=($pricebase+65);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("Your pack is full!");	
		}
	}
	if ($act == "chick2"){
		if ($uhunger>-10){
			output("You tear into the chicken like a rabid dog.  It goes down rather quickly.  You wonder what the square piece of cloth at your table is for.`n");
			set_module_pref('hunger', $uhunger - 60);
			if (is_module_active('bladder')) {
				set_module_pref("bladder", (get_module_pref("bladder","bladder") + 3),"bladder");
			}
			$session['user']['gold']-=($pricebase+100);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("You are way too full to eat any more food!");
		}
	}
	if ($act == "chick3"){
		if ($userchow<5){
			output("You stuff the chicken in your pack.");
			for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="5";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
			set_module_pref('chow', $newchow);
			$session['user']['gold']-=($pricebase+100);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("Your pack is full!");	
		}
	}
	if ($act == "milk2"){
		if ($uhunger>-10){
			output("You chug the glass of milk in a single gulp.  With a big ol' milk mustache you turn to the person at the next table and say \"Got Milk?\"");
			set_module_pref('hunger', $uhunger - 16);
			if (is_module_active('bladder')) {
				set_module_pref("bladder", (get_module_pref("bladder","bladder") + 4),"bladder");
			}
			$session['user']['gold']-=($pricebase+14);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("You are way too full to eat or drink any more!");
		}
	}
	if ($act == "milk3"){
		if ($userchow<5){
			output("You stuff the milk bottle in your pack.");
			for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="6";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
			set_module_pref('chow', $newchow);
			$session['user']['gold']-=($pricebase+14);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("Your pack is full!");	
		}
	}
	if ($act == "water2"){
		if ($uhunger>-10){
			output("You slam the mug of water.  When you are done you use your shirt sleeve to wipe your mouth.`n");
			set_module_pref('hunger', $uhunger - 8);
			if (is_module_active('bladder')) {
				set_module_pref("bladder", (get_module_pref("bladder","bladder") + 4),"bladder");
			}
			$session['user']['gold']-=($pricebase+4);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("You are way too full to eat or drink any more!");
		}
	}
	if ($act == "water3"){
		if ($userchow<5){
			output("You stuff the bottle of water in your pack.");
			for ($i=0;$i<6;$i+=1){
				$chow[$i]=substr(strval($uchow),$i,1);
				if ($chow[$i]=="0" and $done < 1){
					$chow[$i]="7";
					$done = 1;
				}
				$newchow.=$chow[$i];
			}
			set_module_pref('chow', $newchow);
			$session['user']['gold']-=($pricebase+4);
			addnav("More!","runmodule.php?module=usechow&op=inn");
		}else{
			output("Your pack is full!");	
		}
	}
	
	villagenav();
	page_footer();
}
?>