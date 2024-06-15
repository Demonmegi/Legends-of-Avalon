<?php
require_once("lib/pullurl.php");
$lookfor=httppost('lookfor');
rawoutput("<form action='runmodule.php?module=translationwizard&op=lookup' method='post'>");
addnav("", "runmodule.php?module=translationwizard&op=lookup");
rawoutput("<input id='input' name='lookfor' width=55>");
rawoutput("<input type='submit' name='select' value='". translate_inline("Search")."' class='button'>");
rawoutput("</form>");
//$lookfor="bush";
if ($lookfor) $lookup=pullurl("http://dict.leo.org/?lp=ende&lang=en&search=$lookfor");
//debug($lookup); </td><td>". translate_inline("Namespace") ."</td><td>".translate_inline("# of rows")."</td><td>".translate_inline("Actions")."
/*while(list($key,$val) = each($lookup))
{
	output_notl($key.":");
	rawoutput(htmlentities($val));
	output_notl("`n");
}*/
rawoutput("<table border='0' cellpadding='2' cellspacing='0'>");
rawoutput("<tr class='trhead'><td></td></tr>");
rawoutput($lookup[827]);
rawoutput("</td></tr>");
rawoutput("</table>");


?>