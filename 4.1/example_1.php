<?php

$html = file_get_contents("example.html");

$session_id = rand();

$html = str_replace('---session-id---', $session_id, $html);

echo  $html;
