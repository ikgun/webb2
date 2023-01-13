<?php

//This program echoes each key-value pair inside the SERVER array

foreach ($_SERVER as $key => $value) {

    header('Content-type: text/plain');
    echo $key . ': ' . $value . "\n";
}
