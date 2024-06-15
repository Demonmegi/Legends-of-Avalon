<?php
//addnews ready
// mail ready
// translator ready

function specialtymysticpower_getmoduleinfo(){
  $info = array(
    "name" => "Specialty - Mystical Powers",
    "author" => "Eric Stevens<br>modified for lotgd.de by `&Za`7nzam`&ar",
    "version" => "1.0",
    "download" => "core_module",
    "category" => "Specialties",
    "prefs" => array(
      "Specialty - Mystical Powers User Prefs,title",
      "skill"=>"Skill points in Mystical Powers,int|0",
      "uses"=>"Uses of Mystical Powers allowed,int|0",
    ),
  );
  return $info;
}

function specialtymysticpower_install(){
  $sql = "DESCRIBE " . db_prefix("accounts");
  $result = db_query($sql);
  $specialty="MP";
  while($row = db_fetch_assoc($result)) {
    // Convert the user over
    if ($row['Field'] == "magic") {
      debug("Migrating mystic powers field");
      $sql = "INSERT INTO " . db_prefix("module_userprefs") . " (modulename,setting,userid,value) SELECT 'specialtymysticpower', 'skill', acctid, magic FROM " . db_prefix("accounts");
      db_query($sql);
      debug("Dropping magic field from accounts table");
      $sql = "ALTER TABLE " . db_prefix("accounts") . " DROP magic";
      db_query($sql);
    } elseif ($row['Field']=="magicuses") {
      debug("Migrating mystic powers uses field");
      $sql = "INSERT INTO " . db_prefix("module_userprefs") . " (modulename,setting,userid,value) SELECT 'specialtymysticpower', 'uses', acctid, magicuses FROM " . db_prefix("accounts");
      db_query($sql);
      debug("Dropping magicuses field from accounts table");
      $sql = "ALTER TABLE " . db_prefix("accounts") . " DROP magicuses";
      db_query($sql);
    }
  }
  debug("Migrating Mystic Powers Specialty");
  $sql = "UPDATE " . db_prefix("accounts") . " SET specialty='$specialty' WHERE specialty='2'";
  db_query($sql);

  module_addhook("choose-specialty");
  module_addhook("set-specialty");
  module_addhook("fightnav-specialties");
  module_addhook("apply-specialties");
  module_addhook("newday");
  module_addhook("incrementspecialty");
  module_addhook("specialtynames");
  module_addhook("specialtymodules");
  module_addhook("specialtycolor");
  module_addhook("dragonkill");
  return true;
}

function specialtymysticpower_uninstall(){
  // Reset the specialty of anyone who had this specialty so they get to
  // rechoose at new day
  $sql = "UPDATE " . db_prefix("accounts") . " SET specialty='' WHERE specialty='MP'";
  db_query($sql);
  return true;
}

