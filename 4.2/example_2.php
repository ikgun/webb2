<?php

header('Content-type: text/plain');

if (isset($_COOKIE['session-id'])) {

    if (isset($_GET['button'])) {

        echo "name = " . $_GET['name'] . "\nsession-id = " . $_COOKIE['session-id'] . "\nbutton = " . $_GET['button'];
    } else {

        echo "session-id: " . $_COOKIE['session-id'];
    }
}
