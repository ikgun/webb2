<?php

//This program prints out 3 values from the SERVER array that was added to a lightweight db called SleekDB

require_once "SleekDB-master/src/SleekDB.php";
use SleekDB\Store;

$databaseDirectory = __DIR__ . "/myDatabase"; //creating a db

$infoStore = new Store("info", $databaseDirectory); //adding a table to the db

$infoStore->insert($_SERVER); //inserting all of the values of SERVER array to the table

header("Content-type: text/plain"); //specifying the content type to be output

foreach ($infoStore->findAll() as $value) { // traverse each data document being inserted to the db (in JSON)
    
    //inside each document there is the SERVER values in JSON format, travsersing through all server values
    //we are looking after the request time, remote addr, and http user agent values

    foreach ($value as $key => $value2) { 
        if($key == "REQUEST_TIME"){ //if key equals request time
            $requestTime = new DateTime("@$value2"); //create a new datetime object out of the time specified as request_time's value
            $requestTime = date_modify($requestTime, "+1 hour"); // adding 1 hour as there is timezone difference 
            echo "TIME: " .$requestTime->format('Y-m-d H:i:s') . "\n"; //formatting the time and printing out
        }
    
    }

    foreach ($value as $key => $value2) {

        if($key == "REMOTE_ADDR"){ //if key matches remote_Addr key of server array
            echo $key . ": " . $value2 . "\n"; //echo the key name and its value
        }
        
    }
    
    foreach ($value as $key => $value2) {
    
        if($key == "HTTP_USER_AGENT"){//if keys match 
            echo $key . ": " . $value2 . "\n";//echo the key name and its value
        }
         
    }

    echo "\r\n"; //make new line after printed values

}

//the above code will repeat itself every time someone opens the page