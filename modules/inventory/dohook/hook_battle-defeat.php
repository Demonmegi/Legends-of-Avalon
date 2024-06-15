<?php
	require_once("lib/itemhandler.php");
	static $runonce = false;
	if ($runonce === false) {
		$inventory = get_inventory();
		$count=0;
		$removeables = array();
		while($item = db_fetch_assoc($inventory)) {
			if ($item['loosechance'] == 100) {
				$removeables[$item['itemid']] = $item['quantity'];
			} else if($item['loosechance'] != 0) {
				for($i=0;$i<$item['quantity'];++$i){
					if(e_rand(1,100) < $item['loosechance']) {
						$removeables[$item['itemid']]++;
					}
				}
			}
		}
		foreach ($removeables as $itemid => $qty) {
			remove_item((int)$itemid, $qty);
			$count += $qty;
		}
		if ($count == 1) {
			output("`n`\$One of your items got damaged during the fight. ");
		} else if ($count > 1) {
			output("`n`\$Overall `^%s`\$ of your items have been damaged during the fight.", $count);
		}
		$runonce = true;
	}
?>