<?php

session_start();

header('Content-type: text/plain');

if (isset($_SESSION['session-id'])) {

    if (isset($_GET['button'])) {

        echo "name = " . $_GET['name'] . "\nsession-id = " . $_SESSION['session-id'] . "\nbutton = " . $_GET['button'];
    } else {

        echo "session-id: " . $_SESSION['session-id'];
    }
}
