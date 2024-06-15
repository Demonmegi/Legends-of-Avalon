<?php
function light_textbox($name, $cols=50, $rows=15, $maxlength=500, $default=false) {
	global $schema,$session;
	$youhave = translate_inline("You have ");
	$charslefttxt = translate_inline(" characters left.");

	rawoutput("<script language='JavaScript'>
				function previewtext$name(t,l){
					var out = \"<span class=\'colLtWhite\'>\";
					var end = '</span>';
					var x=0;
					var y='';
					var z='';
					var max=document.getElementById('input$name');
					var charsleft='';
					if (x!=0) {
						if (max.maxLength!=500) max.maxLength=500;
						l=500;
					} else {
						max.maxLength=l;
					}
					if (l-t.length<0) charsleft +='<span class=\'colLtRed\'>';
					charsleft += '".$youhave."'+(l-t.length)+'".$charslefttxt."<br>';
					if (l-t.length<0) charsleft +='</span>';
					document.getElementById('charsleft$name').innerHTML=charsleft+'<br/>';
				}
				</script>");
	rawoutput("<span id='charsleft$name'></span>");
	rawoutput("<textarea name='$name' id='input$name' onKeyUp='previewtext$name(document.getElementById(\"input$name\").value,$maxlength);'  cols='$cols' rows='$rows'>");
	if ($default !== false) rawoutput($default);
	rawoutput("</textarea>");
}
?>
