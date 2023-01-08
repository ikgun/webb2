<?php

$count = file_get_contents("count.txt");
$count++;

$fp = fopen("count.txt", "w");

flock($fp, LOCK_EX);

fwrite($fp, $count);

flock($fp, LOCK_UN);

fclose($fp);

header('Content-type: text/plain');

echo $count;
