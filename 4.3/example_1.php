<?php

session_start();

$html = file_get_contents("example.html");

$_SESSION['session-id'] = rand();

$html = str_replace('---session-id---', $_SESSION['session-id'], $html);

echo  $html;
