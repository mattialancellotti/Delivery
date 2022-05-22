<?php
/*
 * -- api/register.php
 *
 * Just register people.
 */

/* Startin the session */
session_start();

/* Including all the necessary */
include_once __DIR__."/include/Connection.php";
include_once __DIR__."/include/Mailer.php";

/* Checking if the page has been called by the client */
(!isset($_GET['username']) || !isset($_GET['email'])
                           || !isset($_GET['password']))
  and die("Temporary solution.. should redirect to login again");

$user = $_GET['username'];
$mail = $_GET['email'];
$enc_pass = hash('sha256', $_GET['password']);

/* Establishin a connection */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* See if the user is already registered */
$check = $connection->exec(
  "SELECT idCliente FROM utenti ".
  "WHERE username='$user' AND password='$enc_pass' AND mail='$mail';"
);

(mysqli_num_rows($check) != 0) 
  and header('Location: ../login.php');

/* Checking the mail */
try {
  $mailer = new Mailer('<you email>', '<skidadle skidoodle>');
  $mailer->createMail(
    $mail, 'Registrazione', 
    'Grazie per esserti registrato',
    'Grazie per esserti registrato'
  );
} catch (Exception $e) {
  die("Error");
}

/* Inserting a new 'person' */
$mysqli_person = $connection->exec("INSERT INTO persone(Nome) values('');");
$mysqli_ID = $connection->exec("SELECT LAST_INSERT_ID() as ID;");

/* Checking for security reasons */
($mysqli_ID == FALSE) and die("Something went wrong");

/* Adding the new client */
$ID = (mysqli_fetch_array($mysqli_ID, MYSQLI_ASSOC))['ID'];
$register = 
  "INSERT INTO utenti(persona, password, mail, username) ".
  "VALUES('$ID', '$enc_pass', '$mail', '$user');";
$mysqli_result = $connection->exec($register);

/* Closing the connection */
$connection->disconnect();

/* Redirecting to login */
header('Location: ../login.php');
?>
