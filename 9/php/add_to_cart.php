<?php

include('db_connection.php');
include('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $productID = $_GET['product-id'];
    $productQty = $_POST['product-qty'];

    if (isset($_SESSION['user_id'])) { //if user is logged in

        // add product to cart by finding their session with users id
        addToCart($dbc, findUserSession($dbc, $_SESSION['user_id']), $productID, $productQty); 

    } else { //no user logged in

        if (isset($_SESSION['session_id'])) { //if guest has a session

            // add product to cart with their ongoing session
            addToCart($dbc, $_SESSION['session_id'], $productID, $productQty); 

        } else { // guest does not have a session

            $insert = "INSERT INTO sessions (session_id, user_id) VALUES (NULL, NULL)"; // create new session to guest 

            mysqli_query($dbc, $insert);

            if (mysqli_affected_rows($dbc) > 0) {

                $_SESSION['session_id'] = mysqli_insert_id($dbc);
                
                // add product to cart by using the newly generated session id
                addToCart($dbc, $_SESSION['session_id'], $productID, $productQty); 

            } else {
                echo "Error creating guest session";
            }
        }
    }
} else {
    echo "Server error";
}
