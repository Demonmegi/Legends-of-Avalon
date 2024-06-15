<?PHP
	//Libary - notify superusers
	function notifysuperuser($subject, $body, $sulevel) {
		$sql = "SELECT acctid FROM " . db_prefix("accounts") . " WHERE superuser & $sulevel > 0";
		$result = db_query($sql);
		require_once("lib/systemmail.php");
		while($row = db_fetch_assoc($result)) {
			systemmail($row['acctid'], $subject, $body);
		}
	}
?>