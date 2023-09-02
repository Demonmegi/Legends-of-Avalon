<?php
tlschema("faq");
popup_header("Anleitung wie Text formatiert wird");
$c = translate_inline("Return to Contents");
rawoutput("<a href='petition.php?op=faq'>$c</a><hr>");

output("Wichtig: Vor jeder Codeeingabe den Prefix \"`\" anwenden.`n`n");
output("`00 Farbigen Text neutralisieren`n`n");
output("`11 Dunkelblau`n`n");
output("`!! Indigo`n`n");
output("`22 Gruen`n`n");
output("`@@ Hellgruen`n`n");
output("`33 Blaugruen`n`n");
output("`## Hellblau`n`n");
output("`44 Rot`n`n");
output("`$$ Leuchtendes Rot`n`n");
output("`55 Lila`n`n");
output("`%% Fuchsia`n`n");
output("`66 Gold`n`n");
output("`^^ Gelb`n`n");
output("`77 Grau`n`n");
output("`&& Weiss`n`n");
output("`)) Dunkelgrau`n`n");
output("`qq Braun`n`n");
output("`QQ Orange`n`n");
output("`ee Umbra`n`n");
output("`EE Helles Umbra`n`n");
output("`RR Rosa`n`n");
output("`tt Tan`n`n");
output("`TT Dunkles Umbra`n`n");
output("`YY Dunkles Khaki`n`n");
output("`pp Pfirsich`n`n");
output("`PP Dunkler Pfirsich`n`n");
output("`gg Hellgruen`n`n");
output("`jj Hellgrau`n`n");
output("`JJ Dunkelblau`n`n");
output("`kk Hellblaugruen`n`n");
output("`KK Olive`n`n");
output("`ll Blau`n`n");
output("`LL Hellblau`n`n");
output("`xx Creme`n`n");
output("`XX gebrochenes Weiss`n`n");
output("`vv Heller Lavendel`n`n");
output("`VV Lavendel`n`n");
output("`mm Heller Sand`n`n");
output("`MM Sand`n`n");

output("`0`bb Fett`n`n");
output("`ii Kursivschrift`n`n");
output("`cc Mitte`n`n");

output("`nn Eingabe/Enter`n`n");

rawoutput("<hr><a href='petition.php?op=faq'>$c</a>");
?>