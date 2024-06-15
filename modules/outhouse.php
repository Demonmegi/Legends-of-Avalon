<?php
//addnews ready
// mail ready
// translator ready
/**
* Version:	0.6
* Date:		July 31, 2003
* Author:	John J. Collins
* Email:	collinsj@yahoo.com
*
* Purpose:	Provide a fun module to Legend of the Green Dragon
* Program Flow:	The player can choose to use the Private or Public Toilet.
* It costs Gold to use the Private Toilet. The Public Toilet is free. After
* using one of the toilet's, the play can was their hands or return. If
* they choose to wash their hands, there is a chance that they can get
* their gold back. If they don't choose to wash their hands, there is a
* chance that they will lose some gold. If they loose gold there is an
* entry added to the daily news.
*/
/**
* Modifications:
* Date: Mar 3, 2004
* Author: Eric Stevens aka MightyE
* Email: logd -at- mightye -dot- org
*
* Mods: Reflowed to sit in moduling system.
*/

require_once("lib/http.php");

function outhouse_getmoduleinfo(){
	$info = array(
		"name"=>"Gnomish Outhouse",
		"author"=>"John Collins, modification by `2C`@l`Ga`Ku`kd`li`La",
		"version"=>"2.1",
		"category"=>"Forest",
		"download"=>"core_module without modification",
		"prefs"=>array(
			"Gnomish Outhouse User Preferences,title",
			"usedouthouse"=>"Used Outhouse Today,bool|0",
			"stinkebuff"=>"Wird bald mit dem Stinkebuff belegt.,bool|0"
		),
		"settings"=>array(
			"Gnomish Outhouse Settings,title",
			"cost"=>"Cost to use the private outhouse,range,1,20,1|5",
			"goldinhand"=>"How much gold must user have in hand before they can lose money,range,0,10,1|1",
			"giveback"=>"How much gold to give back if the player is rewarded for washing their hands,range,0,20,1|3",
			"takeback"=>"How much gold to take if the user is punished for not washing their hands,range,0,20,1|1",
			"goodmusthit"=>"Percent of time you get your money back if you wash,range,0,100,1|60",
			"badmusthit"=>"Percent of time you lose money if you don't wash,range,0,100,1|50",
			"givegempercent"=>"Percent chance of getting a gem if you wash,range,0,100,1|25",
			"giveturnchance"=>"Percent chance of a free forest fight if you wash,range,0,100,1|0",
			//Claudias modification
			"anzeige1"=>"Poetischer Text 1|",
			"anzeige2"=>"Poetischer Text 2|",
			"anzeige3"=>"Poetischer Text 3|",
			"anzeige4"=>"Poetischer Text 4|",
			"anzeige5"=>"Poetischer Text 5|",
			"anzeige6"=>"Poetischer Text 6|",
			"anzeige7"=>"Poetischer Text 7|",
			"anzeige8"=>"Poetischer Text 8|",
			"anzeige9"=>"Poetischer Text 9|",
			"anzeige10"=>"Poetischer Text 10|",
			"author1"=>"Poetischer Author 1|",
			"author2"=>"Poetischer Author 2|",
			"author3"=>"Poetischer Author 3|",
			"author4"=>"Poetischer Author 4|",
			"author5"=>"Poetischer Author 5|",
			"author6"=>"Poetischer Author 6|",
			"author7"=>"Poetischer Author 7|",
			"author8"=>"Poetischer Author 8|",
			"author9"=>"Poetischer Author 9|",
			"author10"=>"Poetischer Author 10|",
			"authorid1"=>"Poetischer Author 1|",
			"authorid2"=>"Poetischer Author 2|",
			"authorid3"=>"Poetischer Author 3|",
			"authorid4"=>"Poetischer Author 4|",
			"authorid5"=>"Poetischer Author 5|",
			"authorid6"=>"Poetischer Author 6|",
			"authorid7"=>"Poetischer Author 7|",
			"authorid8"=>"Poetischer Author 8|",
			"authorid9"=>"Poetischer Author 9|",
			"authorid10"=>"Poetischer Author 10|",
			"laufzahl"=>"Neuster Text|0"
			//end Claudias modification
		)
	);
	return $info;
}

