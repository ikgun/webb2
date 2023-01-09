<?php

header('Content-type: text/plain');

if (isset($_GET['session-id'])) {

    if (isset($_GET['button'])) {

        echo "name = " . $_GET['name'] . "\nsession-id = " . $_GET['session-id'] . "\nbutton = " . $_GET['button'];
    } else {

        echo "session-id: " . $_GET['session-id'];
    }
}
