<?php
//This program changes the user's name when they want to change it from their account

include('db_connection.php'); //start database connection by including the file
include('functions.php'); //fetch the functions that will be used in the program

session_start(); //start the session to be able to get session values from SESSION aray

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) { //if change form is submitted and there is a logged in user

   $newName = validate($_POST['name']); // cleaning input to defend against XSS attack
   $userID = $_SESSION['user_id']; // fetching user id from sessions

   $update = "UPDATE users SET name = ? WHERE user_id = '$userID'"; //change the found name
      $stmt = $dbc->prepare($update);
      $stmt->bind_param("s", $newName);
      $stmt->execute();

      if ($dbc->affected_rows > 0) { //if there are any changes in the database
         echo 'Name successfully changed'; //alert user that their name is changed
      } else {
         echo 'Error changing name';
      }
   
};
