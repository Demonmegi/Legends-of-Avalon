<?php
// translator ready
// addnews ready
// mail ready
require_once("lib/bell_rand.php");
require_once("common.php");
require_once("lib/http.php");
require_once("lib/battle-buffs.php");
require_once("lib/battle-skills.php");
require_once("lib/buffs.php");

//just in case we're called from within a function.  Yuck is this ugly.
global $badguy,$session,$creatureattack,$creatureatkmod, $beta;
global $creaturedefmod,$adjustment,$defmod,$atkmod,$buffset,$atk,$def;

tlschema("battle");

$badguy = createarray($session['user']['badguy']);

$op=httpget("op");
$skill=httpget("skill");
$l=httpget("l");

$adjustment = 1;

if ($op=="fight"){
	apply_skill($skill,$l);
}

if ($badguy['creaturehealth']>0 && $session['user']['hitpoints']>0) {
	output ("`\$`c`b~ ~ ~ Fight ~ ~ ~`b`c`0");
	modulehook("battle", $badguy);
	output("`@You have encountered `^%s`@ which lunges at you with `%%s`@!`0`n`n",$badguy['creaturename'],$badguy['creatureweapon']);

	output("`2`bStart of round:`b`n");
	if ($session['user']['alive']){
		output("`2%s`2's Hitpoints: `6%s`0`n",$badguy['creaturename'],$badguy['creaturehealth']);
		output("`2YOUR Hitpoints: `6%s`0`n",$session['user']['hitpoints']);
	}else{
		output("`2%s`2's Soulpoints: `6%s`0`n",$badguy['creaturename'],$badguy['creaturehealth']);
		output("`2YOUR Soulpoints: `6%s`0`n",$session['user']['hitpoints']);
	}
}

