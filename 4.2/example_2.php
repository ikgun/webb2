<?php

//This program prints the value using a cookie 
header('Content-type: text/plain'); //printing out text content

if (isset($_COOKIE['session-id'])) { //if the session id was stored inside the cookie

    if (isset($_GET['button'])) { //if user clicks on the submit button the form is sent

        echo "name = " . $_GET['name'] . "\nsession-id = " . $_COOKIE['session-id'] . "\nbutton = " . $_GET['button'];
    } else { //otherwise only the session id is printed and the value is reached from the COOKIE array

        echo "session-id: " . $_COOKIE['session-id'];
    }
}
