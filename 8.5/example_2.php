<?php

header('Content-type: text/plain');

if (isset($_COOKIE['session-id'])) {

    if (isset($_GET['button'])) {

        echo "name = " . $_GET['name'] . "\nsession-id-secure = " . $_COOKIE['session-id'] . "\nbutton = " . $_GET['button'];
    } else {

        echo "session-id-secure: " . $_COOKIE['session-id'];
    }
}
