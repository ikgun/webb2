<?php

//This program changes the session id value in the html page, so that the session id can be sent to the other program

$html = file_get_contents("example.html"); //the html page is read

$session_id = rand(); //a random session id is generated

/*the string that is going to be replaced with the randomly 
generated session id is replaced, the replaced string (the whole page) is returned back*/
$html = str_replace('---session-id---', $session_id, $html); 

echo  $html; //the replaced string is echoed back 
