<?php
// addnews ready
// translator ready
// mail ready
// Set error reporting to all but notice (for now)
error_reporting (E_ALL ^ E_NOTICE);
#error_reporting (E_ALL);

// function set_magic_quotes(&$vars) {
// 	if (is_array($vars)) {
// 		foreach ($vars as $key=>$val) {
// 			set_magic_quotes($vars[$key]);
// 		}
// 	}else{
// 		$vars = addslashes($vars);
// 	}
// }


// //do some cleanup here to make sure magic_quotes_gpc is ON
// if (!get_magic_quotes_gpc()){
// 	set_magic_quotes($_GET);
// 	set_magic_quotes($_POST);
// 	set_magic_quotes($_SESSION);
// 	set_magic_quotes($_COOKIE);
// 	set_magic_quotes($HTTP_GET_VARS);
// 	set_magic_quotes($HTTP_POST_VARS);
// 	set_magic_quotes($HTTP_COOKIE_VARS);
// 	ini_set("magic_quotes_gpc",1);
// }

// // magic_quotes_runtime is OFF
// // Check if magic_quotes_runtime is active
// if(get_magic_quotes_runtime())
// {
//     // Deactivate
//     //set_magic_quotes_runtime(false);
// }
?>
