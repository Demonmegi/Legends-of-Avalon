<?php
	global $session;
	$op = httpget('op');
	page_header("The Head");
	if ($op == "tinkle"){
		set_module_pref("usedouthouse",1);
		output("You use the fine facilities here.`n");
		if (get_module_pref('drunkeness','drinks')>0){
					$drunktmp=get_module_pref('drunkeness','drinks');
					$drunktmp*=.9;
					set_module_pref('drunkeness',$drunktmp,'drinks');
					set_module_pref('bladder',0,'bladder');
					output("`&You feel a little more sober!`n`0");
				}else{
					if (get_module_pref('bladder') > 0){
						output("`&You feel a little better now.`n");
						set_module_pref('bladder',0,'bladder');
					}else{
						output("`&Try as you might, you cannot summon even a drop.`n");
					}
				}
	}else{
		 if (get_module_pref("usedouthouse")==0){
          output("`2You step into the Head.  The odor in here just about knocks you over. ");
          output("Best to get your business done and get back to more enjoyable activities. `n");
          addnav("Tinkle","runmodule.php?module=bladder&op=tinkle");
        }else{
          output("`2You really don't have anything left to relieve today!");
        }
	}
	addnav("Back to the Inn","inn.php");
	page_footer();
?>