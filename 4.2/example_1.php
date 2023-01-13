<?php

//This program stores the session id inside a cookie

$html = file_get_contents("example.html"); //we read the html page

$session_id = rand(); //create a random session id

$html = str_replace('---session-id---', $session_id, $html); //replace the session id string with the id value

//create a cookie to hold the session id value for 3 hours
setcookie('session-id', $session_id, time() + 3 * 60 * 60); 

echo  $html; //echo back the page to show
