<?php

//This program helps find the users data, if logged in logged in users data if not no data 

include('db_connection.php'); //start database connection by including the file

session_start(); //start the session to be able to get session values from SESSION aray

if(isset($_SESSION['user_id'])){ //if user is logged in

    $userID = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = '$userID'"; //find the user from db that has the unique id
    $result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_assoc($result);
    $userInfo = array( //store user information inside an array
        "userID" => $row['user_id'],
        "userName" => $row['name'],
        "userEmail" => $row['email'],
    );
    
}else{

    $userInfo = array( //if no user is logged in, there is no info
        "userID" => null,
        "userName" => null,
        "userEmail" => null,
    );
    
}

echo json_encode($userInfo); //send the user data in JSON format
