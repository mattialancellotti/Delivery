<?php
/* Starting the session */
session_start();

if (!isset($_SESSION['USER']) || !isset($_GET['user'])) {
  header('Location: ../login.php');
  exit;
}

include_once __DIR__."/include/Connection.php";
include_once __DIR__."/include/JSONinator.php";

/* Establising the connection */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

$user_id = $_GET['user'];

$mysqli_result = mysqli_fetch_assoc($connection->exec(
  "SELECT Nome, Cognome, Indirizzo, mail, username FROM utenti u ".
  "LEFT JOIN persone p ON p.idPersona=u.persona ".
  "WHERE idCliente='$user_id'"
));

/* Disconnecting */
$connection->disconnect();

($mysqli_result == FALSE) and die("Boh");

$jinfo = assocToJSON(
  array("Nome", "Cognome", "Indirizzo", "mail", "username"),
  $mysqli_result
);

echo createNestedJSON(
  array("info"),
  array($jinfo)
);
?>
