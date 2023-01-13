<?php

//This program prints out the values using the GET and COOKIE arrays
header('Content-type: text/plain'); //specifying content type

if (isset($_COOKIE['session-id'])) { //if the session id was stored inside cookie array

    if (isset($_GET['button'])) { //if user submits the form

        //the form send the data to the GET array as its method is get, using GET and COOKIE arrays print out
        //values
        echo "name = " . $_GET['name'] . "\nsession-id-secure = " . $_COOKIE['session-id'] . "\nbutton = " . $_GET['button'];
    } else {
        //if user does not submit the form we only have the COOKIE array we use it to store and fetch session id value
        //and print it
        echo "session-id-secure: " . $_COOKIE['session-id'];
    }
}
