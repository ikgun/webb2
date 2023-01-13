<?php
//This program changes the user's email when they want to change it from their account

include('db_connection.php'); //start database connection by including the file
include('functions.php'); //fetch the functions that will be used in the program

session_start(); //start the session to be able to get session values from SESSION aray

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) { //if change form is submitted and there is a logged in user

    $newEmail = validate($_POST['email']); // cleaning input to defend against XSS attack
    $userID = $_SESSION['user_id']; // fetching user id from sessions

    //creating query to search through users if the email is already in the database
    $query = " SELECT * FROM users WHERE email = ?"; //not inserting the input email directly to defend against SQL injection

    if ($stmt = $dbc->prepare($query)) { //if the query is successfully prepared for execution

        $stmt->bind_param("s", $newEmail); //binding cleaned user input to the query
        $stmt->execute(); //executing query
        $stmt->store_result(); // storing the query's result

        if ($stmt->num_rows > 0) { // if the result set has any data

            echo 'Email already in use'; //it means the user's entered email is already used and they can't change to that 

        } else { // if there is no data it means they can use that email

            $update = "UPDATE users SET email = ? WHERE user_id = '$userID'"; //change the email address by finding the user with unique id
            $stmt = $dbc->prepare($update);
            $stmt->bind_param("s", $newEmail);
            $stmt->execute();

            if ($dbc->affected_rows > 0) { //if there are any changes in the database
                echo 'Email successfully changed'; //it means the update has worked and the email has changed
            } else {
                echo 'Error changing email'; //otherwise there was an error
            }
        }
    }
};
