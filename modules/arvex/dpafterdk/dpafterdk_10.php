<?php
$max1 = get_module_setting("maxdp1");
			$dp = e_rand(1,$max1);
			Output(" `n`@Du erh�lst auch `^%s `@DonationPoints f�r deinen Sieg �ber den Drachen!`n", $dp);
			$session['user']['donation']+=$dp;
?>