function outhouse_install(){
	global $session;
	debug("Adding Hooks");
	module_addhook("forest");
	module_addhook("newday");

	$sql = "DESCRIBE " . db_prefix("accounts");
	$result = db_query($sql);
	while ($row = db_fetch_assoc($result)){
		if ($row['Field']=="usedouthouse"){
			$sql = "SELECT usedouthouse,acctid FROM " . db_prefix("accounts") . " WHERE usedouthouse>0";
			$result1 = db_query($sql);
			debug("Migrating outhouse usage.`n");
			while ($row1 = db_fetch_assoc($result1)){
				$sql = "INSERT INTO " . db_prefix("module_userprefs") . " (modulename,setting,userid,value) VALUES ('outhouse','usedouthouse',{$row1['acctid']},{$row1['usedouthouse']})";
				db_query($sql);
			}//end while
			debug("Dropping usedouthouse column from the user table.`n");
			$sql = "ALTER TABLE " . db_prefix("accounts") . " DROP usedouthouse";
			db_query($sql);
			//drop it from the user's session too.
			unset($session['user']['usedouthouse']);
		}//end if
	}//end while
	return true;
}

function outhouse_uninstall(){
	output("Uninstalling this module.`n");
	return true;
}

function outhouse_dohook($hookname, $args){
	if ($hookname=="forest"){
		addnav("O?The Outhouse","runmodule.php?module=outhouse");
	}elseif ($hookname=="newday"){//claudias Modifikation
	  if(get_module_pref('stinkebuff')==true){
	    output('`q--------------------------------------------------------------------------------------------------------------------------`n');
	    output("Wegen unsäglicher Schmiererei im Toilettenhaus hat dich die Waschraumfee mit einem Fluch belegt.`n");
	    output('--------------------------------------------------------------------------------------------------------------------------`n`n');
			apply_buff("stinkebuff", array(
			  "name" => "`qgrässlicher Gestank",
				"rounds" => -1,
				"defmod" => 0.75,
				"allowintrain" => 1,
				"allowinpvp"=>1,
			));
	  }//end modifikation
	  set_module_pref("stinkebuff",0);
		set_module_pref("usedouthouse",0);
	}
	return $args;
}

