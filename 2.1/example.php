<?php

//This program reads the user data from the URL

header("Content-type: text/plain");

echo "name = " . $_GET['name']."\nemail = ".$_GET['email'];