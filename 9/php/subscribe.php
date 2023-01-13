<?php
//this program sends the user an email

include('functions.php'); //fetch the functions that will be used in the program

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //if user clicks on subscribe button in the footer

    require 'PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $to = validate($_POST['to']); //we validate the user input against XSS attack

    //Server settings
    $mail->isSMTP();                                          //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
    $mail->Username   = 'ikbalgun98@gmail.com';               //SMTP username
    $mail->Password   = 'rpmwtrzrdesxwszi';                   //SMTP password
    $mail->Port       = 465;                                  //TCP port to connect to
    $mail->SMTPSecure = 'ssl';

    //Recipients
    $mail->setFrom('ikbalgun98@gmail.com');                    //my email as i will be the one sending
    $mail->addAddress($to);                                    //the persons address which they input

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Welcome to my page';
    $mail->Body    = 'This is an email sent because you clicked on the subscribe button on my website, this is nothing real and serious.';

    $mail->send();

    echo "You have subscribed to our mailing list! Hurra!";     //just informing the user

}else{

    echo "Request error";
    
}
