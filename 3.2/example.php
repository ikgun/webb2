<?php

//this page changes the html page with several values, by looping through all values 

$html = file_get_contents("example.html"); //first we get the contents of the html page

 //we divide the page (in string format) into pieces that are divided by the delimiter given inside the explode function
$html_pieces = explode("<!--===xxx===-->", $html);

echo $html_pieces[0]; //we output the first piece of the page

/*the second piece will be the place we print out all the values, to add the values in the html page, we replace the
key with the name string and the value with the value string inside the html, to be able to print out each value we
travserse the SERVER array using a foreach loop*/
foreach ($_SERVER as $key => $value) { 

    /*we take the second piece, inside the second piece we replace the name string with the key values of the SERVER
    this returns back the replaced value, and again inside that replaced value we replace once more the string value
    with SERVER value this time. This also returns back the changed string which we echo back to the page*/
    $a = str_replace('---name---', $key, $html_pieces[1]);
    $b = str_replace('---value---', $value, $a);

    echo $b;
}

echo  $html_pieces[2]; //finally we echo the last part of the page, thus completing the whole page
