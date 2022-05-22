<?php
/* Starting the session */
session_start();

if (!isset($_SESSION['USER'])) {
  header("Location: ../login.php");
  exit;
}

/* Random checks of what this piece of script needs */

/* Including stuff */
include_once __DIR__."/include/Connection.php";

/* Connecting to the database */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* Should also checks how many codes have been generated by the user */

/* Creating a code */
date_default_timezone_set('Europe/Riga');
$code = sha1($_SESSION['USER'] . time()); // I like hashing things 
$user = $_SESSION['ID'];
$date = date("Y/m/d", time());  // date() is broken dunno y

$mysqli_code = $connection->exec(
  "INSERT INTO codici(codice, utente, fineValidita) ".
  "values ('$code', $user, $date);"
);

/* Disconnecting */
$connection->disconnect();

/* JSONIZINGGG */
echo "{ \"code\":\"".$code."\" }";
?>
