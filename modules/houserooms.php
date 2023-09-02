<?php


function houserooms_getmoduleinfo() {
	$info = array(
		"name"=>"House Rooms",
		"author"=>"`!Rowne-Wuff Mastaile/`#Lonny Luberts",
		"version"=>"2.56",
		"category"=>"House System",
		"download"=>"http://www.pqcomp.com/modules/mydownloads/visit.php?cid=3&lid=48",
		"vertxtloc"=>"http://www.pqcomp.com/",
		"settings"=>array(
			"bedbuild"=>"Bathroom is built at ...`n(0 is always enabled),int|0",
			"bathbuild"=>"Bedroom is built at ...`n(0 is always enabled),int|0",
			"kitchbuild"=>"Kitchen is built at ...`n(0 is always enabled),int|0",
			"loungebuild"=>"Lounge is built at ...`n(0 is always enabled),int|0",
			"cellarbuild"=>"Cellar is built at ...`n(0 is always enabled),int|0",
			"gardenbuild"=>"Garden is built at ...`n(0 is always enabled),int|0",
			"buildingco"=>"The archetectural company|MusteliCo Mercantilics - Copious Condo ConstructiCo Division",
		),
		"prefs"=>array(
			"House Rooms Prefs,title",
			"bedroomfull"=>"Does the Bedroom have contents (automated pref)?,bool|0",
			"bedroomnavs"=>"Are the Bedroom navs enabled (automated pref)?,bool|0",
			"bathroomfull"=>"Does the Bathroom have contents (automated pref)?,bool|0",
			"bathroomnavs"=>"Are the Bathroom navs enabled (automated pref)?,bool|0",
			"kitchenfull"=>"Does the Kitchen have contents (automated pref)?,bool|0",
			"kitchennavs"=>"Are the Kitchen navs enabled (automated pref)?,bool|0",
			"loungefull"=>"Does the Lounge have contents (automated pref)?,bool|0",
			"loungenavs"=>"Are the Lounge navs enabled (automated pref)?,bool|0",
			"cellarfull"=>"Does the Cellar have contents (automated pref)?,bool|0",
			"cellarnavs"=>"Are the Cellar navs enabled (automated pref)?,bool|0",
			"gardenfull"=>"Does the Garden have contents (autmoated pref)?,bool|0",
			"gardennavs"=>"Are the Garden navs enabled (automated pref)?,bool|0",
		),
	);
	return $info;
}

function houserooms_install() {
	module_addhook ("houseroomsvariables");
	module_addhook ("houseroomshook");
	module_addhook ("gobacknav");
	return true;
}

function houserooms_uninstall() {
	return true;
}

