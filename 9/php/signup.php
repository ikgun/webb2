<?php

include('db_connection.php');
include('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $name = validate($_POST['name']);
   $email = validate($_POST['email']);
   $password = md5(validate($_POST['password']));

   $query = " SELECT * FROM users WHERE email = '$email' && password = '$password' ";

   $result = mysqli_query($dbc, $query);

   if (mysqli_num_rows($result) > 0) {

      echo 'Email already in use';

   } else {

      $insert = "INSERT INTO users (user_id, name, email, password) VALUES (NULL,'$name','$email','$pasword')";
      mysqli_query($dbc, $insert);
      $query = " SELECT * FROM users WHERE email = '$email'"; 
      $result = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($result);
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['email'] = $row['email'];
      header('Location: ../html/login.html');

   }
};

?>