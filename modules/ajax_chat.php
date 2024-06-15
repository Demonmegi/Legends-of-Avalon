<?PHP
function ajax_chat_getmoduleinfo(){
	$info = array(
		"name"=>"Chatrefresh Tool",
		"version"=>"1.0",
		"author"=>"`2R`@o`ghe`2n `Qvon `2Fa`@lk`genbr`@uch`&",
		"category"=>"General",
		"download"=>"",
		"prefs"=>array(
		    "Ajax-Optionen,title",
		    "script"		=>"Scriptname",
		    "request"		=>"Requesturl",
		    "user_autorefresh"	=>"Aktiviere automatisches Update der Chats,bool|false",
		    "allowednavs"	=>"Meine Navs als Array",
		     "activatetime"	=>"Last refresh for timeout"
		)
	);
	return $info;
}

function ajax_chat_install(){
	// module_addhook("everyfooter");
	module_addhook("insertcomment");
	return true;
}

function ajax_chat_uninstall(){
	return true;
}

function ajax_chat_dohook($hookname,$args){
	global $session, $navbysection;
	switch($hookname){
		// case "everyfooter":
			// foreach ($navbysection as $val) { foreach ($val as $v) { call_user_func_array("private_addnav",$v); }}
			// set_module_pref("allowednavs",serialize($session['allowednavs']));
			// break;
		case "insertcomment":
		    $active=(bool)get_module_pref("user_autorefresh");
		    if ($active==true) {
			// set_module_pref("location",$args['section']);
			set_module_pref("script",$_SERVER['SCRIPT_NAME']);
			set_module_pref("request",$_SERVER['REQUEST_URI']);
			set_module_pref("activatetime",strtotime("now"));
					
			rawoutput("<script language='JavaScript'>");
			// rawoutput("window.setInterval(function() {getContentRequest();}, 10000);");
			rawoutput("window.setInterval(function() {getMailRequest(); getContentRequest();}, 10000);");
			rawoutput("function getMailRequest() {
				    var xmlhttp = null;
				    var retDate = '" . date("Y-m-d H:i:s") . "';
				    // Mozilla
				    if (window.XMLHttpRequest) {
					xmlhttp = new XMLHttpRequest();
				    }
				    // IE
				    else if (window.ActiveXObject) {
					xmlhttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
				    }
				    xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					    document.getElementById('mail').innerHTML=xmlhttp.responseText;
					}
				    }
				    
				    xmlhttp.open('GET', 'ajax.php?op=mail&t=' + Math.random() , true);
				    xmlhttp.send();
				    
				    
				}");
			rawoutput("function getContentRequest() {
				    var xmlhttp = null;
				    var retDate = '" . date("Y-m-d H:i:s") . "';
				    // Mozilla
				    if (window.XMLHttpRequest) {
					xmlhttp = new XMLHttpRequest();
				    }
				    // IE
				    else if (window.ActiveXObject) {
					xmlhttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
				    }
				    xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					    document.getElementById('commentary').innerHTML=xmlhttp.responseText;
					}
				    }
				    
				    xmlhttp.open('GET', 'ajax.php?op=content&section=" . $args['section'] . "&t=' + Math.random() , true);
				    xmlhttp.send();
				    
				    
				}");
			rawoutput("</script>");
		    }
		    break;

		
	}
	return $args;
}


function ajax_chat_run(){
}
?>