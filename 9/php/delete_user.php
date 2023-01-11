<?php

include('db_connection.php');
include('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['user_id'])) {

    $userID = $_SESSION['user_id'];

    $select = " SELECT * FROM users WHERE user_id = '$userID' ";

    $result = mysqli_query($dbc, $select);

    if (mysqli_num_rows($result) > 0) {

        $delete = "DELETE FROM users WHERE user_id = '$userID'";

        if (mysqli_query($dbc, $delete)) {
            echo 'Account deleted successfully, you\'re being logged out';
        } else {
            echo 'Error deleting account';
        }
    } else {
        echo 'No such user';
    }
};
