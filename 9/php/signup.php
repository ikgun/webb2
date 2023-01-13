<?php
//This program helps user sign up

include('db_connection.php'); //start database connection by including the file
include('functions.php'); //fetch the functions that will be used in the program

session_start(); //start the session to be able to set session values to SESSION aray

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //if user clicks sign up btn and sends the sign up form

   $name = validate($_POST['name']); //cleaning input against XSS attack
   $email = validate($_POST['email']);
   $password = password_hash(validate($_POST['password']), PASSWORD_BCRYPT); //encrypting user password

   $query = " SELECT * FROM users WHERE email = ?"; //creating a query to find user email, without the email value to prevent SQL injection

   $stmt = $dbc->prepare($query);
   $stmt->bind_param("s", $email); //binding user input with the query
   $stmt->execute();
   $result = $stmt->get_result();

   if (mysqli_num_rows($result) > 0) { //if the result set has any data matched to the user input email it means the email is already used

      echo 'Email already in use';

   } else { //otherwise user account can be created

      $accountCreated = false; //we create a flag to keep track whether account creation was successful
      
      //adding the user to db with new values
      $insert = "INSERT INTO users (user_id, name, email, password) VALUES (NULL,?,?,?)"; 
      $stmt = $dbc->prepare($insert);
      $stmt->bind_param("sss", $name, $email, $password);
      $stmt->execute();

      if ($dbc->affected_rows > 0) { //if there were any changes in db

         $query = " SELECT * FROM users WHERE email = ?"; //we fetch the latest inserted user
         $stmt = $dbc->prepare($query);
         $stmt->bind_param("s",  $email);
         $stmt->execute();

         if ($result = $stmt->get_result()) {

            $row = mysqli_fetch_assoc($result);

            // we fetch the user to update the session variables
            $userID = $row['user_id'];
            $_SESSION['user_id'] = $userID;
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['email'] = $row['email'];

            //we also create a session id for user, inserting it into the db
            $insert = "INSERT INTO sessions (session_id, user_id) VALUES (NULL, '$userID')";

            if (mysqli_query($dbc, $insert)) {
               $query = " SELECT * FROM sessions WHERE user_id = '$userID'";
               $result = mysqli_query($dbc, $query);
               $row = mysqli_fetch_assoc($result);
               //and also keep the session id in SESSION variable so we can use it to fetch user cart
               $_SESSION['session_id'] = $row['session_id'];
               $accountCreated = true; //if every step was complete, the account is created
            }

         }

         if ($accountCreated) { //we print out message according to flag variables value
            echo "Account created!";
         } else {
            echo "Error signing up!";
         }

      } else { //if there were no changes in db it means the user wasn't inserted 

         echo "Error signing up!";

      }
   }
};
