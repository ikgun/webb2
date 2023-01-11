<?php

include('db_connection.php');
include('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $email = validate($_POST['email']);
   $password = md5(validate($_POST['password']));

   $select = " SELECT * FROM users WHERE email = '$email' && password = '$password' ";

   $result = mysqli_query($dbc, $select);

   if (mysqli_num_rows($result) > 0) {

      $row = mysqli_fetch_array($result);

      $userID = $row['user_id'];

      $_SESSION['user_id'] = $userID;
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['email'] = $row['email'];

      $select = " SELECT * FROM sessions WHERE user_id = '$userID' ";
      $result = mysqli_query($dbc, $select);
      $row = mysqli_fetch_assoc($result);
      if (!empty($row)) {
         $_SESSION['session_id'] = $row['session_id'];
      } else {
         echo "Error: User does not have session ID";
      }

      echo 'welcome.html';
   } else {
      echo 'Invalid email or password';
   }
};
