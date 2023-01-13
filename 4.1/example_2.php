<?php

//This program takes the data sent by the first program and prints it out

header('Content-type: text/plain'); //we print out text content

if (isset($_GET['session-id'])) { //check if the session id was set in the previous program

    /*check if the user submitted form because thats the way how we are going to get the form data from the GET array*/
    if (isset($_GET['button'])) { 

        //echo the values
        echo "name = " . $_GET['name'] . "\nsession-id = " . $_GET['session-id'] . "\nbutton = " . $_GET['button'];

    } else {

        //if the form data was not submitted we will only print out the link data(that we fetch from the URL)
        echo "session-id: " . $_GET['session-id'];
    }
}
