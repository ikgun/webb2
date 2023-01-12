<?php

include('db_connection.php');
include('functions.php');

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $sessionID = $_SESSION['session_id'];
    $productID = $_GET['product_id'];

    $delete = "DELETE FROM cart_items WHERE product_id = '$productID' && session_id = '$sessionID'";

    $result = mysqli_query($dbc, $delete);

    if(mysqli_affected_rows($dbc) > 0){

        // echo "Item(s) removed from cart";

        echo $productID . " " . $sessionID;

    }else{

        echo "Could not remove item(s) from cart";
    }
    

}else{

    echo "Request error";
}