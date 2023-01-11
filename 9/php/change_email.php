<?php

include('db_connection.php');
include('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {

    $newEmail = validate($_POST['email']);
    $userID = $_SESSION['user_id'];

    $query = " SELECT * FROM users WHERE email = '$newEmail'";

    $result = mysqli_query($dbc, $query);

    if (mysqli_num_rows($result) > 0) {

        echo 'Email already in use';
    } else {
        $select = " SELECT * FROM users WHERE user_id = '$userID' ";

        $result = mysqli_query($dbc, $select);

        if (mysqli_num_rows($result) > 0) {

            $update = "UPDATE users SET email = '$newEmail' WHERE user_id = '$userID'";

            if (mysqli_query($dbc, $update)) {
                echo 'Email successfully changed';
            } else {
                echo 'Error changing email';
            }
        } else {
            echo 'No such user';
        }
    }
};
