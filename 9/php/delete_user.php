<?php
//This program deletes the users account, thus all info connected to them from the database

include('db_connection.php'); //start database connection by including the file
include('functions.php'); //fetch the functions that will be used in the program

session_start(); //start the session to be able to get session values from SESSION aray

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {  //if delete button is clicked and there is a logged in user

    $userID = $_SESSION['user_id'];
    $sessionID = findUserSession($dbc, $userID); //fetching user session id with their user id

    $select = " SELECT * FROM cart_items WHERE session_id = '$sessionID' "; //creating a query to check in the cart to see whether the user has any items in their cart

    if (mysqli_num_rows($result = mysqli_query($dbc, $select)) > 0) { //if there is any data in the result set that is executed 

        $delete = "DELETE FROM cart_items WHERE session_id = '$sessionID'"; //delete their cart before deleting the user

        mysqli_query($dbc, $delete); //execute delete query
    }

    $delete = "DELETE FROM sessions WHERE session_id = '$sessionID'";  //delete query to delete the users session

    mysqli_query($dbc, $delete);

    if (mysqli_affected_rows($dbc) > 0) { //checking fi there are any changes in the db after executing the delete query

        //after deleting the users cart and session (all info connected to user) now we can delete the user 

        $delete = "DELETE FROM users WHERE user_id = '$userID'"; //query to find the user among all users and delete them

        mysqli_query($dbc, $delete); 

        if (mysqli_affected_rows($dbc) > 0) { //if there are any changes in the db

            echo 'Account deleted successfully, you\'re being logged out'; //inform the user

        } else {

            echo 'User account could not be deleted';
        }

    } else { //otherwise error occured while deleting user session first

        echo "User session could not be deleted";
    }
};