// Run through as many rounds as needed.
do {
	//we need to restore and calculate here to reflect changes that happen throughout the course of multiple rounds.
	restore_buff_fields();
	calculate_buff_fields();
	// Run the beginning of round buffs (this also calculates all modifiers)
	$buffset = activate_buffs("roundstart");

	$creaturedefmod=$buffset['badguydefmod'];
	$creatureatkmod=$buffset['badguyatkmod'];
	$atkmod=$buffset['atkmod'];
	$defmod=$buffset['defmod'];

	if ($op=="fight" || $op=="run"){
		// Grab an initial roll.
		$roll = rolldamage();

		if ($op=="fight"){
			$ggchancetodouble = $session['user']['dragonkills'];
			$bgchancetodouble = $session['user']['dragonkills'];

			if ($badguy['creaturehealth']>0 &&
					$session['user']['hitpoints']>0) {
				$buffset = activate_buffs("offense");
				do {
					$creaturedmg = $roll['creaturedmg'];
					if ($badguy['creaturehealth']<=0 ||
							$session['user']['hitpoints']<=0){
						$creaturedmg = 0;
						$selfdmg = 0;
						break;
					}else{
						$creaturedmg = report_power_move($atk, $creaturedmg);
						if ($creaturedmg==0){
							output("`4You try to hit `^%s`4 but `\$MISS!`n",$badguy['creaturename']);
							process_dmgshield($buffset['dmgshield'], 0);
							process_lifetaps($buffset['lifetap'], 0);
						}else if ($creaturedmg<0){
							output("`4You try to hit `^%s`4 but are `\$RIPOSTED `4for `\$%s`4 points of damage!`n",$badguy['creaturename'],(0-$creaturedmg));
							$badguy['diddamage']=1;
							$session['user']['hitpoints']+=$creaturedmg;
							process_dmgshield($buffset['dmgshield'],-$creaturedmg);
							process_lifetaps($buffset['lifetap'],$creaturedmg);
						}else{
							output("`4You hit `^%s`4 for `^%s`4 points of damage!`n",$badguy['creaturename'],$creaturedmg);
							$badguy['creaturehealth']-=$creaturedmg;
							process_dmgshield($buffset['dmgshield'],-$creaturedmg);
							process_lifetaps($buffset['lifetap'],$creaturedmg);
						}
					}
					modulehook("damage", array('creaturedmg'=>$creaturedmg));
					$r = mt_rand(0,100);
					if ($r < $ggchancetodouble &&
							$badguy['creaturehealth']>0 &&
							$session['user']['hitpoints']>0){
						$additionalattack = true;
						$ggchancetodouble -= ($r+5);
						$roll = rolldamage();
					}else{
						$additionalattack = false;
					}
				} while($additionalattack);
			}
		}else if($op=="run" && !$surprised){
			output("`4You are too busy trying to run away like a cowardly dog to try to fight `^%s`4.`n",$badguy['creaturename']);
		}
		$op = "fight";
		// We need to check both user health and creature health. Otherwise
		// the user can win a battle by a RIPOSTE after he has gone <= 0 HP.
		//-- Gunnar Kreitz
		if ($badguy['creaturehealth']>0 && $session['user']['hitpoints']>0){
			$buffset = activate_buffs("defense");
			do {
				$selfdmg = $roll['selfdmg'];
				if ($badguy['creaturehealth']<=0 &&
						$session['user']['hitpoints']<=0){
					$creaturedmg = 0;
					$selfdmg = 0;
					break;
				}else{
					if ($selfdmg==0){
						output("`^%s`4 tries to hit you but `^MISSES!`n",$badguy['creaturename']);
						process_dmgshield($buffset['dmgshield'], 0);
						process_lifetaps($buffset['lifetap'], 0);
					}else if ($selfdmg<0){
						output("`^%s`4 tries to hit you but you `^RIPOSTE`4 for `^%s`4 points of damage!`n",$badguy['creaturename'],(0-$selfdmg));
						$badguy['creaturehealth']+=$selfdmg;
						process_lifetaps($buffset['lifetap'], -$selfdmg);
						process_dmgshield($buffset['dmgshield'], $selfdmg);
						modulehook("damage", array('creaturedmg'=>(0-$selfdmg)));
					}else{
						output("`^%s`4 hits you for `\$%s`4 points of damage!`n",$badguy['creaturename'],$selfdmg);
						$session['user']['hitpoints']-=$selfdmg;
						process_dmgshield($buffset['dmgshield'], $selfdmg);
						process_lifetaps($buffset['lifetap'], -$selfdmg);
						$badguy['diddamage']=1;
					}
				}
				$r = mt_rand(0,100);
				if (!isset($bgchancetodouble)) $bgchancetodouble = 0;
				if ($r < $bgchancetodouble &&
						$badguy['creaturehealth']>0 &&
						$session['user']['hitpoints']>0){
					$additionalattack = true;
					$bgchancetodouble -= ($r+5);
					$roll = rolldamage();
				}else{
					$additionalattack = false;
				}
			} while ($additionalattack);
		}
	}

	expire_buffs();
	$creaturedmg=0;
	$selfdmg=0;

	if ($count != 1 && $session['user']['hitpoints'] > 0 &&
			$badguy['creaturehealth'] > 0)
		output("`2`bNext round:`b`n");

	if ($badguy['creaturehealth']<=0){
		$victory=true;
		$defeat=false;
		break;
	}else{
		if ($session['user']['hitpoints']<=0){
			$defeat=true;
			$victory=false;
			break;
		}else{
			$defeat=false;
			$victory=false;
		}
	}
	if ($count != -1) $count--;
} while ($count > 0 || $count == -1);

$badguy['creaturehealth'] = round($badguy['creaturehealth'],0);
if ($session['user']['hitpoints']>0 && $badguy['creaturehealth']>0 && ($op=="fight" || $op=="run")){
	output("`2`bEnd of Round:`b`n");
	output("`2%s`2's Hitpoints: `6%s`0`n",$badguy['creaturename'],$badguy['creaturehealth']);
	output("`2YOUR Hitpoints: `6%s`0`n",$session['user']['hitpoints']);
}

if ($session['user']['hitpoints'] < 0) $session['user']['hitpoints'] = 0;

$session['user']['badguy']=createstring($badguy);
tlschema();
?>
