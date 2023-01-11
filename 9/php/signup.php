<?php

include('db_connection.php');
include('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $name = validate($_POST['name']);
   $email = validate($_POST['email']);
   $password = md5(validate($_POST['password']));

   $query = " SELECT * FROM users WHERE email = '$email'";

   $result = mysqli_query($dbc, $query);

   if (mysqli_num_rows($result) > 0) {

      echo 'Email already in use';
   } else {

      $accountCreated = false;
      $insert = "INSERT INTO users (user_id, name, email, password) VALUES (NULL,'$name','$email','$password')";
      if (mysqli_query($dbc, $insert)) {
         $query = " SELECT * FROM users WHERE email = '$email'";
         if ($result = mysqli_query($dbc, $query)) {
            $row = mysqli_fetch_array($result);
            $userID = $row['user_id'];
            $_SESSION['user_id'] = $userID;
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $insert = "INSERT INTO sessions (session_id, user_id) VALUES (NULL, '$userID')";
            if (mysqli_query($dbc, $insert)) {
               $query = " SELECT * FROM sessions WHERE user_id = '$userID'";
               $result = mysqli_query($dbc, $query);
               $row = mysqli_fetch_assoc($result);
               $_SESSION['session_id'] = $row['session_id'];
               $accountCreated = true;
            }
         }

         if ($accountCreated) {
            echo "Account created!";
         } else {
            echo "Error signing up!";
         }
      } else {
         echo "Error signing up!";
      }
   }
};
