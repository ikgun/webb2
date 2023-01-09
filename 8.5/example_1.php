<?php

$html = file_get_contents("example.html");

$session_id = rand();

$html = str_replace('---session-id-secure---', $session_id, $html);

setcookie('session-id', $session_id, time() + 3 * 60 * 60, null, null, true, true);

echo  $html;
