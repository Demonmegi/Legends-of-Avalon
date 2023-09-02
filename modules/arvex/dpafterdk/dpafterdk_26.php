<?php
$max3 = get_module_setting("maxdp3");
			$dp = e_rand(15,$max3);
			Output(" `n`@Du erhälst auch `^%s `@DonationPoints für deinen Sieg über den Drachen!`n", $dp);
			$session['user']['donation']+=$dp;
?>