<?php

include('db_connection.php');
include('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {

    $userID = $_SESSION['user_id'];
    $sessionID = findUserSession($dbc, $userID);

    $select = " SELECT * FROM cart_items WHERE session_id = '$sessionID' ";

    if (mysqli_num_rows($result = mysqli_query($dbc, $select)) > 0) {

        $delete = "DELETE FROM cart_items WHERE session_id = '$sessionID'";

        mysqli_query($dbc, $delete);
    }

    $delete = "DELETE FROM sessions WHERE session_id = '$sessionID'";

    mysqli_query($dbc, $delete);

    if (mysqli_affected_rows($dbc) > 0) {

        $select = " SELECT * FROM users WHERE user_id = '$userID' ";

        if (mysqli_num_rows($result = mysqli_query($dbc, $select)) > 0) {

            $delete = "DELETE FROM users WHERE user_id = '$userID'";

            mysqli_query($dbc, $delete);

            if (mysqli_affected_rows($dbc) > 0) {

                echo 'Account deleted successfully, you\'re being logged out';

            } else {

                echo 'User account could not be deleted';

            }
            
        } else {

            echo 'No such user';

        }

    } else {

        echo "User session could not be deleted";
        
    }
};