function houserooms_dohook($hookname, $args) {
	global $session, $REQUEST_URI;
		
	$id = httpget("id");
	//if ($id == "") $id = get_module_pref("tempid");
	//set_module_pref("tempid",$id);
	switch ($hookname){
	case "houseroomshook":
		$currpage		= comscroll_sanitize	($REQUEST_URI);
		$bedroomnavs	= get_module_pref		("bedroomnavs");
		$bathroomnavs	= get_module_pref		("bathroomnavs");
		$kitchennavs	= get_module_pref		("kitchennavs");
		$loungenavs		= get_module_pref		("loungenavs");
		$cellarnavs		= get_module_pref		("cellarnavs");
		$gardennavs		= get_module_pref		("gardennavs");
		$bedbuild		= get_module_setting	("bedbuild");
		$bathbuild		= get_module_setting	("bathbuild");
		$kitchbuild		= get_module_setting	("kitchbuild");
		$loungebuild	= get_module_setting	("loungebuild");
		$cellarbuild	= get_module_setting	("cellarbuild");
		$gardenbuild	= get_module_setting	("gardenbuild");
		$housesize		= get_module_pref		("housesize", "house");

		if ($bedbuild > 0 && $bedbuild <= $housesize) $bedbuildactive = 1;
		elseif ($bedbuild > 0 && $bedbuild > $housesize) $bedbuildactive = 0;
		elseif ($bedbuild == 0) $bedbuildactive = 1;
		if ($bathbuild > 0 && $bathbuild <= $housesize) $bathbuildactive = 1;
		elseif ($bathbuild > 0 && $bathbuild > $housesize) $bathbuildactive = 0;
		elseif ($bathbuild == 0) $bathbuildactive = 1;
		if ($kitchbuild > 0 && $kitchbuild <= $housesize) $kitchbuildactive = 1;
		elseif ($kitchbuild > 0 && $kitchbuild > $housesize) $kitchbuildactive = 0;
		elseif ($kitchbuild == 0) $kitchbuildactive = 1;
		if ($loungebuild > 0 && $loungebuild <= $housesize) $loungebuildactive = 1;
		elseif ($loungebuild > 0 && $loungebuild > $housesize) $loungebuildactive = 0;
		elseif ($loungebuild == 0) $loungebuildactive = 1;
		if ($cellarbuild > 0 && $cellarbuild <= $housesize) $cellarbuildactive = 1;
		elseif ($cellarbuild > 0 && $cellarbuild > $housesize) $cellarbuildactive = 0;
		elseif ($cellarbuild == 0) $cellarbuildactive = 1;
		if ($gardenbuild > 0 && $gardenbuild <= $housesize) $gardenbuildactive = 1;
		elseif ($gardenbuild > 0 && $gardenbuild > $housesize) $gardenbuildactive = 0;
		elseif ($gardenbuild == 0) $gardenbuildactive = 1;
		
		//recheck and set prefs to make sure rooms are active
		if ($housesize > $bedbuild and $bedroomnavs == 0){
			set_module_pref("bedroomnavs",1);
			set_module_pref("bedroomfull",1);
		}
		if ($housesize > $bathbuild and $bathroomnavs == 0){
			set_module_pref("bathroomnavs",1);
			set_module_pref("bathroomfull",1);
		}
		if ($housesize > $kitchbuild and $kitchennavs == 0){
			set_module_pref("kitchennavs",1);
			set_module_pref("kitchenfull",1);
		}
		if ($housesize > $loungebuild and $loungenavs == 0){
			set_module_pref("loungenavs",1);
			set_module_pref("loungefull",1);
		}
		if ($housesize > $cellarbuild and $cellarnavs == 0){
			set_module_pref("cellarnavs",1);
			set_module_pref("cellarfull",1);
		}
		if ($housesize > $gardenbuild and $gardennavs == 0){
			set_module_pref("gardennavs",1);
			set_module_pref("gardenfull",1);
		}
		
		switch (!$bedroomnavs && !$bathroomnavs && !$kitchennavs && !$loungenavs && !$cellarnavs && !$gardennavs) {
			case "1":
				break;

			case "0":
				switch (strstr($currpage,"runmodule.php?module=house") != "" && $id > 0) {
					case "1":
						addnav ("Actions");
						if ($bedbuild > 0 || $bathbuild > 0 || $kitchbuild > 0 || $loungebuild > 0 || $cellarbuild > 0 || $gardenbuild > 0) addnav ("Building Status", "runmodule.php?module=houserooms&op=buildstatus&id=$id");
						addnav ("Rooms");
						if ($bedroomnavs && $bedbuildactive) addnav ("Bedroom", "runmodule.php?module=houserooms&op=bedroom&id=$id");
						if ($bathroomnavs && $bathbuildactive) addnav ("Bathroom", "runmodule.php?module=houserooms&op=bathroom&id=$id");
						if ($kitchennavs && $kitchbuildactive) addnav ("Kitchen", "runmodule.php?module=houserooms&op=kitchen&id=$id");
						if ($loungenavs && $loungebuildactive) addnav ("Lounge", "runmodule.php?module=houserooms&op=lounge&id=$id");
						if ($cellarnavs && $cellarbuildactive) addnav ("Cellar", "runmodule.php?module=houserooms&op=cellar&id=$id");
						if ($gardennavs && $gardenbuildactive) addnav ("Garden", "runmodule.php?module=houserooms&op=garden&id=$id");
						modulehook ("houseroomsaddnavs");
						//modulehook ("gobacknav");
						break;
				}
				break;
		}
		break;
		
	case "gobacknav":
		$currpage		= comscroll_sanitize	($REQUEST_URI);
		$bedroomnavs	= get_module_pref	("bedroomnavs");
		$bathroomnavs	= get_module_pref	("bathroomnavs");
		$kitchennavs	= get_module_pref	("kitchennavs");
		$loungenavs		= get_module_pref	("loungenavs");
		$cellarnavs		= get_module_pref	("cellarnavs");
		$gardennavs		= get_module_pref	("gardennavs");
		$bedbuild		= get_module_setting	("bedbuild");
		$bathbuild		= get_module_setting	("bathbuild");
		$kitchbuild		= get_module_setting	("kitchbuild");
		$loungebuild	= get_module_setting	("loungebuild");
		$cellarbuild	= get_module_setting	("cellarbuild");
		$gardenbuild	= get_module_setting	("gardenbuild");
		$disablemh		= httpget			("disablemh");
		$housesize		= get_module_pref		("housesize", "house");

		if ($bedbuild > 0 && $bedbuild <= $housesize) $bedbuildactive = 1;
		elseif ($bedbuild > 0 && $bedbuild > $housesize) $bedbuildactive = 0;
		elseif ($bedbuild == 0) $bedbuildactive = 1;
		if ($bathbuild > 0 && $bathbuild <= $housesize) $bathbuildactive = 1;
		elseif ($bathbuild > 0 && $bathbuild > $housesize) $bathbuildactive = 0;
		elseif ($bathbuild == 0) $bathbuildactive = 1;
		if ($kitchbuild > 0 && $kitchbuild <= $housesize) $kitchbuildactive = 1;
		elseif ($kitchbuild > 0 && $kitchbuild > $housesize) $kitchbuildactive = 0;
		elseif ($kitchbuild == 0) $kitchbuildactive = 1;
		if ($loungebuild > 0 && $loungebuild <= $housesize) $loungebuildactive = 1;
		elseif ($loungebuild > 0 && $loungebuild > $housesize) $loungebuildactive = 0;
		elseif ($loungebuild == 0) $loungebuildactive = 1;
		if ($cellarbuild > 0 && $cellarbuild <= $housesize) $cellarbuildactive = 1;
		elseif ($cellarbuild > 0 && $cellarbuild > $housesize) $cellarbuildactive = 0;
		elseif ($cellarbuild == 0) $cellarbuildactive = 1;
		if ($gardenbuild > 0 && $gardenbuild <= $housesize) $gardenbuildactive = 1;
		elseif ($gardenbuild > 0 && $gardenbuild > $housesize) $gardenbuildactive = 0;
		elseif ($gardenbuild == 0) $gardenbuildactive = 1;

		output ("`4");
		output ("`c");
		output ("-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-");
		output ("`n");
		output ("`6");
		output ("Where can I go?");
		output ("`n`n");
		output ("`7");
		modulehook ("houseroomswherecan");
		if (strstr($currpage,"runmodule.php?module=house&lo=house&id=")  == "" && strstr($currpage,"runmodule.php?module=houserooms") != "") addnav ("Exits From Here");
		if (strstr($currpage,"runmodule.php?module=houserooms&op=bathroom") != "" && $bedroomnavs && $bedbuildactive) {
			output ("There's a door nearby labeled '`2Bedroom`7'");
			output ("`n`n");
		}
		if (strstr($currpage,"runmodule.php?module=houserooms&op=bedroom") != "" && $bathroomnavs && $bathbuildactive) {
			output ("There's a door nearby labeled '`2Bathroom`7'");
			output ("`n`n");
		}
		if (strstr($currpage,"runmodule.php?module=houserooms&op=lounge") != "" && $kitchennavs && $kitchbuildactive) {
			output ("There's a door nearby labeled '`2Kitchen`7'");
			output ("`n`n");
		}
		if (strstr($currpage,"runmodule.php?module=houserooms&op=kitchen") != "" && $loungenavs && $loungebuildactive) {
			output ("There's a door nearby labeled '`2Lounge`7'");
			output ("`n`n");
		}
		modulehook ("houseroomsnavdescs");
		if (!$disablemh) output ("A large set of double-doors right behind you lead to the `2Main Hall `7of your house.");
		if (strstr($currpage,"runmodule.php?module=houserooms&op=lounge") == "" || strstr($currpage,"runmodule.php?module=houserooms&op=kitchen") == "" || strstr($currpage,"runmodule.php?module=house&lo=house&id=") == "") {
			output ("`n`n");
			output ("There's also a small, inconspicuous door that seems to lead back out to %s and the Residential Quarter.", $session['user']['location']);
		}
		output ("`n");
		output ("`4");
		output ("-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-");
		output ("`c");
		output ("`n");
		if (strstr($currpage,"runmodule.php?module=houserooms&op=bedroom") != "" && $bathroomnavs && $bathbuildactive) addnav("Bathroom", "runmodule.php?module=houserooms&op=bathroom&id=$id");
		if (strstr($currpage,"runmodule.php?module=houserooms&op=bathroom") != "" && $bedroomnavs && $bedbuildactive) addnav("Bedroom", "runmodule.php?module=houserooms&op=bedroom&id=$id");
		if (strstr($currpage,"runmodule.php?module=houserooms&op=lounge") != "" && $kitchennavs && $kitchbuildactive) addnav("Kitchen", "runmodule.php?module=houserooms&op=kitchen&id=$id");
		if (strstr($currpage,"runmodule.php?module=houserooms&op=kitchen") != "" && $loungenavs && $loungebuildactive) addnav("Lounge", "runmodule.php?module=houserooms&op=lounge&id=$id");
		modulehook ("houseroomsinroomsaddnavs");
		if (strstr($currpage,"runmodule.php?module=houserooms") != "" && !$disablemh) addnav ("Main Hall", "runmodule.php?module=house&lo=house&id=".$id);
		if (strstr($currpage,"runmodule.php?module=houserooms&op=lounge") == "" || strstr($currpage,"runmodule.php?module=houserooms&op=kitchen") == "") {
			addnav ("Return");
			addnav ("Back to the Residential Quarter", "runmodule.php?module=house");
			villagenav();
		}
		break;
	}

	return $args;
}

