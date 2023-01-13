<?php
//This program removes item(s) from user cart

include('db_connection.php'); //start database connection by including the file

session_start(); //start the session to be able to get session values from SESSION aray

if($_SERVER['REQUEST_METHOD'] == 'POST'){ //if user clicks the remove button

    $sessionID = $_SESSION['session_id']; //getting session id
    $productID = $_GET['product_id']; //and the product id connected to the remove btn 
    //(all remove btns get assigned their respective items id so that the program knows which item to remove)
    
    $delete = "DELETE FROM cart_items WHERE product_id = '$productID' && session_id = '$sessionID'";

    $result = mysqli_query($dbc, $delete);
    
    if(mysqli_affected_rows($dbc) > 0){ //if there is a change in the db, we inform the user

        echo "Removed"; //if the remove was successfull we inform the user removed
 
    }else{

        echo "Error"; 
    }
    

}else{

    echo "Request error";
}