function specialtymysticpower_dohook($hookname,$args){
  global $session,$resline;

  $spec = "MP";
  $name = "Mystical Powers";
  $ccode = "`%";
  $ccode2 = "`%%"; // We need this to handle the damned sprintf escaping.

  switch ($hookname) {
  case "dragonkill":
    set_module_pref("uses", 0);
    set_module_pref("skill", 0);
    break;
  case "choose-specialty":
    if ($session['user']['specialty'] == "" ||
        $session['user']['specialty'] == '0') {
      addnav("$ccode$name`0","newday.php?setspecialty=".$spec."$resline");
      $t1 = translate_inline("Dabbling in mystical forces");
      $t2 = appoencode(translate_inline("$ccode$name`0"));
      rawoutput("<a href='newday.php?setspecialty=$spec$resline'>$t1 ($t2)</a><br>");
      addnav("","newday.php?setspecialty=$spec$resline");
    }
    break;
  case "set-specialty":
    if($session['user']['specialty'] == $spec) {
      page_header($name);
      output("`3Growing up, you remember knowing there was more to the world than the physical, and what you could place your hands on.");
      output("You realized that your mind itself, with training, could be turned into a weapon.");
      output("Over time, you began to control the thoughts of small creatures, commanding them to do your bidding, and also to begin to tap into the mystical force known as mana, which could be shaped into the elemental forms of fire, water, ice, earth, and wind.");
      output("To your delight, it could also be used as a weapon against your foes.");
    }
    break;
  case "specialtycolor":
    $args[$spec] = $ccode;
    break;
  case "specialtynames":
    $args[$spec] = translate_inline($name);
    break;
  case "specialtymodules":
    $args[$spec] = "specialtymysticpower";
    break;
  case "incrementspecialty":
    if($session['user']['specialty'] == $spec) {
      $new = get_module_pref("skill") + 1;
      set_module_pref("skill", $new);
      $name = translate_inline($name);
      $c = $args['color'];
      output("`n%sYou gain a level in `&%s%s to `#%s%s!",
          $c, $name, $c, $new, $c);
      $x = $new % 3;
      if ($x == 0){
        output("`n`^You gain an extra use point!`n");
        set_module_pref("uses", get_module_pref("uses") + 1);
      }else{
        if (3-$x == 1) {
          output("`n`^Only 1 more skill level until you gain an extra use point!`n");
        } else {
          output("`n`^Only %s more skill levels until you gain an extra use point!`n", (3-$x));
        }
      }
      output_notl("`0");
    }
    break;
  case "newday":
    $bonus = getsetting("specialtybonus", 1);
    if($session['user']['specialty'] == $spec) {
      $name = translate_inline($name);
      if ($bonus == 1) {
        output("`n`2For being interested in %s%s`2, you receive `^1`2 extra `&%s%s`2 use for today.`n",$ccode,$name,$ccode,$name);
      } else {
        output("`n`2For being interested in %s%s`2, you receive `^%s`2 extra `&%s%s`2 uses for today.`n",$ccode,$name,$bonus,$ccode,$name);
      }
    }
    $amt = (int)(get_module_pref("skill") / 3);
    if ($session['user']['specialty'] == $spec) $amt = $amt + $bonus;
    set_module_pref("uses", $amt);
    break;
  case "fightnav-specialties":
    $uses = get_module_pref("uses");
    $script = $args['script'];
    if ($uses > 0) {
      addnav(array("$ccode2$name (%s points)`0", $uses), "");
      addnav(array("e?$ccode2 &#149; Regeneration`7 (%s)`0", 1),
          $script."op=fight&skill=$spec&l=1", true);
    }
    if ($uses > 1) {
      addnav(array("$ccode2 &#149; Erdenfaust`7 (%s)`0", 2),
          $script."op=fight&skill=$spec&l=2",true);
    }
    if ($uses > 2) {
      addnav(array("$ccode2 &#149; Steinhaut`7 (%s)`0", 3),
          $script."op=fight&skill=$spec&l=3",true);
    }
    if ($uses > 3) {
      addnav(array("v?$ccode2 &#149; Verschwimmen`7 (%s)`0", 4),
      $script."op=fight&skill=$spec&l=4",true);
    }
    if ($uses > 4) {
      addnav(array("d?$ccode2 &#149; Donnerknall`7 (%s)`0", 5),
          $script."op=fight&skill=$spec&l=5",true);
    }
    if ($uses > 9) {
      addnav(array("$ccode2 &#149; Zeitstopp`7 (%s)`0", 10),
          $script."op=fight&skill=$spec&l=10",true);
    }
    break;
  case "apply-specialties":
    $skill = httpget('skill');
    $l = httpget('l');
    if ($skill==$spec){
      if (get_module_pref("uses") >= $l){
        switch($l){
        case 1:
          apply_buff('mp1', array(
            "startmsg"=>"`^Du fängst an zu regenerieren!",
            "name"=>"`%Regeneration",
            "rounds"=>5+$session['user']['level'],
            "wearoff"=>"`5Die Regeneration klingt ab.",
            "regen"=>2*$session['user']['level']+round($session['user']['dragonkills']/3),
            "effectmsg"=>"`%Du regenerierst `^{damage}`% Lebenspunkte.",
            "effectnodmgmsg"=>"Du hast keine Wunden zu regenerieren.",
            "aura"=>true,
            "auramsg"=>"`5Dein {companion}`5 regeneriert ebenfalls `^{damage} Lebenspunkte`5 aufgrund deiner heilenden Aura.",
            "schema"=>"module-specialtymysticpower"
          ));
          break;
        case 2:
          apply_buff('mp2', array(
            "startmsg"=>"`^Die Erde in deiner Umgebung beginnt zu erzittern.",
            "name"=>"`%Erdenfaust",
            "rounds"=>5,
            "wearoff"=>"`5Die Erde wird wieder ruhig.",
            "minioncount"=>1,
            "effectmsg"=>"`%Ein Brocken aufgeworfener Erde richtet `^{damage}`% Schadenspunkte bei {badguy}`% an.",
            "minbadguydamage"=>round(20+$session['user']['dragonkills']/4),
            "maxbadguydamage"=>ceil((20+$session['user']['dragonkills']/2)*(1+$session['user']['level']/10)),
            "areadamage"=>true,
            "schema"=>"module-specialtymysticpower"
          ));
          break;
        case 3:
          apply_buff('mp3', array(
            "startmsg"=>"`^Deine Haut wird so hart wie Stein.",
            "name"=>"`%Steinhaut",
            "rounds"=>5*ceil($session['user']['level']/7),
            "wearoff"=>"`5Deine Haut ist wieder so weich wie zuvor.",
            "badguydmgmod"=>0.5,
            "roundmsg"=>"`%Die Treffer deiner Gegner dringen nur mit halber Kraft durch deine steinerne Haut.",
            "schema"=>"module-specialtymysticpower"
          ));
          break;
        case 4:
          apply_buff('mp4', array(
            "startmsg"=>"`^Die Umrisse deines Körpers verschwimmen und verwirren die Sinne deiner Feinde.",
            "name"=>"`%Verschwimmen",
            "rounds"=>round(2*$session['user']['level']/3),
            "wearoff"=>"`5Dein Koerper nimmt wieder klare Konturen an.",
            "atkmod"=>1.25,
            "defmod"=>1.5,
            "roundmsg"=>"`%{badguy}`% kann nicht erkennen wo du bist und schlägt verzweifelt um sich.",
            "schema"=>"module-specialtymysticpower"
          ));
          break;
        case 5:
          apply_buff('mp5b', array(
            "startmsg"=>"`^Ein breiter Blitzstrahl fährt aus dem Himmel herab und schlägt mit lautem Krachen auf dem Schlachtfeld ein.",
            "name"=>"`%Donnerknall",
            "rounds"=>1,
            "minioncount"=>1,
            "effectmsg"=>"`%{badguy} wird von der Wucht des Einschlags getroffen und erleidet `^{damage}`% Schadenspunkte.",
            "minbadguydamage"=>round(16+$session['user']['dragonkills']/2)*8,
            "maxbadguydamage"=>ceil(20+$session['user']['dragonkills']/2)*max(1,$session['user']['level']/10)*10,
            "areadamage"=>true,
            "schema"=>"module-specialtymysticpower"
          ));
          apply_buff('mp5', array(
            "name"=>"`%Blitzaura",
            "rounds"=>ceil($session['user']['level']/2),
            "wearoff"=>"Deine Haut hoert auf zu kribbeln.",
            "damageshield"=>2,
            "roundmsg"=>"`%Deine Haut kribbelt noch vor elektrischer Energie.",
            "effectmsg"=>"`%{badguy}$ccode wird von einer Entladung aus deiner Haut zurückgeschleudert und erleidet `^{damage}$ccode Schadenspunkte!",
            "schema"=>"module-specialtymysticpower"
          ));
          break;
        case 10:
          if ($session['user']['gems'] > 0) {
            $session['user']['gems']--;
            apply_buff('mp10'
              ,array(
                "startmsg"=>"`%Du zückst einen Edelstein und bündelst deine Macht durch ihn, um sie gegen den Lauf der Welt selbst zu richten. Der Edelstein zerbirst und die Zeit bleibt stehen!",
                "name"=>"`%Zeitstopp",
                "rounds"=>10,
                "wearoff"=>"`%Deine Kraft ist aufgebraucht und die Welt dreht sich weiter.",
                "badguyatkmod"=>0,
                "badguydefmod"=>0,
                "roundmsg"=>"Du hast alle Zeit der Welt um dich um deinen Gegner zukümmern.",
                "schema"=>"module-specialtymysticpower"
              )
            );
          }else{
            apply_buff('mp10f'
              ,array(
                "startmsg"=>"`%Da du keinen Edelstein zur Hand hast, versuchst du, den Lauf der Zeit ohne einen solchen Fokus zu bremsen. Leider verlangsamt sich dadurch nicht nur dein Gegner, sondern auch du selbst!",
                "name"=>"`%Zeitlupe",
                "rounds"=>10,
                "wearoff"=>"`%Endlich dreht sich die Welt wieder schneller.",
                "badguyatkmod"=>0.5,
                "badguydefmod"=>0.5,
                "atkmod"=>0.5,
                "defmod"=>0.5,
                "roundmsg"=>"`%Du und {badguy} bewegen sich wie in Zeitlupe aufeinander zu. Das wird ein langer Kampf werden...",
                "schema"=>"module-specialtymysticpower"
              )
            );
          }
          break;
        }
        set_module_pref("uses", get_module_pref("uses") - $l);
      }else{
        apply_buff('mp0', array(
          "startmsg"=>"You furrow your brow and call on the powers of the elements.  A tiny flame appears.  {badguy} lights a cigarette from it, giving you a word of thanks before swinging at you again.",
          "rounds"=>1,
          "schema"=>"module-specialtymysticpower"
        ));
      }
    }
    break;
  }
  return $args;
}

function specialtymysticpower_run(){
}
?>
