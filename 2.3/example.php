<?php

if (isset($_POST['push_button'])) {

    if (!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
        echo 'Error uploading file';
        exit();
    }

    $size = $_FILES["file"]["size"];

    if ($size > 1000000) {
        echo 'Exceeded size limit';
        exit();
    }

    $name = $_FILES["file"]["name"];
    $mimetype = $_FILES["file"]["type"];

    if ($mimetype == "text/plain") {

        header('Content-type: text/plain');
    } else if ($mimetype == "image/jpeg") {

        header('Content-type: image/jpeg');
    } else if ($mimetype == "image/png") {

        header('Content-type: image/png');
    } else {
        header('Content-type: text/plain');

        echo "Name: " . $name . "\nType: " . $mimetype . "\nSize: " . $size . "Kb";
        exit();
    }

    echo file_get_contents($name);
}
