<?php

include('db_connection.php');

$query = "SELECT * FROM products";

$result = mysqli_query($dbc, $query);

if (mysqli_num_rows($result) > 0) {
    
    while ($row = mysqli_fetch_assoc($result)) {

        $productInfo = array(
            "productID" => $row['product_id'],
            "productName" => $row['name'],
            "productPrice" => number_format($row['price'], 2),
            "productImgSrc" => $row['img_src'],
        );

        $productArray[] = $productInfo;
        
    }

    echo json_encode($productArray);

}else{

    echo "No product in database";
    
}




