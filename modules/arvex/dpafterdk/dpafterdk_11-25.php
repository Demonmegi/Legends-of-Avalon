<?php
$max2 = get_module_setting("maxdp2");
			$dp = e_rand(10,$max2);
			Output(" `n`@Du erh�lst auch `^%s `@DonationPoints f�r deinen Sieg �ber den Drachen!`n", $dp);
			$session['user']['donation']+=$dp;
?>