<?php

include('db_connection.php');

session_start();

$query = "SELECT * FROM users";

$result = mysqli_query($dbc, $query);

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']) {

            $userInfo = array(
                "userID" => $row['user_id'],
                "userName" => $row['name'],
                "userEmail" => $row['email'],
            );

            $userArray[] = $userInfo;
        }
    }

    global $userArray;

    if ($userArray !== null) {

        echo json_encode($userArray);

    } else {

        echo 'No user logged in';
        
    }

} else {

    echo "No user in database";

}
