<?php

include('db_connection.php');
include('functions.php');

session_start();

if(isset($_SESSION['session_id'])){ 

    $sessionID = $_SESSION['session_id'];

    $select = "SELECT * FROM cart_items WHERE session_id = '$sessionID'";

    $result = mysqli_query($dbc, $select);

    if(mysqli_num_rows($result) > 0){ //user has products in their cart 

        while($row = mysqli_fetch_assoc($result)){

            $allProductIDs[] = $row['product_id'];
            $allProductQtys[] = $row['quantity'];
            $allProductTotals[] = $row['item_total'];
        }

        foreach ($allProductIDs as $value) {
            $select = "SELECT * FROM products WHERE product_id = '$value'";
            $result = mysqli_query($dbc, $select);
            while($row = mysqli_fetch_assoc($result)){
                $allProductNames[] = $row['name'];
                $allProductPrices[] = number_format($row['price'], 2);
            }
        }

        $cartTotal = 0;
        foreach ($allProductTotals as $value) {
            $cartTotal += $value;
        }

        foreach ($allProductTotals as $key => $value) {
            $allProductTotals[$key] = number_format($value, 2);
        }

        $itemCount = 0;
        foreach ($allProductQtys as $value) {
            $itemCount += $value;
        }

        $cartInfo = array(
            "allProductIDs" => $allProductIDs,
            "allProductNames" => $allProductNames,
            "allProductTotals" => $allProductTotals,
            "allProductPrices" => $allProductPrices,
            "allProductQtys" => $allProductQtys,
            "itemCount" => $itemCount,
            "cartTotal" => number_format($cartTotal, 2)
        );

        echo json_encode($cartInfo);

    }else{ // user has no product in cart

        echo "Your cart is empty!";
    }

}else{ // no session id set: user has no product in cart

    echo "Your cart is empty!";

}