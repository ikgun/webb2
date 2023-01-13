<?php
//This program is called when user clicks on add to cart button. It adds the item(s) to the cart.

include('db_connection.php'); //start database connection by including the file
include('functions.php'); //fetch the functions that will be used in the program

session_start(); //start the session to be able to get session values from SESSION aray

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //check if user clicked on button

    $productID = $_GET['product-id']; //get the clicked buttons bound product ID (each product has its own button by giving the same id to buttons as the products)
    $productQty = $_POST['product-qty']; //get how many of the product user added to cart

    if (isset($_SESSION['user_id'])) { //if user is logged in

        // add product to cart by finding their session with users id
        addToCart($dbc, findUserSession($dbc, $_SESSION['user_id']), $productID, $productQty); 

    } else { //no user logged in

        if (isset($_SESSION['session_id'])) { //if guest has a session

            // add product to cart with their ongoing session
            addToCart($dbc, $_SESSION['session_id'], $productID, $productQty); 

        } else { // guest does not have a session

            $insert = "INSERT INTO sessions (session_id, user_id) VALUES (NULL, NULL)"; // create new session to guest 

            mysqli_query($dbc, $insert); //execute the query

            if (mysqli_affected_rows($dbc) > 0) { //if there are any new sessions in the database

                $_SESSION['session_id'] = mysqli_insert_id($dbc); //get the latest added sessions id from the database
                
                // add product to cart by using the newly generated session id
                addToCart($dbc, $_SESSION['session_id'], $productID, $productQty); 

            } else { // the insertion did not work
                echo "Error creating guest session";
            }
        }
    }
} else { // post request did not work
    echo "Server error";
}
