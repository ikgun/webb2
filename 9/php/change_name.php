<?php

include('db_connection.php');
include('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {

   $newName = validate($_POST['name']);
   $userID = $_SESSION['user_id'];

   $select = " SELECT * FROM users WHERE user_id = '$userID' ";

   $result = mysqli_query($dbc, $select);

   if (mysqli_num_rows($result) > 0) {

      $update = "UPDATE users SET name = ? WHERE user_id = '$userID'";
      $stmt = $dbc->prepare($update);
      $stmt->bind_param("s", $newName);
      $stmt->execute();

      if ($dbc->affected_rows > 0) {
         echo 'Name successfully changed';
      } else {
         echo 'Error changing name';
      }

   } else {

      echo 'No such user';

   }
   
};