function outhouse_run(){
	global $session;
	$cost = get_module_setting("cost");
	$goldinhand = get_module_setting("goldinhand");
	$giveback = get_module_setting("giveback");
	$takeback = get_module_setting("takeback");
	$goodmusthit = get_module_setting("goodmusthit");
	$badmusthit = get_module_setting("badmusthit");
	$givegempercent = get_module_setting("givegempercent");
	$giveturnchance= get_module_setting("giveturnchance");
	$returnto = get_module_setting("returnto");
	// Does the player have enough gold to use the Private Toilet?
	if ($session['user']['gold'] >= $cost)
		$canpay = true;

	$op = httpget('op');
	$strafe = httpget('strafe');//claudia klopoesiebestrafung
	if ($op == "pay"){
		if (!$canpay) {
			page_header("Private Toilet");
			output("`7You reach into your pocket and find that your gold has vanished!");
			output("Dejected, you return to the forest.");
			require_once("lib/forest.php");
			forest(true);
			page_footer();
		}

		page_header("Private Toilet");
		set_module_pref("usedouthouse",1);
		output("`7You pay your %s gold to the Toilet Gnome for the privilege of using the paid outhouse.`n", $cost);
		output("This is the cleanest outhouse in the land!`n");
		output("The Toilet Paper Gnome tells you if you need anything, just ask.`n");
		if ($session['user']['sex']) {
			output("She politely turns her back to you and finishes cleaning the wash stand.`n");
		} else {
			output("He politely turns his back to you and finishes cleaning the wash stand.`n");
		}
    //Claudias modification
    output('`nWährend du dich völlig entspannt auf den Donnerbalken setzt, fallen dir einige Schnitzereien in der sonst sauberen Holztür auf:`n`n`n');
    outhouse_show_kritzel();
    addnav("Etwas in die Tür ritzen","runmodule.php?module=outhouse&op=ritze");
    //end Claudias modification
		$session['user']['gold'] -= $cost;
		debuglog("spent $cost gold to use the outhouse");
		addnav("Wash your hands", "runmodule.php?module=outhouse&op=washpay");
		addnav("Leave", "runmodule.php?module=outhouse&op=nowash");
	}elseif ($op == "free"){
		page_header("Public Toilet!");
		set_module_pref("usedouthouse",1);
		output("`2The smell is so strong your eyes tear up and your nose hair curls!`n");
		output("After blowing his nose with it, the Toilet Paper Gnome gives you 1 sheet of single-ply TP to use.`n");
		output("After looking at the stuff covering his hands, you think you might not want to use it.`n`n");
		output("While %s over the big hole in the middle of the room with the TP Gnome observing you closely, you almost slip in.`n", translate_inline($session['user']['sex']?"squatting":"standing"));
		output("You go ahead and take care of business as fast as you can; you can only hold your breath so long.`n");
		addnav("Wash your hands", "runmodule.php?module=outhouse&op=washfree");
		addnav("Leave", "runmodule.php?module=outhouse&op=nowash");
	}elseif ($op == "washpay"|| $op == "washfree"){
		page_header("Wash Stand");
		output("`2Washing your hands is always a good thing.  You tidy up, straighten your %s in your reflection in the water, and head on your way.`0`n", $session['user']['armor']);
		$goodhabits = e_rand(1, 100);
		if ($goodhabits <= $goodmusthit && $op=="washpay"){
			output("`^The Wash Room Fairy blesses you!`n");
			output("`7You receive `^%s`7 gold for being sanitary and clean!`0`n", $giveback);
			$session['user']['gold'] += $giveback;
			debuglog("got $giveback gold in the outhouse for washing");
			$givegemtemp = e_rand(1, 100);
			if ($givegemtemp <= $givegempercent){
				$session['user']['gems']++;
				debuglog("gained 1 gem in the outhouse");
				output("`&Aren't you the lucky one to find a `%gem`& there by the doorway!`0`n");
			}
			$giveturntemp = e_rand(1, 100);
			if ($giveturntemp <= $giveturnchance) {
				$session['user']['turns']++;
				output("`&You gained a turn!`0`n");
			}
		}elseif ($goodhabits <= $goodmusthit && $op == "washfree"){
			if (e_rand(1, 3)==1) {
				output("`&You notice a small bag containing `^%s`7 gold that someone left by the washstand.`0", $giveback);
				$session['user']['gold'] += $giveback;
				debuglog("got $giveback gold in the outhouse for washing");
			}
		}
		$args = array(
			'soberval'=>0.9,
			'sobermsg'=>"`&Leaving the outhouse, you feel a little more sober.`n",
			'schema'=>"module-outhouse",
		);
		modulehook("soberup", $args);
		require_once("lib/forest.php");
		forest(true);
	}elseif (($op == "nowash")){
		page_header("Stinky Hands");
		output("`2Your hands are soiled and real stinky!`n");
		output("Didn't your mother teach you any better?`n");
		$takeaway = e_rand(1, 100);
		if ($takeaway >= $badmusthit){
			if ($session['user']['gold'] >= $goldinhand){
				$session['user']['gold'] -= $takeback;
				debuglog("lost $takeback gold in the outhouse for not washing");
				output("`nThe Toilet Paper Gnome has thrown you to the slimy, filthy floor and extracted `\$%s gold`2 %s from you due to your slovenliness!`n", $takeback, translate_inline($takeback ==1?"piece":"pieces"));
			}
			output("Aren't you glad an embarrassing moment like this isn't in the news?`n");
			if ($session['user']['sex']) {
				$msg = "`2Always cool, %s`2 was seen walking around with a long string of toilet paper stuck to her foot.`n";
			} else {
				$msg = "`2Always cool, %s`2 was seen walking around with a long string of toilet paper stuck to his foot.`n";
			}
			addnews($msg, $session['user']['name']);
		}
		require_once("lib/forest.php");
		forest(true);
	}elseif($op=="ritze"){//Claudias modification
    page_header('Die Tür zerkratzen');
    output('Während du deinen Geschäften nachgehst, hast du natürlich deine Hände frei, so frei wie deinen Kopf. Mit einem kleinen Holzsplitter fängst du an, eine Nachricht für deine Nachfolger zu hinterlegen.`n');
    $link=appendcount('runmodule.php?module=outhouse&op=ratze');
    rawoutput("<form action='$link' method='POST'>");
    rawoutput("<input name='text' value=''>");
    rawoutput("<input type='submit' class='button' value='einritzen'>");
    rawoutput('</form>');
		addnav("Wash your hands", "runmodule.php?module=outhouse&op=washpay");
		addnav("Leave", "runmodule.php?module=outhouse&op=nowash");
    addnav('',$link);//damit kein badnav beim formular
	}elseif($op=="ratze"){
    page_header('Eine Neue Nachricht in der Tür');
	  $newtext=httppost('text');
	  output('Nach getaner Arbeit betrachtest du noch einmal dein Werk in der Gesammtheit der Tür:`n');
	  $int=get_module_setting("laufzahl");
	  $int++;
	  if($int==11)$int=1;
	  set_module_setting("anzeige".$int,$newtext);
	  set_module_setting("authorid".$int,$_SESSION['session']['user']['acctid']);
	  set_module_setting("author".$int,$_SESSION['session']['user']['name']);
	  set_module_setting("laufzahl",$int);
	  outhouse_show_kritzel();
		addnav("Wash your hands", "runmodule.php?module=outhouse&op=washpay");
		addnav("Leave", "runmodule.php?module=outhouse&op=nowash");
  }elseif($op=="lusche"){
    $nummer=httpget('nummer');
    page_header('Nachricht '.$nummer.' löschen');	  
	  output('Nachricht '.$nummer.' wurde gelöscht.`n');
	  if($strafe==true){
	    set_module_pref('stinkebuff',true,false,get_module_setting('authorid'.$nummer));
			$to = get_module_setting('authorid'.$nummer);
      $subject = '`$Du wurdest verflucht!';
      $body = array('`QDie Waschraumfee war über deine Sprüche an der Klowand nicht amüsiert. Deswegen wird dich morgen ein ganz besonderer Freund von ihr einen Tag lang begleiten.');
			require_once("lib/systemmail.php");
			systemmail($to, $subject, $body);
			output('Wegen unsäglichem Gekrakel wurde der Verfasser verwarnt.');
	  }
	  set_module_setting("anzeige".$nummer,'');
	  set_module_setting("author".$nummer,'');
	  if(get_module_setting("laufzahl")==$nummer){
	    if($nummer==1){
	      set_module_setting("laufzahl",10);
	    }else{
        set_module_setting("laufzahl",($nummer-1));
        }	
      }
    addnav('Zurück in den Wald', 'forest.php'); 
    addnav("zurück zur Löschübersicht","runmodule.php?module=outhouse&op=admin");
  }elseif($op=="luscheall"){
    page_header('Alle Nachrichten Löschen');	  
	  output('Die kompletten Nachrichten wurden gelöscht.');
	  set_module_setting("anzeige1",'');
	  set_module_setting("anzeige2",'');
	  set_module_setting("anzeige3",'');
	  set_module_setting("anzeige4",'');
	  set_module_setting("anzeige5",'');
	  set_module_setting("anzeige6",'');
	  set_module_setting("anzeige7",'');
	  set_module_setting("anzeige8",'');
	  set_module_setting("anzeige9",'');
	  set_module_setting("anzeige10",'');
	  set_module_setting("author1",'');
    set_module_setting("author2",'');
    set_module_setting("author3",'');
    set_module_setting("author4",'');
    set_module_setting("author5",'');
    set_module_setting("author6",'');
    set_module_setting("author7",'');
    set_module_setting("author8",'');
    set_module_setting("author9",'');
    set_module_setting("author10",'');	
    set_module_setting("laufzahl",'0');	
    addnav('Zurück in den Wald', 'forest.php');  
  }elseif($op=="admin"){
    page_header('Klohäuschenadmin');
    output('Folgende Werke sind an der Tür zu sehen:`n`n`n');
    outhouse_show_kritzel(true);
    output('Möchtest du welche löschen?');
    tlschema('raus hier');
    addnav("raus hier");
    addnav('Zurück in den Wald', 'forest.php');
    tlschema('Nur Löschen');
    addnav("Nur Löschen");
    addnav("lösche Text 1", "runmodule.php?module=outhouse&op=lusche&nummer=1");
    addnav("lösche Text 2", "runmodule.php?module=outhouse&op=lusche&nummer=2");
    addnav("lösche Text 3", "runmodule.php?module=outhouse&op=lusche&nummer=3");
    addnav("lösche Text 4", "runmodule.php?module=outhouse&op=lusche&nummer=4");
    addnav("lösche Text 5", "runmodule.php?module=outhouse&op=lusche&nummer=5");
    addnav("lösche Text 6", "runmodule.php?module=outhouse&op=lusche&nummer=6");
    addnav("lösche Text 7", "runmodule.php?module=outhouse&op=lusche&nummer=7");
    addnav("lösche Text 8", "runmodule.php?module=outhouse&op=lusche&nummer=8");
    addnav("lösche Text 9", "runmodule.php?module=outhouse&op=lusche&nummer=9");
    addnav("lösche Text 10", "runmodule.php?module=outhouse&op=lusche&nummer=10");
    addnav("lösche alles", "runmodule.php?module=outhouse&op=luscheall");
    addnav("Lösche mit Bestrafung");
    tlschema('Lösche mit Bestrafung');
    addnav("bestrafe Text 1", "runmodule.php?module=outhouse&op=lusche&nummer=1&strafe=true");
    addnav("bestrafe Text 2", "runmodule.php?module=outhouse&op=lusche&nummer=2&strafe=true");
    addnav("bestrafe Text 3", "runmodule.php?module=outhouse&op=lusche&nummer=3&strafe=true");
    addnav("bestrafe Text 4", "runmodule.php?module=outhouse&op=lusche&nummer=4&strafe=true");
    addnav("bestrafe Text 5", "runmodule.php?module=outhouse&op=lusche&nummer=5&strafe=true");
    addnav("bestrafe Text 6", "runmodule.php?module=outhouse&op=lusche&nummer=6&strafe=true");
    addnav("bestrafe Text 7", "runmodule.php?module=outhouse&op=lusche&nummer=7&strafe=true");
    addnav("bestrafe Text 8", "runmodule.php?module=outhouse&op=lusche&nummer=8&strafe=true");
    addnav("bestrafe Text 9", "runmodule.php?module=outhouse&op=lusche&nummer=9&strafe=true");
    addnav("bestrafe Text 10", "runmodule.php?module=outhouse&op=lusche&nummer=10&strafe=true");
    tlschema();
  }else{//end Claudias modification
		page_header("The Outhouses");
		output("`2The nearby village has two outhouses, which it keeps way out here in the forest because of the warding effect of their smell on creatures.`n`n");
		if (get_module_pref("usedouthouse")==0){
			output("In typical caste style, there is a privileged outhouse, and an underprivileged outhouse.");
			output("The choice is yours!`0`n`n");
			addnav("Toilets");
			if ($canpay){
				addnav(array("Private Toilet: (%s gold)", $cost),
						"runmodule.php?module=outhouse&op=pay");
			}else{
				output("`2The Private Toilet costs `^%s`2 gold.", $cost);
				output("Looks like you are going to have to hold it or use the Public Toilet!");
			}
			addnav("Public Toilet: (free)", "runmodule.php?module=outhouse&op=free");
			addnav("Hold it", "forest.php");
			//Claudias modification
			if($session['user']['superuser'])addnav("Admin Lösche Poesie","runmodule.php?module=outhouse&op=admin");
		}elseif($session['user']['superuser']){
		  page_header("The Outhouses");
			output("The Outhouses are closed for repairs.`n");
			output("You will have to hold it till tomorrow!");		  
		  addnav("Admin Lösche Poesie","runmodule.php?module=outhouse&op=admin");
		  addnav('Zurück in den Wald', 'forest.php');
		}else{//end Claudias modification
			switch(e_rand(1,3)){
			case 1:
				output("The Outhouses are closed for repairs.`n");
				output("You will have to hold it till tomorrow!");
				break;
			case 2:
				output("As you draw close to the Outhouses, you realize that you simply don't think you can bear the smell of another visit to the Outhouses today.");
				break;
			case 3:
				output("You really don't have anything left to relieve today!");
				break;
			}
			output("`n`n`7You return to the forest.`0");
			require_once("lib/forest.php");
			forest(true);
		}
	}
	page_footer();
}

