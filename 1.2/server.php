<?php

foreach ($_SERVER as $key => $value) {

    header('Content-type: text/plain');
    echo $key . ': ' . $value . "\n";
}
