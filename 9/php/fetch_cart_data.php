<?php
//This program helps find the user cart and information about the items in it

include('db_connection.php'); //start database connection by including the file

session_start(); //start the session to be able to get session values from SESSION aray

if (isset($_SESSION['session_id'])) { //checking if session id was given to user (both guests and logged in ones)

    $sessionID = $_SESSION['session_id'];

    $select = "SELECT * FROM cart_items WHERE session_id = '$sessionID'"; //fetching users cart with their unique session id

    $result = mysqli_query($dbc, $select);

    if (mysqli_num_rows($result) > 0) { //if the result set has any data it means user has products in their cart 

        while ($row = mysqli_fetch_assoc($result)) { //travsering through users cart items to extract info

            // putting all info about cart items inside arrays

            $allProductIDs[] = $row['product_id'];
            $allProductQtys[] = $row['quantity'];
            $allProductTotals[] = $row['item_total'];
        }

        foreach ($allProductIDs as $value) { //traversing through all items' id in the cart to connect them with their info in the products

            // all info about cart items are stored in products table so we are selecting the product that matches with the users cart item
            $select = "SELECT * FROM products WHERE product_id = '$value'";
            $result = mysqli_query($dbc, $select);
            $row = mysqli_fetch_assoc($result); //when we have found the info about the product
            $allProductNames[] = $row['name']; //we fetch the products name and put it inside all item names
            $allProductPrices[] = number_format($row['price'], 2); //we also fetch the prices in USD format
        }

        //to calculate the total cart cost we first create a variable and assign value 0
        $cartTotal = 0;
        foreach ($allProductTotals as $value) { //traversing through all items costs we update the cart totals value by adding each item total together
            $cartTotal += $value;
        }

        foreach ($allProductTotals as $key => $value) { //after doing the math calculation above we can also change the format so its USD
            $allProductTotals[$key] = number_format($value, 2); //the keys in the array store the new formatted values
        }

        //to calculate how many items there are in the cart we first create a variable with value 0
        $itemCount = 0;
        foreach ($allProductQtys as $value) { //we go through all items quantities to add the total item count
            $itemCount += $value;
        }

        //we put all information together about a single user cart in an array
        $cartInfo = array(
            "allProductIDs" => $allProductIDs,
            "allProductNames" => $allProductNames,
            "allProductTotals" => $allProductTotals,
            "allProductPrices" => $allProductPrices,
            "allProductQtys" => $allProductQtys,
            "itemCount" => $itemCount,
            "cartTotal" => number_format($cartTotal, 2)
        );

        echo json_encode($cartInfo); // we send the cart information by changing it to JSON format

    } else { // user has no product in cart

        echo "Your cart is empty!";
        
    }

} else { // no session id set: user has no product in cart because the session id is set when user adds sth to cart

    echo "Your cart is empty!";
}
