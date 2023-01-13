<?php

//This program stores the session id inside a secure cookie

$html = file_get_contents("example.html"); //read html page

$session_id = rand(); //generate random session id

$html = str_replace('---session-id-secure---', $session_id, $html); //replace the string inside html document with new ID

//store the new ID inside a secure cookie
setcookie('session-id', $session_id, time() + 3 * 60 * 60, null, null, true, true);

echo  $html; //print out the new page
