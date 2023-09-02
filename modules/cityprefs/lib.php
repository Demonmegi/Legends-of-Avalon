<?php
function get_cityprefs_module($lookup,$value,$player=false)
{
	return 'city_creator';
}

function get_cityprefs_cityid($lookup,$value,$player=false)
{
	if( $player > 0 )
	{
		$sql = "SELECT location
				FROM " . db_prefix('accounts') . "
				WHERE acctid = $player";
		$res = db_query($sql);
		$row = db_fetch_assoc($res);
		$value = $row['location'];
	}

	$sql = "SELECT cityid
			FROM " . db_prefix('cities') . "
			WHERE cityname = '$value'";
	$res = db_query($sql);
	$row = db_fetch_assoc($res);
	return $row['cityid'];
}

function get_cityprefs_cityname($lookup,$value,$player=false)
{
	if( $player > 0 )
	{
		$sql = "SELECT location
				FROM " . db_prefix('accounts') . "
				WHERE acctid = $player";
		$res = db_query($sql);
		$row = db_fetch_assoc($res);
		return $row['location'];
	}

	$sql = "SELECT cityname
			FROM " . db_prefix('cities') . "
			WHERE cityid = '$value'";
	$res = db_query($sql);
	$row = db_fetch_assoc($res);
	return $row['cityname'];
}
?>