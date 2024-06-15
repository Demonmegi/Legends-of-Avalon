<?php
// A set of "A.I." functions for monsters. 

function spawn($creatureid) {
	global $enemies, $newenemies, $badguy;
	$nextindex = count($enemies)+1;
	$sql = "SELECT * FROM " . db_prefix("creatures") . " WHERE creatureid = $creatureid LIMIT 1";
	$result = db_query($sql);
	if ($row = db_fetch_assoc($result)) {
		$newenemies[$nextindex] = $row;
		output("`^%s`2 summons `^%s`2 for help!`n", $badguy['creaturename'], $row['creaturename']);
	}
}

function heal($amount, $target=false) {
	global $newenemies, $enemies, $badguy;
	if ($amount > 0) {
		if ($target === false) {
			$badguy['creaturehealth']+=$amount;
			output("`^%s`2 heals itself for `^%s`2 hitpoints.", $badguy['creaturename'], $amount);
		} else {
			if (isset($newenemies[$target])) {
				// Target had its turn already...
				if ($newenemies[$target]['dead'] == false) {
					$newenemies[$target]['creaturehealth'] += $amount;
					output("`^%s`2 heal `^%s`2 for `^%s`2 hitpoints.", $badguy['creaturename'], $newenemies[$target]['creaturename'], $amount);
				}
			}else{
				if ($enemies[$target]['dead'] == false) {
					$enemies[$target]['creaturehealth'] += $amount;
					output("`^%s`2 heal `^%s`2 for `^%s`2 hitpoints.", $badguy['creaturename'], $enemies[$target]['creaturename'], $amount);
				}
			}
		}
	}				
}

function execute_ai_script($script) {
	if (is_numeric($script)) {
		$script = load_ai_script($script);
	} 
	if ($script > "") {
		eval($script);	
	}
}

function load_ai_script($scriptid) {
	if ($scriptid == 0) {
		return "";
	} else {
		$sql = "SELECT script FROM ".db_prefix("ai")." WHERE scriptid = $scriptid";
		$result = db_query($sql);
		$row = db_fetch_assoc($result);
		return $row['script'];
	}
}

?>