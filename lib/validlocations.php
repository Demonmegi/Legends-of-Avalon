<?PHP
	function getvalidlocations() {
		$validlocations=array();
		//g++ltige Standorte aus Tabelle abfragen
		$validlocations[]="'" . addslashes(getsetting("villagename", LOCATION_FIELDS)) . "'";
		$validlocations[]="'" . addslashes(get_module_setting("villagename", "racedwarf")) . "'";
		$validlocations[]="'" . addslashes(get_module_setting("villagename", "raceelf")) . "'";
		$validlocations[]="'" . addslashes(get_module_setting("villagename", "racehuman")) . "'";
		$validlocations[]="'" . addslashes(get_module_setting("villagename", "racetroll")) . "'";
		$validlocations[]="'" . addslashes(get_module_setting("villagename", "racesaur")) . "'";
		$validlocations[]="'" . addslashes(get_module_setting("villagename", "oasis")) . "'";
	$validlocations[]="'" . addslashes(get_module_setting("villagename", "harbour")) . "'";
		$validlocations[]="'" . addslashes(get_module_setting("villagename","ilshaldren")) . "'";
		$validlocations[]="'" . addslashes(getsetting("innname", LOCATION_INN)) . "'";
		$validlocations[]="'Im Haus'";
		return $validlocations;
	}
?>