<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/* Loading all the libraries */
require __DIR__.'/../../vendor/autoload.php';

class Mailer {
  private $mail;

  public function __construct($username, $password) {
    $this->mail = new PHPMailer(true);

    $this->mail->isSMTP();
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->SMTPAuth = true;

    $this->mail->Username = $username;
    $this->mail->Password = $password;

    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $this->mail->Port = 587;

    $this->mail->setFrom($username, 'Delivery');
  }

  public function createMail($receiver, $subject, $body, $alt) {
    $this->mail->addAddress($receiver);
    $this->mail->isHTML(true);
    $this->mail->Subject = $subject;
    $this->mail->Body = $body;
    $this->mail->AltBody = $alt;

    $this->mail->send();
  }
}
?>
