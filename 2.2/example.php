<?php

//This program outputs the user generated values with two different ways, post and get

header("Content-type: text/plain");

if (isset($_POST['post'])) { // if user clicks submit button which is sent by post method

    //all values posted with the form are fetched from the POST array
    echo "hidden: ".$_POST['hidden'];

    if(strlen($_POST['text'])>0){
        echo "\ntext: ".$_POST['text'];
    }

    if(strlen($_POST['text_area'])>0){
        echo "\ntextarea: ".$_POST['text_area'];

    }

    if(isset($_POST['cbox'])){
        echo "\ncheckbox: ".$_POST['cbox'];
    }

    if(isset($_POST['radio_button'])){
        echo "\nradio: ".$_POST['radio_button'];
    }
    
    echo "\nselect: ".$_POST['select']."\nsubmit: ".$_POST['post'];

}else if(isset($_GET['get'])){  // if user clicks submit button which is sent by get method

     //all values posted with the form are fetched from the GET array
    echo "hidden: ".$_GET['hidden'];

    if(strlen($_GET['text'])>0){
        echo "\ntext: ".$_GET['text'];
    }

    if(strlen($_GET['text_area'])>0){
        echo "\ntextarea: ".$_GET['text_area'];

    }

    if(isset($_GET['cbox'])){
        echo "\ncheckbox: ".$_GET['cbox'];
    }
    
    if(isset($_GET['radio_button'])){
        echo "\nradio: ".$_GET['radio_button'];
    }
    
    echo "\nselect: ".$_GET['select']."\nsubmit: ".$_GET['get'];
}

