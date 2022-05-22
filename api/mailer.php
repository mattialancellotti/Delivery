<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/* Loading all the libraries */
require __DIR__.'/../vendor/autoload.php';

/* Checking some stuff */
(!isset($_GET['mail'])) and die("Maybe a problem occurred..");

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
  /* Configuring SMTP to send emails */
  $mail->isSMTP();

  /* Setting up some configurations addresses */
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;

  /* Tokens */
  $mail->Username = 'lancellotti.noreplay@gmail.com';
  $mail->Password = 'cGWiA=$y';

  /* Server's properties */
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;

  $mail->setFrom('lancellotti.noreplay@gmail.com', 'Mailer');
  $mail->addAddress($_GET['mail']);

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Here is the subject';
  $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  $mail->send();
  echo "{\"Success\":\"true\"}";
} catch (Exception $e) {
    echo "{\"Success\":\"false\"}";
}
?>
