<?php

include('db_connection.php');

session_start();
session_unset();
session_destroy();
header('Location: ../html/welcome.html');

?>