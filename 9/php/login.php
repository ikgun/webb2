<?php
//This program logs the user into their account

include('db_connection.php'); //start database connection by including the file
include('functions.php'); //fetch the functions that will be used in the program

session_start(); //start the session to be able to set session values to SESSION aray

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //if user clicks login button and send the login form

   $email = validate($_POST['email']); //getting the email and validating it against XSS attack

   $select = " SELECT * FROM users WHERE email = ?"; //finding user in db with their email but first protection against SQL injection
   $stmt = $dbc->prepare($select); //preparing the query
   $stmt->bind_param("s", $email); //binding the query with the user input
   $stmt->execute(); //executing the query 
   $result = $stmt->get_result(); //getting result set from the executed query

   if (mysqli_num_rows($result) > 0) { //if there is any user with the email

      /*If the user with email is found, we go to the second check which is the password. We verify the password
      by comparing it with its hash code which is returned by the function password_hash. */

      if(password_verify(validate($_POST['password']), password_hash(validate($_POST['password']), PASSWORD_BCRYPT))){

         //if the password is verified we fetch the data about the user
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

      }else{ 
         
         /*if the password is not verified we give info, we dont give specific info though as we dont want 
         somebody trying to hack a users account by specifiy whether it was the password or the email was wrong*/

         echo 'Invalid email or password';

      }

   } else { //the email was not found so we inform the user 

      echo 'Invalid email or password';
      
   }
};
