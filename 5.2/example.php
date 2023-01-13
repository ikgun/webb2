<?php

//This program sends mail with attachments

 header('Content-type: text/plain'); //outputting text content
if (isset($_POST['push_button'])) { //if user clicks on submit button

    require 'PHPMailerAutoload.php';
    $mail = new PHPMailer; //create mail object

    //fetching data from the form
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
    $mail->Port       = 465;                //TCP port to connect to
    $mail->SMTPSecure = 'ssl';

    //Recipients
    $mail->setFrom($from); //setting the person who is sending the email
    $mail->addAddress($to); //setting the person who is receiving the email
    $mail->addCC($cc); //setting cc address 
    $mail->addBCC($bcc); //setting bcc address

    //Attachments
    if(is_uploaded_file($_FILES['file1']['tmp_name'])){ //if file 1 is uploaded

        echo "Lägger till fil 1!\n"; //echo a message
        $mail->addAttachment($_FILES["file1"]["name"]);  //Add attachments
    }

    if(is_uploaded_file($_FILES['file2']['tmp_name'])){

        echo "Lägger till fil 2!\n";
        $mail->addAttachment($_FILES["file2"]["name"]);   //Add attachments
    }

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject; //set the subject
    $mail->Body    = $message; //set the message

    $mail->send(); //send the mail
    
    //if successful this message should be printed out to the html page
    echo "Message has been sent \nObservera! Detta meddelande är sänt från ett formulär på Internet och avsändaren kan vara felaktig!";
}
