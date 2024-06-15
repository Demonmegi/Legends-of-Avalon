<?			switch($mode)
			{
			case "save":		//if you want to save a single translation from Edit+Insert
				require("./modules/translationwizard/save_single.php");
			break; //just in case
			
			case "picked": //save the picked one
				//$intext = str_replace("%", "%%", rawurldecode(httpget('intext')));
				//$outtext = str_replace("%", "%%", rawurldecode(httpget('outtext')));
				$intext=rawurldecode(httpget('intext'));
				$outtext=rawurldecode(httpget('outtext'));
				$login = rawurldecode(httpget('author'));
				$version = rawurldecode(httpget('version'));
				$sql = "SELECT * FROM " . db_prefix("untranslated") . " WHERE BINARY intext = '$intext' AND language = '$languageschema' AND namespace = '$namespace'";				
				$query=db_query($sql);
				$result=db_num_rows($query);
				if ($result==1)
					{
					$sql = "DELETE FROM " . db_prefix("untranslated") . " WHERE BINARY intext = '$intext' AND language = '$languageschema' AND namespace = '$namespace'";
					//debug($sql); break;				
					$result=db_query($sql);
					$sql2 = "INSERT INTO " . db_prefix("translations") . " (language,uri,intext,outtext,author,version) VALUES" . " ('$languageschema','$namespace','$intext','$outtext','$login','$version')";
					//debug($sql); 	
					$result2=db_query($sql2);
					redirect("runmodule.php?module=translationwizard&op=known_central"); //just redirecting so you go back to the previous page after the choice
					} else
					{
					output("There was an error while processing your selected translation.");
					output_notl(" ");
					output("Please edit the translation you selected manually or delete it.");
					output_notl(" ");
					output("This might be because of an situation like a '%D' in the translation which causes errors with this kind of insert.");
					output_notl("`n");
					output("%s rows were found for the given data",$result);
					output_notl("`n");
					output("Query:");
					rawoutput(htmlentities($sql)); 		
					}
			break;
			
			case "delete": //to delete one via the delete button
				//$intext= stripslashes(rawurldecode(httpget('intext')));
				//$intext = str_replace("%", "%%", rawurldecode(httpget('intext')));
				$intext=rawurldecode(httpget('intext'));
				$sql = "DELETE FROM " . db_prefix("untranslated") . " WHERE intext = '$intext' AND language = '$languageschema' AND namespace = '$namespace'";
				//debug($sql); break;
				db_query($sql);
				$mode=""; //reset
				redirect("runmodule.php?module=translationwizard&op=known_central"); //just redirecting so you go back to the previous page after the deletion
			break;
			
			default:
			$sql= "SELECT * FROM  ".db_prefix("temp_translations")." GROUP BY intext, uri, language;";
			$result = db_query($sql);
			output("`n`n %s rows are in your pulled translations table.`n`n",db_num_rows($result));
			if (db_num_rows($result)==0) //table is fine, no redundant rows
				{
				output("There are no entries in your pulled translations table!");
				output("`nPlease pull some first!!!");
				break;
				}
			output("It is recommended that you `%truncate `0your pulled translations table from time to time.`n`n");
			output("Pick the translation for the entry in the pulled translations table:`n`n");				
			rawoutput("<table border='0' cellpadding='2' cellspacing='0'>");
			rawoutput("<tr class='trhead'><td>". translate_inline("Language") ."</td><td>". translate_inline("Original") ."</td><td>".translate_inline("Module / Translation")."</td><td>".translate_inline("Author")."</td><td>".translate_inline("Actions")."</td><td></td></tr>");						
				$sql="Select ".db_prefix("untranslated").".intext, ".db_prefix("temp_translations").".language as t, ".db_prefix("untranslated").".language as u, ".db_prefix("temp_translations").".outtext,".db_prefix("temp_translations").".author,".db_prefix("untranslated").".namespace,".db_prefix("temp_translations").".version  from ".db_prefix("temp_translations").",".db_prefix("untranslated")." where ".db_prefix("temp_translations").".intext=".db_prefix("untranslated").".intext ORDER BY untranslated.intext";
				$result = db_query($sql);
				$alttext= "abcdefgh-dummy-dummy-dummy"; //hopefully this text is in no module to translate ;) as the first text
				if (db_num_rows($result)>0) 
					{
					while($row=db_fetch_assoc($result))
					{
					if ($row['t']==$row['u'] && $row['t']==$languageschema)
					{
					if ($alttext<>$row['intext'])
					{
					    $i++;
					    rawoutput("<tr class='trdark'>");
						rawoutput("<td>");
						rawoutput(htmlentities($row['t']));
						rawoutput("</td><td>");
						rawoutput(htmlentities($row['intext']));
						rawoutput("</td><td>");
						rawoutput(htmlentities($row['namespace']));								
						rawoutput("</td><td>");
						//rawoutput(htmlentities($row['author']));
						rawoutput("</td><td>");
						rawoutput("<a href='runmodule.php?module=translationwizard&op=known_central&mode=delete&ns=". rawurlencode($row['namespace']) ."&intext=". rawurlencode($row['intext'])."'>". translate_inline("Delete") ."</a>");
						addnav("", "runmodule.php?module=translationwizard&op=known_central&mode=delete&ns=". rawurlencode($row['namespace']) ."&intext=". rawurlencode($row['intext']));				
						rawoutput("</td><td>");
						rawoutput("</td></tr>");
					}
					$alttext=$row['intext'];					
					rawoutput("<tr class='trlight'>");
					rawoutput("<td>");
					rawoutput(htmlentities($row['language']));
					rawoutput("</td><td>");
					//rawoutput(htmlentities($row2['intext']));
					rawoutput("</td><td>");
					rawoutput(htmlentities($row['outtext']));								
					rawoutput("</td><td>");
					rawoutput(htmlentities($row['author']));
					rawoutput("</td><td>");
					rawoutput("<a href='runmodule.php?module=translationwizard&op=known_central&mode=picked&ns=". rawurlencode($row['namespace']) ."&intext=". rawurlencode($row['intext'])."&outtext=". rawurlencode($row['outtext'])."&author=". rawurlencode($row['author'])."&version=". rawurlencode($row['version']) ."'>". translate_inline("Choose") ."</a>");
					addnav("", "runmodule.php?module=translationwizard&op=known_central&mode=picked&ns=". rawurlencode($row['namespace']) ."&intext=". rawurlencode($row['intext'])."&outtext=". rawurlencode($row['outtext'])."&author=". rawurlencode($row['author'])."&version=". rawurlencode($row['version']));
					rawoutput("</td><td>");
					rawoutput("<a href='runmodule.php?module=translationwizard&op=edit_single&mode=save&from=".rawurlencode("module=translationwizard&op=known_central&ns=".$row['namespace'])."&ns=". rawurlencode($row['namespace']) ."&intext=". rawurlencode($row['intext'])."&outtext=". rawurlencode($row['outtext'])."&author=". rawurlencode($row['author'])."&version=". rawurlencode($row['version']) ."'>". translate_inline("Edit+Insert") ."</a>");
					addnav("", "runmodule.php?module=translationwizard&op=edit_single&mode=save&from=".rawurlencode("module=translationwizard&op=known_central&ns=".$row['namespace'])."&ns=". rawurlencode($row['namespace']) ."&intext=". rawurlencode($row['intext'])."&outtext=". rawurlencode($row['outtext'])."&author=". rawurlencode($row['author'])."&version=". rawurlencode($row['version']));						
					rawoutput("</td></tr>");
					if ($i>$page) break;  //would need previous/next page and one more if which needs too much time. better to get all now
					}
					}
				}
				rawoutput("</table>");
				if ($i==0) output("`nSorry, all rows in the pulled translations table have no match in any intext in your translations table.");
				}
?>