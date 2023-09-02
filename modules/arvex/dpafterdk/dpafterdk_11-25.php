<?php
$max2 = get_module_setting("maxdp2");
			$dp = e_rand(10,$max2);
			Output(" `n`@Du erhälst auch `^%s `@DonationPoints für deinen Sieg über den Drachen!`n", $dp);
			$session['user']['donation']+=$dp;
?>