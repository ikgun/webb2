<?php

//This program prints out the values by fetching them from the SESSION array

session_start(); //starting the session to be able to utilize the data

header('Content-type: text/plain'); //specifying content type to output correctly

if (isset($_SESSION['session-id'])) { //if the session id was set inside the SESSION array 

    if (isset($_GET['button'])) { //if the user clicks on the submit button and sends the form

        //print out the values using the GET and SESSION arrays
        echo "name = " . $_GET['name'] . "\nsession-id = " . $_SESSION['session-id'] . "\nbutton = " . $_GET['button'];

    } else {

        //otherwise print only the session id inside the SESSION array as the GET array is empty
        echo "session-id: " . $_SESSION['session-id'];
    }
}
