<?php

//This program stores a random session id using SESSION array
session_start(); //we start the session and get all of its values

$html = file_get_contents("example.html"); //reading the html page

$_SESSION['session-id'] = rand(); //generating random session id and storing it inside the SESSION array 

//replacing the session id string inside the html document with the stored session id by accessing it via SESSION array
$html = str_replace('---session-id---', $_SESSION['session-id'], $html); 

echo  $html; //echoing back the new html page
