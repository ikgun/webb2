<?php

//This program sends and email

if (isset($_POST['push_button'])) { //if the send email button is clicked

    require 'PHPMailerAutoload.php';
    $mail = new PHPMailer; // creating a new mail object to store data 


    //fetching data from the form. The data was sent using post so all data is in the POST array 
    $from = $_POST['from']; 
    $to = $_POST['to'];
    $cc = $_POST['cc'];
    $bcc = $_POST['bcc'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    //Server settings

    $mail->isSMTP();                                            //Send using SMTP 
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ikbalgun98@gmail.com';                     //SMTP username
    $mail->Password   = 'rpmwtrzrdesxwszi';                               //SMTP password
    $mail->Port       = 465;                                 //TCP port to connect to
    $mail->SMTPSecure = 'ssl';

    //Recipients
    $mail->setFrom($from); //setting the person who sends the email
    $mail->addAddress($to); //setting the person who receives the email
    $mail->addCC($cc); //setting cc address
    $mail->addBCC($bcc); //setting bcc address

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;  //setting the subject
    $mail->Body    = $message;  //setting the message

    $mail->send(); //send mail

    //if successful this message will be printed out to the page
    echo "Message has been sent <br> Observera! Detta meddelande är sänt från ett formulär på Internet och avsändaren kan vara felaktig!";
}
