<?php
$max3 = get_module_setting("maxdp3");
			$dp = e_rand(15,$max3);
			Output(" `n`@Du erh�lst auch `^%s `@DonationPoints f�r deinen Sieg �ber den Drachen!`n", $dp);
			$session['user']['donation']+=$dp;
?>