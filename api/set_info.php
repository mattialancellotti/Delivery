<?php
/* Starting a session */
session_start();

if (!isset($_SESSION['USER'])) {
  header("Location: ../login.php");
  exit;
}

(!isset($_GET['name']) || !isset($_GET['surname']) || !isset($_GET['address']) 
                       || !isset($_GET['username']) || !isset($_GET['email']))
  and die("Boh");

/* Including all the necessary */
include_once __DIR__."/include/Connection.php";

/* Establishing a connection */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

$name = $_GET['name'];
$surname = $_GET['surname'];
$address = $_GET['address'];
$username = $_GET['username'];
$email = $_GET['email'];

/* Updating the two tables */
$utenti_result = $connection->exec(
  "UPDATE utenti SET mail='$email', username='$username' " .
  "WHERE idCliente=" . $_SESSION['ID'] . ";"
);
$persone_result = $connection->exec(
  "UPDATE persone SET Nome='$name', Cognome='$surname', Indirizzo='$address' ".
  "WHERE idPersona=" . $_SESSION['P'] . ";"
);

/* Disconnecting */
$connection->disconnect();

/* Redirect */
header("Location: ../account.php");
exit;
?>
