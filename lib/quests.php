<?php

function add_questlog($q, $qstation) {
	global $session;
	$sql = "INSERT INTO questlog (userid, questname, reachingdate, queststation) VALUES (".$session['user']['acctid'].", '".$q."', '".date("Y-m-d H:i:s")."', ".$qstation.")";
	debug( $sql );
	db_query($sql);
}

function receive_reward($q) {
	global $session;

	$reward_exp = get_module_setting("reward_exp", $q) + (get_module_setting("reward_explevel", $q) * $session['user']['level']);
	$reward_gold = get_module_setting("reward_gold", $q) + (get_module_setting("reward_goldlevel", $q) * $session['user']['level']);
	$reward_gems = get_module_setting("reward_gems", $q);
	$reward_quest = get_module_setting("reward_quest", $q);
	$questpoint = get_module_pref("questpoint", "questbasics");

	if ($reward_exp > 0) output("`^Du erhältst `%%s`^ Erfahrungspunkte.`n", $reward_exp);
	if ($reward_gold > 0) output("`^Du erhältst `%%s`^ Goldstücke.`n", $reward_gold);
	if ($reward_gems > 0) output("`^Du erhältst `%%s`^ Edelsteine.`n", $reward_gems);
	if ($reward_quest > 0) output("`^Du erhältst `%%s`^ Questpunkte.`n", $reward_quest);

	$session['user']['experience'] += $reward_exp;
	$session['user']['gold'] += $reward_gold;
	$session['user']['gems'] += $reward_gems;
	set_module_pref("questpoint", $questpoint + $reward_quest, "questbasics");
	debuglog("gained %s experience, %s gold, %s gems and %s questpoints from the quest \"%s\".", $reward_exp, $reward_gold, $reward_gems, $rewardquestpoints, $q);

	$reward_code = get_module_setting("reward_code", $q);
	if ($reward_code <> "") eval($reward_code);
}

function start_quest($q) {
	$args=modulehook("queststarting",array("questname"=>$q,"allowed"=>true));
	if ($args["allowed"]!=false) {
		set_module_pref("questinprogress", true, "questbasics");
		set_module_pref("questinprogressname", $q, "questbasics");
		set_module_pref("queststarted", true, $q);
		set_module_pref("queststation", 1, $q);
		add_questlog($q, 1);
	}
}

function end_quest($q, $receivereward=true) {
	global $session;
	set_module_pref("questinprogress", false, "questbasics");
	set_module_pref("questinprogressname", "", "questbasics");
	set_module_pref("queststarted", false, $q);
	set_module_pref("queststation", -1, $q);
	set_module_pref("questscompleted", get_module_pref("questscompleted", "questbasics") + 1, "questbasics");
	if ($receivereward === true) receive_reward($q);
	$userid = $session['user']['acctid'];
	db_query("DELETE FROM questlog WHERE userid = $userid AND questname = '$q'");
	add_questlog($q, -1);
}

function end_quest_failure($q) {
	global $session;
	set_module_pref("questinprogress", false, "questbasics");
	set_module_pref("questinprogressname", "", "questbasics");
	set_module_pref("queststarted", false, $q);
	set_module_pref("queststation", -2, $q);
	$userid = $session['user']['acctid'];
	db_query("DELETE FROM questlog WHERE userid = $userid AND questname = '$q'");
	add_questlog($q, -2);
}

function advance_quest($q, $newqueststation = -3) {
	if ($newqueststation == -3) {
		$newqueststation = get_module_pref("queststation", $q) + 1;
		set_module_pref("queststation", $newqueststation, $q);
		add_questlog($q, $newqueststation);
	} else {
		set_module_pref("queststation", $newqueststation, $q);
		add_questlog($q, $newqueststation);
	}
}

function requirements_met($q) {
	global $session;

	$req_superuser = get_module_setting("req_superuser", $q);
	$req_minlevel = get_module_setting("req_min_lev", $q);
	$req_maxlevel = get_module_setting("req_max_lev", $q);
	$req_minhw = get_module_setting("req_min_hw", $q);
	$req_maxhw = get_module_setting("req_max_hw", $q);
	$req_mindk = get_module_setting("req_min_dk", $q);
	$req_maxdk = get_module_setting("req_max_dk", $q);
	$req_quest = get_module_setting("req_quest", $q);
	$gamescompleted = get_module_pref("gamescompleted", "wayofthehero");
	$qinprogress = get_module_pref("questinprogress", "questbasics");

	if ($qinprogress > 0)
		return 0;

	if ($session['user']['superuser'] > 0 && $req_superuser == true)
		return 1;

	if ($req_quest <> "")
		if (get_module_pref("queststation", $req_quest) < 0 )
			return 0;

	if($req_minlevel)
		if ($session['user']['level'] < $req_minlevel)
			return 0;

	if($req_maxlevel)
		if ($session['user']['level'] > $req_maxlevel)
			return 0;

	if($req_minhw)
		if ($gamescompleted < $req_minhw)
			return 0;

	if($req_maxhw)
		if ($gamescompleted > $req_maxhw)
			return 0;

	if($req_mindk)
		if ($session['user']['dragonkills'] < $req_mindk)
			return 0;

	if($req_maxdk)
		if ($session['user']['dragonkills'] > $req_maxdk)
			return 0;

	return 1;
}
?>
