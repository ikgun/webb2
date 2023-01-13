<?php
//This program helps fetch all the product data 

include('db_connection.php'); //start database connection by including the file

$query = "SELECT * FROM products"; //fetch all products from the db

$result = mysqli_query($dbc, $query);

if (mysqli_num_rows($result) > 0) { //if there are any products
    
    while ($row = mysqli_fetch_assoc($result)) { //loop through all data to get each info about each product

        //store all info about a product in a array
        $productInfo = array(
            "productID" => $row['product_id'],
            "productName" => $row['name'],
            "productPrice" => number_format($row['price'], 2),
            "productImgSrc" => $row['img_src'],
        );

        $productArray[] = $productInfo; //add that product info inside the whole products array
        
    }

    echo json_encode($productArray); //send the products array in JSON format 

}else{ // else there are no products in db 

    echo "No product in database";
    
}




