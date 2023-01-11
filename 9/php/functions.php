<?php

function validate($data)
{

    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);

    return $data;
}

function addNewItemToCart($dbc, $sessionID, $productID, $productQty)
{
    $insert = "INSERT INTO cart_items (shopping_id, session_id, product_id, quantity) VALUES (NULL,'$sessionID','$productID','$productQty')";

    if (mysqli_query($dbc, $insert)) {
        echo "Item(s) added to cart!";
    } else {
        echo "Error adding item(s) to cart!";
    }
}

function findUserSession($dbc, $userID)
{
    $userID = $_SESSION['user_id'];

    $select = "SELECT * FROM sessions WHERE user_id = '$userID'";

    $result = mysqli_query($dbc, $select);

    $row = mysqli_fetch_assoc($result);

    $sessionID = $row['session_id'];

    return $sessionID;
}

function increaseQty($dbc, $row, $productQty, $sessionID, $productID)
{
    $newQty = $row['quantity'] + $productQty;

    $update = "UPDATE cart_items SET quantity = '$newQty' WHERE session_id = '$sessionID' && product_id = '$productID'";

    if (mysqli_query($dbc, $update)) {
        echo "Item(s) added to cart!";
    } else {
        echo "Error adding item(s) to cart!";
    }
}

function addToCart($dbc, $sessionID, $productID, $productQty)
{
    //find the guests cart 
    if (empty(findCart($dbc, $sessionID))) { //if guest cart is empty
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
    $select = "SELECT * FROM cart_items WHERE session_id = '$sessionID'";

    $result = mysqli_query($dbc, $select);

    $row = mysqli_fetch_assoc($result);
    return $row;
}

function findProduct($dbc, $productID, $sessionID)
{
    $select = "SELECT * FROM cart_items WHERE session_id = '$sessionID' && product_id = '$productID'";

    $result = mysqli_query($dbc, $select);

    $row = mysqli_fetch_assoc($result);

    return $row;
}
