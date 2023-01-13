<?php

include('db_connection.php');
include('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $email = validate($_POST['email']);

   $select = " SELECT * FROM users WHERE email = ?";
   $stmt = $dbc->prepare($select); 
   $stmt->bind_param("s", $email);
   $stmt->execute();
   $result = $stmt->get_result();

   if (mysqli_num_rows($result) > 0) {

      if(password_verify(validate($_POST['password']), password_hash(validate($_POST['password']), PASSWORD_BCRYPT))){

         $row = mysqli_fetch_assoc($result);

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
      }

   } else {

      echo 'Invalid email or password';
      
   }
};
