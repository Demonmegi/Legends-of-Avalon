<?php

// Make PHP know about the memory limit.
// Please note, this will not work if you are running in safe mode.
// If you are, then you will need to find some other way of increasing
// your memory limit.   This increase is needed because when going to
// install all modules, it is very possible to blow out this memory as
// it tries to load and compile every selected module file.
// Of course, people shouldn't be doing that, but people seem to think
// that more is better always, even when it's not.  Just blame it on the
// 'supersize society' we live in.
ini_set("memory_limit","1024M");
ini_set("max_execution_time", "90");

// We'll also add some tiny handler here to force the server to run through 
// every script until its end, even if the user aborts page generation before
// it is finished.
// This might be an issue in some cases when a user clicks faster than his 
// browser / the server is working.
ignore_user_abort(true);

// Stuff only useful yor our server:
// setlocale(LC_ALL, 'de_DE.ISO-8859-1');
?>
