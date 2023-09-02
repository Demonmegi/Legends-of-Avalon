<?php
function race_creator_array_check($race=FALSE)
{
	//
	// Make sure that all the variables exist.
	//
	if( !is_array($race) ) $race = array();

	if( !isset($race['raceactive']) )					$race['raceactive'] = 0;
	if( !isset($race['racename']) )						$race['racename'] = '';
	if( !isset($race['raceauthor']) )					$race['raceauthor'] = '';
	if( !isset($race['raceid']) )						$race['raceid'] = 0;
	if( !isset($race['racevillage']) )					$race['racevillage'] = '';
	if( !isset($race['racecolour']) )					$race['racecolour'] = '`&';
	if( !isset($race['racechoose']) )					$race['racechoose'] = '';
	if( !isset($race['raceset']) )						$race['raceset'] = '';
	if( !isset($race['racenewday']) )					$race['racenewday'] = '';
	if( !isset($race['raceturns']) )					$race['raceturns'] = 0;
	if( !isset($race['racetravel']) )					$race['racetravel'] = 0;
	if( !isset($race['alter-gemchance']) )				$race['alter-gemchance'] = 0;
	if( !isset($race['pvpadjust']) )					$race['pvpadjust'] = '';
	if( !isset($race['creatureencounter']) )			$race['creatureencounter'] = '';
	if( !isset($race['battle-victory']) )				$race['battle-victory'] = '';
	if( !isset($race['battle-defeat']) )				$race['battle-defeat'] = '';
	if( !isset($race['module']) )						$race['module'] = '';
	if( !isset($race['rcbuff']) )						$race['rcbuff'] = array();
	if( !isset($race['rcbuff']['name']) )				$race['rcbuff']['name'] = '';
	if( !isset($race['rcbuff']['roundmsg']) )			$race['rcbuff']['roundmsg'] = '';
	if( !isset($race['rcbuff']['wearoff']) )			$race['rcbuff']['wearoff'] = '';
	if( !isset($race['rcbuff']['effectmsg']) )			$race['rcbuff']['effectmsg'] = '';
	if( !isset($race['rcbuff']['effectnodmgmsg']) )		$race['rcbuff']['effectnodmgmsg'] = '';
	if( !isset($race['rcbuff']['effectfailmsg']) )		$race['rcbuff']['effectfailmsg'] = '';
	if( !isset($race['rcbuff']['rounds']) )				$race['rcbuff']['rounds'] = 0;
	if( !isset($race['rcbuff']['allowinpvp']) )			$race['rcbuff']['allowinpvp'] = 0;
	if( !isset($race['rcbuff']['allowintrain']) )		$race['rcbuff']['allowintrain'] = 0;
	if( !isset($race['rcbuff']['atkmod']) )				$race['rcbuff']['atkmod'] = '';
	if( !isset($race['rcbuff']['defmod']) )				$race['rcbuff']['defmod'] = '';
	if( !isset($race['rcbuff']['invulnerable']) )		$race['rcbuff']['invulnerable'] = '';
	if( !isset($race['rcbuff']['regen']) )				$race['rcbuff']['regen'] = '';
	if( !isset($race['rcbuff']['minioncount']) )		$race['rcbuff']['minioncount'] = '';
	if( !isset($race['rcbuff']['minbadguydamage']) )	$race['rcbuff']['minbadguydamage'] = '';
	if( !isset($race['rcbuff']['maxbadguydamage']) )	$race['rcbuff']['maxbadguydamage'] = '';
	if( !isset($race['rcbuff']['mingoodguydamage']) )	$race['rcbuff']['mingoodguydamage'] = '';
	if( !isset($race['rcbuff']['maxgoodguydamage']) )	$race['rcbuff']['maxgoodguydamage'] = '';
	if( !isset($race['rcbuff']['lifetap']) )			$race['rcbuff']['lifetap'] = '';
	if( !isset($race['rcbuff']['damageshield']) )		$race['rcbuff']['damageshield'] = '';
	if( !isset($race['rcbuff']['badguydmgmod']) )		$race['rcbuff']['badguydmgmod'] = '';
	if( !isset($race['rcbuff']['badguyatkmod']) )		$race['rcbuff']['badguyatkmod'] = '';
	if( !isset($race['rcbuff']['badguydefmod']) )		$race['rcbuff']['badguydefmod'] = '';

	foreach( $race as $key => $value )
	{
		if( $key == 'rcbuff' )
		{
			//
			// Unarray the 'racebuff' array.
			//
			foreach( $value as $key2 => $value2 )
			{	// Will int destroy numbers with a decimal point?
				$race["rcbuff$key2"] = ( is_string($value2) ) ? stripslashes($value2) : (int)$value2;
			}
		}
		else
		{
			$race[$key] = ( is_string($value) ) ? stripslashes($value) : (int)$value;
		}
	}
	unset($race['rcbuff']);

	return $race;
}
?>