<?php
//code snippet to connect to db

$dbuser = "root";
$dbpass = "123";
$dbname = "webb2";

$dbc = new mysqli("localhost", $dbuser, $dbpass, $dbname); //creating database connection with my db credentials