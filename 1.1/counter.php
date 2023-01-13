<?php

//This program counts the visitors to the website

$count = file_get_contents("count.txt"); //getting file contents and storing it to be able to update
$count++; //increasing the count

$fp = fopen("count.txt", "w"); //creating a file pointer to the file by opening it with write mode

flock($fp, LOCK_EX); //locking the file

fwrite($fp, $count); //writing the new value to the file

flock($fp, LOCK_UN); // unlocking (we locked so there were no clashes from multiple visitors)

fclose($fp); //closing file pointer

header('Content-type: text/plain'); //establishing content type so the content is correctly shown 

echo $count; //showing the updated count on the website by echoing
