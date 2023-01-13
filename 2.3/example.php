<?php

//This program opens different content types

if (isset($_POST['push_button'])) { //if user clicks on submit

    //if the file does not exist among file names or if the file is not uploaded
    if (!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
        echo 'Error uploading file'; //the file was not uploaded so we exit
        exit();
    }

    $size = $_FILES["file"]["size"]; //if the file was upload we get its size first

    if ($size > 1000000) {
        echo 'Exceeded size limit'; //if file exceeds size limit we exit the program
        exit();
    }

    $name = $_FILES["file"]["name"]; //if everything is ok, we get the file name and its MIME type
    $mimetype = $_FILES["file"]["type"];

    //checking which content type the file has
    if ($mimetype == "text/plain") {

        header('Content-type: text/plain');
    } else if ($mimetype == "image/jpeg") {

        header('Content-type: image/jpeg');
    } else if ($mimetype == "image/png") {

        header('Content-type: image/png');
    } else { //if file does not have the specified content types we just print out info about the file
        header('Content-type: text/plain');

        echo "Name: " . $name . "\nType: " . $mimetype . "\nSize: " . $size . "Kb";
        exit(); 
    }

    echo file_get_contents($name); //we get the file contents and print out the contents
}
