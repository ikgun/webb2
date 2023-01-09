<?php

require_once "SleekDB-master/src/SleekDB.php";
use SleekDB\Store;

$databaseDirectory = __DIR__ . "/myDatabase";

$infoStore = new Store("info", $databaseDirectory);

$infoStore->insert($_SERVER);

header("Content-type: text/plain");

foreach ($infoStore->findAll() as $value) {

    foreach ($value as $key => $value2) {

        if($key == "REQUEST_TIME"){
            $requestTime = new DateTime("@$value2");
            $requestTime = date_modify($requestTime, "+1 hour");
            echo "TIME: " .$requestTime->format('Y-m-d H:i:s') . "\n";
        }
    
    }

    foreach ($value as $key => $value2) {

        if($key == "REMOTE_ADDR"){
            echo $key . ": " . $value2 . "\n";
        }
        
    }
    
    foreach ($value as $key => $value2) {
    
        if($key == "HTTP_USER_AGENT"){
            echo $key . ": " . $value2 . "\n";
        }
         
    }

    echo "\r\n";

}