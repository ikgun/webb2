<?php

// this program outputs the visitor count value to html page by changing the data to print to the webpage on the server side

$html = file_get_contents("example.html"); //get the html pages content

$count = file_get_contents("count.txt"); //get the value to be output from the file
$count++;//increase the value

$html = str_replace('---$hits---', $count, $html); //changing the string that has the specified string with the count value

$fp = fopen("count.txt", "w"); //creating a file pointer to the text file with write mode

flock($fp, LOCK_EX); //locking the file before writing to it to prevent clashes when multiple users open the site

fwrite($fp, $count); //writing the value to the text file

flock($fp, LOCK_UN); //unlocking after writing the value 

fclose($fp); //closing the file pointer

echo $html; //echoing back the changed page
