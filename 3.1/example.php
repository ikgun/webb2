<?php

$html = file_get_contents("example.html");

$count = file_get_contents("count.txt");
$count++;

$html = str_replace('---$hits---', $count, $html);

$fp = fopen("count.txt", "w");

flock($fp, LOCK_EX);

fwrite($fp, $count);

flock($fp, LOCK_UN);

fclose($fp);

echo $html;
