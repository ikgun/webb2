<?php

$html = file_get_contents("example.html");

$html_pieces = explode("<!--===xxx===-->", $html);

echo $html_pieces[0];

foreach ($_SERVER as $key => $value) {

    $a = str_replace('---name---', $key, $html_pieces[1]);
    $b = str_replace('---value---', $value, $a);

    echo $b;
}

echo  $html_pieces[2];
