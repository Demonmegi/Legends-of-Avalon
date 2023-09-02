<?php
	$sql = "SELECT racename, racecolour
			FROM " . db_prefix('races') . "
			WHERE raceid = '$raceid'";
	$result = db_query($sql);
	$row = db_fetch_assoc($result);

	output('`n`2The following people have %s%s `2as their race.`0`n`n', $row['racecolour'], $row['racename']);

	$name = translate_inline('Name');
	$level = translate_inline('Level');
	$ops = translate_inline('Ops');
	$change = translate_inline('Change');
	rawoutput("<table border=0 cellpadding=2 cellspacing=1 bgcolor='#999999'>");
	rawoutput("<tr class=\"trhead\"><td>$name</td><td align=\"center\">$level</td>");

	rawoutput('</tr>');

	$sql = "SELECT acctid, name, level
			FROM " . db_prefix('accounts') . "
			WHERE race = '{$row['racename']}'";
	$result = db_query($sql);
	$i = 0;
	while( $row = db_fetch_assoc($result) )
	{
		rawoutput('<tr class="'.($i%2?'trlight':'trdark').'"><td>');
		output_notl('%s', $row['name']);
		rawoutput('</td><td align="center">');
		output_notl('%s', $row['level']);
		rawoutput('</td>');
		rawoutput('</tr>');
		$i++;
	}
	rawoutput('</table><br /><br />');

	addnav('Editor');
	addnav('Main Page',$from);
?>