<?PHP
//Supportdatei für das automatische erstellen eines Vorschau- oder Textfensters mit Farbdarstellung

//Erzeugt das Javascript für die Funktionsdarstellung
function WriteColorFunction() {

}

//Funtionsaufbau identisch zur PReviewField aus der Forms, nur um die Funktionen für das Klicken ergänzt.
function CreateColorPreview($name,
                            $startdiv=false,
                            $talkline="says",
                            $charsleft=true,
                            $info=false,
                            $allowspecial=false,
                            $default=false, $showcolors=true, $showusername=true) {
    
    require_once('lib/forms.php');
    static $colors = array();
    
    if ($showcolors==true || $showusername==true) {
        rawoutput("<script language='JavaScript'>");
        rawoutput("	function addColor(insText, elementid) {
                        var input = document.getElementById(elementid);
                        input.focus();
                        if(typeof document.selection != 'undefined') {
                            /* Einfügen des Formatierungscodes */
                            var range = document.selection.createRange();
                            range.text = insText;
                            /* Anpassen der Cursorposition */
                            range = document.selection.createRange();
                            if (insText.length == 0) {
                              range.move('character', 0);
                            } else {
                              range.moveStart('character', insText.length);      
                            }
                            range.select();
                        }
                        /* für neuere auf Gecko basierende Browser */
                        else if(typeof input.selectionStart != 'undefined') {
                            /* Einfügen des Formatierungscodes */
                            var start = input.selectionStart;
                            var end = input.selectionEnd;
                            input.value = input.value.substr(0, start) + insText + input.value.substr(start);
                            /* Anpassen der Cursorposition */
                            var pos;
                            if (insText.length == 0) {
                              pos = start;
                            } else {
                              pos = start + insText.length;
                            }
                            input.selectionStart = pos;
                            input.selectionEnd = pos;
                            document.getElementById(elementid)=input.value;
                        }
                    }
        ");
        rawoutput("</script>");
    
        static $colors = array(
		"&" => "colLtWhite",
		"j" => "colMdGrey",
		"7" => "colDkWhite",
		")" => "colLtBlack",
		"B" => "colmousegrey",
		"(" => "colsparkgray",
		"~" => "colBlack", 
		"X" => "colbeige",
		"a" => "collightyellow",
		"^" => "colLtYellow",
		"s" => "collightorange",
		"Q" => "colLtOrange",
		"A" => "coldarkorange",
		"\$" => "colLtRed",
		"[" => "colbrickred",
		"U" => "colclottedred",
		"C" => "collightrottenred",
		"4" => "colDkRed",
		"8" => "colMedRed",
		"]" => "colsweetred",
		"f" => "colcandyred",
		"g" => "colXLtGreen",
		"G" => "colpeppermint",
		"@" => "colLtGreen",
		"2" => "colDkGreen",
		"h" => "colfir",
		"W" => "coldarkfir",
		"z" => "collightfir",
		"K" => "coldarkseagreen",
		"?" => "colblueishgreen",
		"3" => "colDkCyan",
		"k" => "colaquamarine",
		"N" => "colflashymint",
		"#" => "colLtCyan",
		"Z" => "colskyblue",
		"L" => "colLtLinkBlue",
		"l" => "colDkLinkBlue",
		"+" => "colmoredarkblue",
		"!" => "colLtBlue",
		"J" => "colMdBlue",
		"1" => "colDkBlue",
		"p" => "collightsalmon",
		"P" => "colsalmon",
		"€" => "coltomatoered",
		"R" => "colRose",
		"r" => "colbabypink",
		"%" => "colLtMagenta",
		"5" => "colDkMagenta",
		"u" => "coldarklilac",
		"*" => "colblueishpurple",
		"-" => "colsweetspurple",
		"v" => "coliceviolet",
		"V" => "colBlueViolet",
		"_" => "colelearapurple",
		"d" => "collightlilac",
		"m" => "colwheat",
		"M" => "coltan",
		"9" => "colclaybrown",
		"x" => "colburlywood",
		"E" => "colLtRust",
		"e" => "colDkRust",
		"D" => "colmiddlebrown",
		"T" => "colDkBrown",
		"I" => "colrottenred",
		"q" => "colDkOrange",
		"t" => "colLtBrown",
		"y" => "colkhaki",
		"Y" => "coldarkkhaki",
		"6" => "colDkYellow",
		"S" => "collightmallow",
		"o" => "colmallow",
		"O" => "coldarkmallow",
        );
    }
    if ($showcolors==true) {
        $break=0;
        foreach($colors as $key=>$val) {
            $break++;
            rawoutput("<a class='$val' href='#colors' onClick='addColor(\"`$key\", \"input" . $name . "\");'>$key</a>");
            if ($break==30) {
                rawoutput("<br>");
                $break=0;
            }
        } 
    }
    if ($showusername==true) {
	//Eigener Name
        output_notl("");
        global $session;
        $username=$session['user']['name'];
    	rawoutput("<a name='colors' href='#colors' onClick='addColor(\"$username\", \"input" . $name . "\");'>");
        output_notl($username);
        rawoutput("</a>");
    }
    rawoutput("<br>");
    previewfield($name,$startdiv,$talkline,$charsleft,$info,$allowspecial,$default);
}
