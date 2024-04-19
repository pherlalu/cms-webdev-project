<?php

/*******w******** 
    
    Name: Steffi Ann Tanya Amper
    Created: March 17, 2024
    Updated: April 16, 2024
    Description: Edit Event page

 ****************/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer();

$alert = '';

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  try {
    $mail->isSMTP();
    $mail->Host = 'live.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = 'api'; //SMTP server
    $mail->Password = 'b1db1aa47b2d1b8fcf0fa2d291065669'; // Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = '587';

    $mail->setFrom($email); // email address which you used as SMTP server
    $mail->addAddress('ampokingking@gmail.com'); // Email address where you want to receive emails

    $mail->isHTML(true);
    $mail->Subject = 'Message Received (Contact Page)';
    $mail->Body = "<h3>Name : $name <br>Email: $email <br>Message : $message</h3>";

    $mail->send();
    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Message Sent! Thank you for contacting us.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
  } catch (Exception $e) {
    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Error: ' . $e->getMessage() . '
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
}