function houserooms_run() {
	global $session;
	$id = httpget("id");	
	$op			= httpget					("op");
	$bedroomnavs	= get_module_pref		("bedroomnavs");
	$bathroomnavs	= get_module_pref		("bathroomnavs");
	$kitchennavs	= get_module_pref		("kitchennavs");
	$loungenavs		= get_module_pref		("loungenavs");
	$cellarnavs		= get_module_pref		("cellarnavs");
	$gardennavs		= get_module_pref		("gardennavs");
	$bedroomfull	= get_module_pref		("bedroomfull");
	$bathroomfull	= get_module_pref		("bathroomfull");
	$kitchenfull	= get_module_pref		("kitchenfull");
	$loungefull		= get_module_pref		("loungefull");
	$cellarfull		= get_module_pref		("cellarfull");
	$gardenfull		= get_module_pref		("gardenfull");
	$bedbuild		= get_module_setting	("bedbuild");
	$bathbuild		= get_module_setting	("bathbuild");
	$kitchbuild		= get_module_setting	("kitchbuild");
	$loungebuild	= get_module_setting	("loungebuild");
	$cellarbuild	= get_module_setting	("cellarbuild");
	$gardenbuild	= get_module_setting	("gardenbuild");
	$housesize		= get_module_pref		("housesize", "house");
	$disablemh		= httpget				("disablemh");
	$buildingco		= get_module_setting	("buildingco");

	if ($bedbuild > 0 && $bedbuild <= $housesize) $bedbuildactive = 1;
	elseif ($bedbuild > 0 && $bedbuild > $housesize) $bedbuildactive = 0;
	elseif ($bedbuild == 0) $bedbuildactive = 1;
	if ($bathbuild > 0 && $bathbuild <= $housesize) $bathbuildactive = 1;
	elseif ($bathbuild > 0 && $bathbuild > $housesize) $bathbuildactive = 0;
	elseif ($bathbuild == 0) $bathbuildactive = 1;
	if ($kitchbuild > 0 && $kitchbuild <= $housesize) $kitchbuildactive = 1;
	elseif ($kitchbuild > 0 && $kitchbuild > $housesize) $kitchbuildactive = 0;
	elseif ($kitchbuild == 0) $kitchbuildactive = 1;
	if ($loungebuild > 0 && $loungebuild <= $housesize) $loungebuildactive = 1;
	elseif ($loungebuild > 0 && $loungebuild > $housesize) $loungebuildactive = 0;
	elseif ($loungebuild == 0) $loungebuildactive = 1;
	if ($cellarbuild > 0 && $cellarbuild <= $housesize) $cellarbuildactive = 1;
	elseif ($cellarbuild > 0 && $cellarbuild > $housesize) $cellarbuildactive = 0;
	elseif ($cellarbuild == 0) $cellarbuildactive = 1;
	if ($gardenbuild > 0 && $gardenbuild <= $housesize) $gardenbuildactive = 1;
	elseif ($gardenbuild > 0 && $gardenbuild > $housesize) $gardenbuildactive = 0;
	elseif ($gardenbuild == 0) $gardenbuildactive = 1;

	modulehook ("roomsdefines");

	page_header ();

	switch ($op) {
		case "buildstatus":
			output ("`c");
			output ("`^");
			output ("A '");
			output ("`%");
			output ("%s", $buildingco);
			output ("`^");
			output ("' flyer is tacked to the wall ...");
			output ("`c");
			output ("`7");
			output ("`n");
			output ("Welcome buyer %s to your new home, you can enjoy your", $session['user']['name']);
			output ("comfortable amenities at a price now cheaper than ever!");
			output ("How do we do it? Not even we know! Our marketing people");
			output ("say it has something to do with volume but you don't care");
			output ("about all that razz-matazz. All you should care about is");
			output ("that you're getting the best quality for the lowest");
			output ("prices and here at %s, we ensure just that!", $buildingco);
			output ("`n`n");
			output ("You can continue to upgrade your house too and add even");
			output ("further and greater amenities to it. See our list below");
			output ("to find out what you can get and what it'll take to");
			output ("obtain it! Though whatever you see there, we can guarantee");
			output ("you that by the standards of your realm, it will be cheap,");
			output ("cheap, cheap!");
			output ("`n`n");
			output ("`\$");
			output ("`c");
			output ("-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-");
			output ("`^");
			output ("Rooms Available");
			output ("`\$");
			output ("-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-");
			output ("`c");
			output ("`7");
			output ("`n");

			output ("Bedroom:");
			switch ($bedroomnavs) {
				case "1":
					switch ($bedbuildactive) {
						case "1":
							output ("`2");
							output ("Already Owned! Bought at rank %s.", $bedbuild);
							output ("`7");
							break;
						
						case "0":
							output ("`5");
							output ("House Rank: %s (with %s to go).", $bedbuild, $bedbuild - $housesize);
							output ("`7");
							break;
					}
					break;
					
				case "0":
					output ("`\$");
					output ("Not available!  Our archetects are working on a viable design and we hope to have something for you soon.");
					break;
			}
			output ("`n`n");

			output ("Bathroom:");
			switch ($bathroomnavs) {
				case "1":
					switch ($bathbuildactive) {
						case "1":
							output ("`2");
							output ("Already Owned! Bought at rank %s.", $bathbuild);
							output ("`7");
							break;
						
						case "0":
							output ("`5");
							output ("House Rank: %s (with %s to go).", $bathbuild, $bathbuild - $housesize);
							output ("`7");
							break;
					}
					break;
					
				case "0":
					output ("`\$");
					output ("Not available!  Our archetects are working on a viable design and we hope to have something for you soon.");
					break;
			}
			output ("`n`n");

			output ("Kitchen:");
			switch ($kitchennavs) {
				case "1":
					switch ($kitchbuildactive) {
						case "1":
							output ("`2");
							output ("Already Owned! Bought at rank %s.", $kitchbuild);
							output ("`7");
							break;
						
						case "0":
							output ("`5");
							output ("House Rank: %s (with %s to go).", $kitchbuild, $kitchbuild - $housesize);
							output ("`7");
							break;
					}
					break;
					
				case "0":
					output ("`\$");
					output ("Not available!  Our archetects are working on a viable design and we hope to have something for you soon.");
					break;
			}
			output ("`n`n");

			output ("Lounge:");
			switch ($loungenavs) {
				case "1":
					switch ($loungebuildactive) {
						case "1":
							output ("`2");
							output ("Already Owned! Bought at rank %s.", $loungebuild);
							output ("`7");
							break;
						
						case "0":
							output ("`5");
							output ("House Rank: %s (with %s to go).", $loungebuild, $loungebuild - $housesize);
							output ("`7");
							break;
					}
					break;
					
				case "0":
					output ("`\$");
					output ("Not available!  Our archetects are working on a viable design and we hope to have something for you soon.");
					break;
			}
			output ("`n`n");

			output ("Cellar:");
			switch ($cellarnavs) {
				case "1":
					switch ($cellarbuildactive) {
						case "1":
							output ("`2");
							output ("Already Owned! Bought at rank %s.", $cellarbuild);
							output ("`7");
							break;
						
						case "0":
							output ("`5");
							output ("House Rank: %s (with %s to go).", $cellarbuild, $cellarbuild - $housesize);
							output ("`7");
							break;
					}
					break;
					
				case "0":
					output ("`\$");
					output ("Not available!  Our archetects are working on a viable design and we hope to have something for you soon.");
					break;
			}
			output ("`n`n");

			output ("Garden:");
			switch ($gardennavs) {
				case "1":
					switch ($gardenbuildactive) {
						case "1":
							output ("`2");
							output ("Already Owned! Bought at rank %s.", $gardenbuild);
							output ("`7");
							break;
						
						case "0":
							output ("`5");
							output ("House Rank: %s (with %s to go).", $gardenbuild, $gardenbuild - $housesize);
							output ("`7");
							break;
					}
					break;
					
				case "0":
					output ("`\$");
					output ("Not available!  Our archetects are working on a viable design and we hope to have something for you soon.");
					break;
			}
			output ("`n`n");
			modulehook ("gobacknav");
			break;
			
		case "lounge":
			output ("`^`b`cThe Lounge`b");
			output ("`c");
			output ("`n`n");
			output ("`7");
		
			switch ($loungefull) {
				case "1":
					modulehook ("loungecontents");
					break;
				
				case "0":
					output ("Nothing can really be said about this Lounge, it's spartan and there's simply nothing here!");
					break;
			}
		
			output ("`n`n");
			modulehook ("gobacknav");
			break;
			
		case "bedroom":
			output ("`^`b`cThe Bedroom`b");
			output ("`c");
			output ("`n`n");
			output ("`7");
		
			switch ($bedroomfull) {
				case "1":
					modulehook ("bedroomcontents");
					break;

				case "0":
					output ("Nothing can really be said about this Bedroom, it's spartan and there's simply nothing here!");
					break;
			}
			output ("`n`n");
			modulehook ("gobacknav");
			break;

		case "kitchen":
			output ("`^`b`cThe Kitchen`b");
			output ("`c");
			output ("`n`n");
			output ("`7");
		
			switch ($kitchenfull) {
				case "1":
					modulehook ("kitchencontents");
					break;
					
				case "0":
					output ("Nothing can really be said about this Kitchen, it's spartan and there's simply nothing here!");
					break;
			}
		
			output ("`n`n");
			modulehook ("gobacknav");
			break;

		case "bathroom":
			output ("`^`b`cThe Bathroom`b");
			output ("`c");
			output ("`n`n");
			output ("`7");
		
			switch($bathroomfull) {
				case "1":
					modulehook ("bathroomcontents");
					break;
				
				case "0":
					output ("Nothing can really be said about this Bathroom, it's spartan and there's simply nothing here!");
					break;
			}
		
			output ("`n`n");
			modulehook ("gobacknav");
			break;

		case "cellar":
			output ("`^`b`cThe Cellar`b");
			output ("`c");
			output ("`n`n");
			output ("`7");
		
			switch ($cellarfull) {
				case "1":
					modulehook ("cellarcontents");
					break;

				case "0":
					output ("Nothing can really be said about this Cellar, it's spartan and there's simply nothing here!");
					break;
			}
		
			output ("`n`n");
			modulehook ("gobacknav");
			break;

		case "garden":
			output ("`^`b`cThe Garden`b");
			output ("`c");
			output ("`n`n");
			output ("`7");
		
			switch ($gardenfull) {
				case "1":
					require_once("lib/commentary.php");
					addcommentary();
					output("`n`nYou walk out of the house and on to one of the many winding paths that makes its way through the well-tended gardens.");
					output("From the flowerbeds that bloom even in darkest winter, to the hedges whose shadows promise forbidden secrets, these gardens provide a refuge for those seeking out the Green Dragon; a place where they can forget their troubles for a while and just relax.`n`n");
					output("One of the fairies buzzing about the garden flies up to remind you that the garden is a place for roleplaying and peaceful conversation, and to confine out-of-character comments to the other areas of the game.`n`n");
					$housegarden = "housegardens".$id;
					viewcommentary($housegarden,"Whisper here",30,"whispers");
					break;

				case "0":
					output ("Nothing can really be said about this Garden, it's spartan and there's simply nothing here!");
					break;
			}
		
			output ("`n`n");
			modulehook ("gobacknav");
			break;
	}
	
	page_footer ();
}

?>