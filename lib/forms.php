<?php
function previewfield($name, $startdiv=false, $talkline="says", $charsleft=true, $info=false, $allowspecial=false, $default=false, $charname = array()) {
	global $schema,$session;
	$talkline = translate_inline($talkline, $schema);
	$youhave = translate_inline("You have ");
	$charslefttxt = translate_inline(" characters left.");
	$blanccharid=get_module_setting("id","gamemaster");	

	$retval=modulehook("modifypreviewfield",array('defaultvalue'=>$default,'fieldname'=>$name));
	if (isset($retval)) {
		$default=$retval['defaultvalue'];
	}

	if ($startdiv === false) {
		$startdiv = "";
	}
		$llset=get_module_pref("user_showthislist","lastlocation");
	rawoutput("<script language='JavaScript'>
				function previewtext$name(t,l){");

	if (count($charname)>0) {
		rawoutput("var npcidx = document.getElementById('writingchar').selectedIndex;
					var npcvalue = document.getElementById('writingchar').value;
					var npcname = document.getElementById('writingchar').options[npcidx].text;
					var npc = new Array();");
		$i=0;
		foreach ($charname as $id=>$npcname) {
			rawoutput("npc[$i]=\"$npcname\";");
			$i++;
		}
	
		rawoutput("var out = \"<span class=\'colLtWhite\'>\"; 
					var end = '</span>';
					npcname=npc[npcidx];
					var x=0;
					var y='';
					var y1='';
					var z='';
					if (npcvalue != " . $blanccharid . ") {
						for (x=0; x < npcname.length; x++){
							y = npcname.substr(x,1);
							if (y=='`'){
								if (x < npcname.length-1){
									z = npcname.substr(x+1,1);
									if (z=='0'){
										out += '</span>';
									}else if (z=='1'){
										out += '</span><span class=\'colDkBlue\'>';
									}else if (z=='2'){
										out += '</span><span class=\'colDkGreen\'>';
									}else if (z=='3'){
										out += '</span><span class=\'colDkCyan\'>';
									}else if (z=='4'){
										out += '</span><span class=\'colDkRed\'>';
									}else if (z=='5'){
										out += '</span><span class=\'colDkMagenta\'>';
									}else if (z=='6'){
										out += '</span><span class=\'colDkYellow\'>';
									}else if (z=='7'){
										out += '</span><span class=\'colDkWhite\'>';
									}else if (z=='8'){
										out += '</span><span class=\'colMedRed\'>';
									}else if (z=='q'){
										out += '</span><span class=\'colDkOrange\'>';
									}else if (z=='!'){
										out += '</span><span class=\'colLtBlue\'>';
									}else if (z=='@'){
										out += '</span><span class=\'colLtGreen\'>';
									}else if (z=='#'){
										out += '</span><span class=\'colLtCyan\'>';
									}else if (z=='$'){
										out += '</span><span class=\'colLtRed\'>';
									}else if (z=='%'){
										out += '</span><span class=\'colLtMagenta\'>';
									}else if (z=='^'){
										out += '</span><span class=\'colLtYellow\'>';
									}else if (z=='&'){
										out += '</span><span class=\'colLtWhite\'>';
									}else if (z=='Q'){
										out += '</span><span class=\'colLtOrange\'>';
									}else if (z==')'){
										out += '</span><span class=\'colLtBlack\'>';
									}else if (z=='R'){
										out += '</span><span class=\'colRose\'>';
									}else if (z=='v'){
										out += '</span><span class=\'coliceviolet\'>';
									}else if (z=='V'){
										out += '</span><span class=\'colBlueViolet\'>';
									}else if (z=='g'){
										out += '</span><span class=\'colXLtGreen\'>';
									}else if (z=='T'){
										out += '</span><span class=\'colDkBrown\'>';
									}else if (z=='t'){
										out += '</span><span class=\'colLtBrown\'>';
									}else if (z=='~'){
										out += '</span><span class=\'colBlack\'>';
									}else if (z=='j'){
										out += '</span><span class=\'colMdGrey\'>';
									}else if (z=='J'){
										out += '</span><span class=\'colMdBlue\'>';
									}else if (z=='e'){
										out += '</span><span class=\'colDkRust\'>';
									}else if (z=='E'){
										out += '</span><span class=\'colLtRust\'>';
									}else if (z=='l'){
										out += '</span><span class=\'colDkLinkBlue\'>';
									}else if (z=='L'){
										out += '</span><span class=\'colLtLinkBlue\'>';
									}else if (z=='x'){
										out += '</span><span class=\'colburlywood\'>';
									}else if (z=='X'){
										out += '</span><span class=\'colbeige\'>';
									}else if (z=='y'){
										out += '</span><span class=\'colkhaki\'>';
									}else if (z=='Y'){
										out += '</span><span class=\'coldarkkhaki\'>';
									}else if (z=='k'){
										out += '</span><span class=\'colaquamarine\'>';
									}else if (z=='K'){
										out += '</span><span class=\'coldarkseagreen\'>';
									}else if (z=='p'){
										out += '</span><span class=\'collightsalmon\'>';
									}else if (z=='P'){
										out += '</span><span class=\'colsalmon\'>';
									}else if (z=='m'){
										out += '</span><span class=\'colwheat\'>';
									}else if (z=='M'){
										out += '</span><span class=\'coltan\'>';
									}else if (z=='('){
										out += '</span><span class=\'colsparkgray\'>';
									}else if (z=='a'){
										out += '</span><span class=\'collightyellow\'>';
									}else if (z=='s'){
										out += '</span><span class=\'collightorange\'>';
									}else if (z=='A'){
										out += '</span><span class=\'coldarkorange\'>';
									}else if (z=='['){
										out += '</span><span class=\'colbrickred\'>';
									}else if (z==']'){
										out += '</span><span class=\'colsweetred\'>';
									}else if (z=='f'){
										out += '</span><span class=\'colcandyred\'>';
									}else if (z=='G'){
										out += '</span><span class=\'colpeppermint\'>';
									}else if (z=='h'){
										out += '</span><span class=\'colfir\'>';
									}else if (z=='W'){
										out += '</span><span class=\'coldarkfir\'>';
									}else if (z=='z'){
										out += '</span><span class=\'collightfir\'>';
									}else if (z=='Z'){
										out += '</span><span class=\'colskyblue\'>';
									}else if (z=='r'){
										out += '</span><span class=\'colbabypink\'>';
									}else if (z=='u'){
										out += '</span><span class=\'coldarklilac\'>';
									}else if (z=='d'){
										out += '</span><span class=\'collightlilac\'>';
									}else if (z=='D'){
										out += '</span><span class=\'colmiddlebrown\'>';
									}else if (z=='S'){
										out += '</span><span class=\'collightmallow\'>';
									}else if (z=='o'){
										out += '</span><span class=\'colmallow\'>';
									}else if (z=='O'){
										out += '</span><span class=\'coldarkmallow\'>';
									}else if (z=='B'){
										out += '</span><span class=\'colmousegrey\'>';
									}else if (z=='I'){
										out += '</span><span class=\'colrottenred\'>';
									}else if (z=='C'){
										out += '</span><span class=\'collightrottenred\'>';	
									}else if (z=='U'){
										out += '</span><span class=\'colclottedred\'>';	
									}else if (z=='€'){
										out += '</span><span class=\'coltomatoered\'>';
									}else if (z=='N'){
										out += '</span><span class=\'colflashymint\'>';
									}else if (z=='?'){
										out += '</span><span class=\'colblueishgreen\'>';
									}else if (z=='*'){
										out += '</span><span class=\'colblueishpurple\'>';
									}else if (z=='+'){
										out += '</span><span class=\'colmoredarkblue\'>';
									}else if (z=='-'){
										out += '</span><span class=\'colsweetspurple\'>';
									}else if (z=='_'){
										out += '</span><span class=\'colelearapurple\'>';
									}else if (z=='9'){
										out += '</span><span class=\'colclaybrown\'>';

									}else if (z=='n'){
										out += '<br/>';
									}
									x++;
								}
							} else {
								out += y;
							}
						}
						out += \" \";
					}
					var end = '</span>';");
				} else {
					rawoutput("var out = \"<span class=\'colLtWhite\'>\"; ");
				}
				rawoutput("var end = '</span>';
					x=0;
					y='';
					z='';					
					var iopen=false;
					var bopen=false;
					var copen=false;
					var max=document.getElementById('input$name');
					var charsleft='';");
	if ($talkline !== false) {
		rawoutput("	if (t.substr(0,2)=='::'){
						x=2;
						out += '</span><span class=\'colLtWhite\'>';
					}else if (t.substr(0,1)==':'){
						x=1;
						out += '</span><span class=\'colLtWhite\'>';
					}else if (t.substr(0,3)=='/me'){
						x=3;
						out += '</span><span class=\'colLtWhite\'>';");

		if ($llset<>0) {
			rawoutput("}else if (t.substr(0,2)=='/x'){
						x=2;
						out = '</span><span class=\'colLtWhite\'>';");
		}
		if ($session['user']['superuser']&SU_IS_GAMEMASTER) {
			rawoutput("
					}else if (t.substr(0,5)=='/game'){
						x=5;
						out = '<span class=\'colLtWhite\'>';");
		}
		rawoutput("	}else{
						out += '</span><span class=\'colDkCyan\'>".addslashes(appoencode($talkline)).", \"</span><span class=\'colLtCyan\'>';
						end += '</span><span class=\'colDkCyan\'>\"';
					}");
	}
	if ($charsleft === true) {
		rawoutput("	if (x!=0) {
						if (max.maxLength!=5000) max.maxLength=5000;
						l=5000;
					} else {
						max.maxLength=l;
					}
					if (l-t.length<0) charsleft +='<span class=\'colLtRed\'>';
					charsleft += '".$youhave."'+(l-t.length)+'".$charslefttxt."<br>';
					if (l-t.length<0) charsleft +='</span>';
					document.getElementById('charsleft$name').innerHTML=charsleft+'<br/>';");
	}
	rawoutput("		for (; x < t.length; x++){
						y = t.substr(x,1);
						y1 = t.substr(x,2);

if (y1=='#[') {
	var color = t.substr(x+2,6);
	out += '</span><span style=\'color: #' + color + ';\'>';
	x=x+8;
}else if (y=='<'){
							out += '&lt;';
							continue;
						}else if(y=='>'){
							out += '&gt;';
							continue;
						}else if(y=='\\n'){
							out += '<br/>';
							continue;
						}else if(y=='\\r'){
							z = t.substr(x+1,1);
							if( z == '\\n' ){
								out += '<br/>';
								x++;
								continue;
							}
						}else if (y=='`'){
							if (x < t.length-1){
								z = t.substr(x+1,1);
								if (z=='0'){
									out += '</span>';
								}else if (z=='1'){
									out += '</span><span class=\'colDkBlue\'>';
								}else if (z=='2'){
									out += '</span><span class=\'colDkGreen\'>';
								}else if (z=='3'){
									out += '</span><span class=\'colDkCyan\'>';
								}else if (z=='4'){
									out += '</span><span class=\'colDkRed\'>';
								}else if (z=='5'){
									out += '</span><span class=\'colDkMagenta\'>';
								}else if (z=='6'){
									out += '</span><span class=\'colDkYellow\'>';
								}else if (z=='7'){
									out += '</span><span class=\'colDkWhite\'>';
								}else if (z=='8'){
									out += '</span><span class=\'colMedRed\'>';
								}else if (z=='q'){
									out += '</span><span class=\'colDkOrange\'>';
								}else if (z=='!'){
									out += '</span><span class=\'colLtBlue\'>';
								}else if (z=='@'){
									out += '</span><span class=\'colLtGreen\'>';
								}else if (z=='#'){
									out += '</span><span class=\'colLtCyan\'>';
								}else if (z=='$'){
									out += '</span><span class=\'colLtRed\'>';
								}else if (z=='%'){
									out += '</span><span class=\'colLtMagenta\'>';
								}else if (z=='^'){
									out += '</span><span class=\'colLtYellow\'>';
								}else if (z=='&'){
									out += '</span><span class=\'colLtWhite\'>';
								}else if (z=='Q'){
									out += '</span><span class=\'colLtOrange\'>';
								}else if (z==')'){
									out += '</span><span class=\'colLtBlack\'>';
								}else if (z=='R'){
									out += '</span><span class=\'colRose\'>';
								}else if (z=='v'){
									out += '</span><span class=\'coliceviolet\'>';
								}else if (z=='V'){
									out += '</span><span class=\'colBlueViolet\'>';
								}else if (z=='g'){
									out += '</span><span class=\'colXLtGreen\'>';
								}else if (z=='T'){
									out += '</span><span class=\'colDkBrown\'>';
								}else if (z=='t'){
									out += '</span><span class=\'colLtBrown\'>';
								}else if (z=='~'){
									out += '</span><span class=\'colBlack\'>';
								}else if (z=='j'){
									out += '</span><span class=\'colMdGrey\'>';
								}else if (z=='J'){
									out += '</span><span class=\'colMdBlue\'>';
								}else if (z=='e'){
									out += '</span><span class=\'colDkRust\'>';
								}else if (z=='E'){
									out += '</span><span class=\'colLtRust\'>';
								}else if (z=='l'){
									out += '</span><span class=\'colDkLinkBlue\'>';
								}else if (z=='L'){
									out += '</span><span class=\'colLtLinkBlue\'>';
								}else if (z=='x'){
									out += '</span><span class=\'colburlywood\'>';
								}else if (z=='X'){
									out += '</span><span class=\'colbeige\'>';
								}else if (z=='y'){
									out += '</span><span class=\'colkhaki\'>';
								}else if (z=='Y'){
									out += '</span><span class=\'coldarkkhaki\'>';
								}else if (z=='k'){
									out += '</span><span class=\'colaquamarine\'>';
								}else if (z=='K'){
									out += '</span><span class=\'coldarkseagreen\'>';
								}else if (z=='p'){
									out += '</span><span class=\'collightsalmon\'>';
								}else if (z=='P'){
									out += '</span><span class=\'colsalmon\'>';
								}else if (z=='m'){
									out += '</span><span class=\'colwheat\'>';
								}else if (z=='M'){
									out += '</span><span class=\'coltan\'>';
								}else if (z=='('){
									out += '</span><span class=\'colsparkgray\'>';
								}else if (z=='a'){
									out += '</span><span class=\'collightyellow\'>';
								}else if (z=='s'){
									out += '</span><span class=\'collightorange\'>';
								}else if (z=='A'){
									out += '</span><span class=\'coldarkorange\'>';
								}else if (z=='['){
									out += '</span><span class=\'colbrickred\'>';
								}else if (z==']'){
									out += '</span><span class=\'colsweetred\'>';
								}else if (z=='f'){
									out += '</span><span class=\'colcandyred\'>';
								}else if (z=='G'){
									out += '</span><span class=\'colpeppermint\'>';
								}else if (z=='h'){
									out += '</span><span class=\'colfir\'>';
								}else if (z=='W'){
									out += '</span><span class=\'coldarkfir\'>';
								}else if (z=='z'){
									out += '</span><span class=\'collightfir\'>';
								}else if (z=='Z'){
									out += '</span><span class=\'colskyblue\'>';
								}else if (z=='r'){
									out += '</span><span class=\'colbabypink\'>';
								}else if (z=='u'){
									out += '</span><span class=\'coldarklilac\'>';
								}else if (z=='d'){
									out += '</span><span class=\'collightlilac\'>';
								}else if (z=='D'){
									out += '</span><span class=\'colmiddlebrown\'>';
								}else if (z=='S'){
									out += '</span><span class=\'collightmallow\'>';
								}else if (z=='o'){
									out += '</span><span class=\'colmallow\'>';
								}else if (z=='O'){
									out += '</span><span class=\'coldarkmallow\'>';	
								}else if (z=='B'){
									out += '</span><span class=\'colmousegrey\'>';	
								}else if (z=='I'){
									out += '</span><span class=\'colrottenred\'>';			
								}else if (z=='C'){
									out += '</span><span class=\'collightrottenred\'>';	
								}else if (z=='U'){
									out += '</span><span class=\'colclottedred\'>';	
								}else if (z=='€'){
									out += '</span><span class=\'coltomatoered\'>';
								}else if (z=='N'){
									out += '</span><span class=\'colflashymint\'>';
								}else if (z=='?'){
									out += '</span><span class=\'colblueishgreen\'>';
								}else if (z=='*'){
									out += '</span><span class=\'colblueishpurple\'>';
								}else if (z=='+'){
									out += '</span><span class=\'colmoredarkblue\'>';
								}else if (z=='-'){
									out += '</span><span class=\'colsweetspurple\'>';
								}else if (z=='_'){
									out += '</span><span class=\'colelearapurple\'>';
								}else if (z=='9'){
									out += '</span><span class=\'colclaybrown\'>';
																		
									  
								}else if (z=='n'){
									out += '<br/>';
									
							

				");
	if ($allowspecial == true) {
		rawoutput("			} else if (z=='i'){
									if (iopen==false) {
										out += '<i>';
										iopen = true;
									} else {
										out += '</i>';
										iopen = false;
									}
								} else if (z=='b') {
									if (bopen==false) {
										out += '<b>';
										bopen = true;
									} else {
										out += '</b>';
										bopen = false;
									}
//								} else if (z=='c') {
//									if (copen==false) {
//										out += '<center>';
//										copen = true;
//									} else {
//										out += '</center>';
//										copen = false;
//									}
								} else if (z=='n') {
									out += '<br/>';
								} else if (z=='\\n') {
									out += '<br/>';
					");
	}
	rawoutput("				}
								x++;
							}
						}else{
							out += y;
						}
					}
					if (iopen == true) {
						end += '</i>';
					}
					if (bopen == true) {
						end += '</b>';
					}
					if (copen == true) {
						end += '</center>';
					}
					document.getElementById(\"previewtext$name\").innerHTML=out+end+'<br/>';
				}
				</script>
				");
	if ($charsleft === true) {
		rawoutput("<span id='charsleft$name'></span>");
	}
	if (!is_array($info)) {
		rawoutput("<input name='$name' id='input$name' maxlength='5000' onKeyUp='previewtext$name(document.getElementById(\"input$name\").value,5000);'>");
	} else {
		if (isset($info['maxlength'])) {
			$l = $info['maxlength'];
		} else {
			$l=5000;
		}
		if (isset($info['type']) && $info['type'] == 'textarea') {
			rawoutput("<textarea name='$name' id='input$name' onKeyUp='previewtext$name(document.getElementById(\"input$name\").value,$l);' ");
		} else {
			rawoutput("<input type='text' name='$name' id='input$name' onKeyUp='previewtext$name(document.getElementById(\"input$name\").value,$l);' ");
		}
		foreach ($info as $key=>$val){
			rawoutput("$key='$val'");
		}
		if (isset($info['type']) && $info['type'] == 'textarea') {
			rawoutput(">");
			if ($default !== false) {
				rawoutput($default);
			}
			rawoutput("</textarea>");
		} else {
			if ($default !== false) {
				rawoutput(" default='$default'>");
			} else {
				rawoutput(">");
			}
		}
	}
	rawoutput("<div id='previewtext$name'></div>");
}
?>
