<?php

include('db_connection.php');
include('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {

    $newEmail = validate($_POST['email']);
    $userID = $_SESSION['user_id'];

    $query = " SELECT * FROM users WHERE email = ?";

    if ($stmt = $dbc->prepare($query)) {

        $stmt->bind_param("s", $newEmail);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {

            echo 'Email already in use';

        } else {

            $select = " SELECT * FROM users WHERE user_id = '$userID' ";
            $stmt = $dbc->prepare($select);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {

                $update = "UPDATE users SET email = ? WHERE user_id = '$userID'";
                $stmt = $dbc->prepare($update);
                $stmt->bind_param("s", $newEmail);
                $stmt->execute();

                if ($dbc->affected_rows > 0) {
                    echo 'Email successfully changed';
                } else {
                    echo 'Error changing email';
                }

            } else {

                echo 'No such user';

            }
        }
    }
};
