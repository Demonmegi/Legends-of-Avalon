<?php
$max1 = get_module_setting("maxdp1");
			$dp = e_rand(1,$max1);
			Output(" `n`@Du erhälst auch `^%s `@DonationPoints für deinen Sieg über den Drachen!`n", $dp);
			$session['user']['donation']+=$dp;
?>