function outhouse_show_kritzel($admin=false){//Claudias modification
  $int=get_module_setting("laufzahl");//get information
  $text=array(1=>get_module_setting("anzeige1"),
    2=>get_module_setting("anzeige2"),
    3=>get_module_setting("anzeige3"),
    4=>get_module_setting("anzeige4"),
    5=>get_module_setting("anzeige5"),
    6=>get_module_setting("anzeige6"),
    7=>get_module_setting("anzeige7"),
    8=>get_module_setting("anzeige8"),
    9=>get_module_setting("anzeige9"),
    10=>get_module_setting("anzeige10")
  );
  $tmpint=$int;//inizialize infos
  if($tmpint==0){
    output('Zumindest dachtest du, dass dort welche seien sollten. Vielleicht hat sie wer entfernen lassen?');
  }else{
    for($count=0;$count<=9;$count++){//prozessing information
     if($text[$tmpint]==""){
       $tmpint--;
     if($tmpint<1)$tmpint=10;
   }else{
    if($admin){
      output('Text '.$tmpint.' wurde von '.get_module_setting("author".$tmpint).' geschrieben:`n`c'.$text[$tmpint].'`c`n`n`n');//output information
    }else{
      output('`c'.$text[$tmpint].'`c`n`n`n');//output information
    }
     $tmpint--;
     if($tmpint<1)$tmpint=10;
   }
  }
 }  
}
?>
