<?php
include('db_connection.php');
include('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['to'])) {

    require 'PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $to = validate($_POST['to']);

    //Server settings

    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ikbalgun98@gmail.com';                     //SMTP username
    $mail->Password   = 'rpmwtrzrdesxwszi';                               //SMTP password
    $mail->Port       = 465;                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SMTPSecure = 'ssl';

    //Recipients
    $mail->setFrom('ikbalgun98@gmail.com');
    $mail->addAddress($to);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Welcome to my page';
    $mail->Body    = 'This is an email sent because you clicked on the subscribe button on my website, this is nothing real and serious.';

    $mail->send();

    echo "You have subscribed to our mailing list! Hurra!";

}else{

    echo "Request error";
    
}
