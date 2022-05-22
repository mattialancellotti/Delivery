<?php
/* Starting the session */
session_start();

if (!isset($_SESSION['USER'])) {
  header("Location: ../login.php");
  exit;
}

/* Including stuff */
include_once __DIR__."/include/Connection.php";
include_once __DIR__."/include/JSONinator.php";

/* Creating a new connection */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* Gettin' all your friends ma' man */
$mysqli_friends = $connection->exec("SELECT mail, username FROM utenti;");

/* Disconnecting */
$connection->disconnect();

/* JSONizing */
$friends = createArray(array("mail", "username"), $mysqli_friends);
$obj = createObject(array("friends"), array($friends));

echo $obj;
?>
