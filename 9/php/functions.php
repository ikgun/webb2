<?php

//This file stores all functions in one place so that they are not repeated when they will be used again

function validate($data) //this function cleans the user input so it is validated against XSS attacks
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    return $data;
}

function calculateTotal($dbc, $productID, $productQty) 
{
    /*this function finds the product and calculates its final total
    by multiplying its price and user input quantity*/
    $select = "SELECT * FROM products WHERE product_id = '$productID' ";
    $result = mysqli_query($dbc, $select);
    $row = mysqli_fetch_assoc($result);
    $productPrice = $row['price'];
    $itemTotal = $productPrice * $productQty;
    return $itemTotal;
}

function addNewItemToCart($dbc, $sessionID, $productID, $productQty)
{
    /*this function adds a new item (a product user has not inserted before in db) 
    to users cart (inserts it to db)*/
    $itemTotal = calculateTotal($dbc, $productID, $productQty);
    $insert = "INSERT INTO cart_items (shopping_id, session_id, product_id, quantity, item_total) VALUES (NULL,'$sessionID','$productID','$productQty', $itemTotal)";
    if (mysqli_query($dbc, $insert)) { //if successfully or could not executed, informing user
        echo "Added!";
    } else {
        echo "Error!";
    }
}

function findUserSession($dbc, $userID)
{
    //this function finds a logged in users session with their unique id
    $userID = $_SESSION['user_id'];
    $select = "SELECT * FROM sessions WHERE user_id = '$userID'";
    $result = mysqli_query($dbc, $select);
    $row = mysqli_fetch_assoc($result);
    $sessionID = $row['session_id'];
    return $sessionID;
}

function increaseQty($dbc, $row, $productQty, $sessionID, $productID)
{
    /*this function increases the quantity of an item that was already in the cart 
    (user inserted it before to db, so it is being updated now)*/
    $newQty = $row['quantity'] + $productQty;
    $newTotal = calculateTotal($dbc, $productID, $newQty);
    $update = "UPDATE cart_items SET quantity = '$newQty', item_total = '$newTotal' WHERE session_id = '$sessionID' && product_id = '$productID'";
    if (mysqli_query($dbc, $update)) {
        echo "Added!";
    } else {
        echo "Error!";
    }
}

function addToCart($dbc, $sessionID, $productID, $productQty)
{
    /*this function that takes in all forms of adding to cart (whether item not being in cart or in cart),
    it is basically a higher level add function to clean up gutter
    it first finds the users cart */
    if (empty(findCart($dbc, $sessionID))) { //if user cart is empty
        addNewItemToCart($dbc, $sessionID, $productID, $productQty); //add the new item
    } else { // if the cart is not empty
        $product = findProduct($dbc, $productID, $sessionID); //find the product in the cart
        if (empty($product)) { //if there is no matching product in the cart
            addNewItemToCart($dbc, $sessionID, $productID, $productQty);
        } else { // if the product is already in the cart, increase its qty
            increaseQty($dbc, $product, $productQty, $sessionID, $productID);
        }
    }
}

function findCart($dbc, $sessionID)
{
    /*this function finds user cart with the session id, when a creats an account they are given a session id
    if a user is guest, they are given a session id when they first add an item, so a user always has a cart
    that is connected to their session id.*/
    $select = "SELECT * FROM cart_items WHERE session_id = '$sessionID'";
    $result = mysqli_query($dbc, $select);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function findProduct($dbc, $productID, $sessionID)
{
    //this function checks if an item is already inside the users cart
    $select = "SELECT * FROM cart_items WHERE session_id = '$sessionID' && product_id = '$productID'";
    $result = mysqli_query($dbc, $select);
    $row = mysqli_fetch_assoc($result);
    return $row;
}
