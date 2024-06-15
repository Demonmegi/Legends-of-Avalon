<?			switch ($mode)
				{
				case "truncate":
					$sql = "TRUNCATE TABLE ".db_prefix("temp_translations").";";
					$result = db_query($sql);
					output("Pulled translations table has been truncated.");
					break;

				default:  //if the user hits the button just to check for duplicates
					rawoutput("<form action='runmodule.php?module=translationwizard&op=truncate_central&mode=truncate' method='post'>");
					addnav("", "runmodule.php?module=translationwizard&op=truncate_central&mode=truncate");

					output("`0This operation will truncate the pulled translations table.`n`n`b`$ This operation can't be made undone!`b`0`n`n");
					rawoutput("<input type='submit' value='". translate_inline("Execute") ."' class='button'>");
					break;
				}
?>