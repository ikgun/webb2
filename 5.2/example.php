<?php
 header('Content-type: text/plain');
if (isset($_POST['push_button'])) {

    require 'PHPMailerAutoload.php';
    $mail = new PHPMailer;

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
    $mail->Port       = 465;                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SMTPSecure = 'ssl';

    //Recipients
    $mail->setFrom($from);
    $mail->addAddress($to);
    $mail->addCC($cc);
    $mail->addBCC($bcc);

    //Attachments
    if(is_uploaded_file($_FILES['file1']['tmp_name'])){

        echo "Lägger till fil 1!\n";
        $mail->addAttachment($_FILES["file1"]["name"]);  //Add attachments
    }

    if(is_uploaded_file($_FILES['file2']['tmp_name'])){

        echo "Lägger till fil 2!\n";
        $mail->addAttachment($_FILES["file2"]["name"]);   //Add attachments
    }

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();
    
    echo "Message has been sent \nObservera! Detta meddelande är sänt från ett formulär på Internet och avsändaren kan vara felaktig!";
}
