<?php

//This code snippet logs the user out of their account

session_start(); //start the session to be able to get session values from SESSION aray
session_unset(); //deleting all session keys and values
session_destroy(); //deleting the session
header('Location: ../html/welcome.html'); //sending the user back to homepage

?>