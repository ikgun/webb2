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

      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['email'] = $row['email'];
      
      echo 'welcome.html';

   } else {
      echo 'Invalid email or password';
   }

};

?>