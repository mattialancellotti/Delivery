<?php
/* Starting the session */
session_start();

/* Checking if the user is logged and if it is a worker */
if (!isset($_SESSION['USER'])) {
  header("Location: ../login.php");
  exit;
}

include_once __DIR__."/include/Connection.php";
include_once __DIR__."/include/JSONinator.php";

$user = $_SESSION['ID'];

/* Creating connection */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

$mysqli_waiting = $connection->exec(
  /* THE LONG BOY */
  "SELECT idSpedizione, username, Indirizzo_Recupero, Indirizzo as Indirizzo_Destinazione " .
  "FROM (SELECT idSpedizione, clienteDst, Indirizzo as Indirizzo_Recupero " .
        "FROM spedizioni s " .
        "INNER JOIN utenti u ON u.idCliente=s.clienteSrc " .
        "INNER JOIN persone p ON p.idPersona=u.persona " .
        "WHERE s.consegnaPacchi is NULL) AS t " .
  "INNER JOIN utenti u ON u.idCliente=t.clienteDst ".
  "INNER JOIN persone p ON p.idPersona=u.persona;"
);

$mysqli_considered = $connection->exec(
  /* Seriously though we might need a view for `THE LONG BOY` */
  "SELECT idSpedizione, username, Indirizzo_Recupero, Indirizzo as Indirizzo_Destinazione " .
  "FROM (SELECT idSpedizione, clienteDst, Indirizzo as Indirizzo_Recupero " .
        "FROM spedizioni s " .
        "INNER JOIN utenti u ON u.idCliente=s.clienteSrc " .
        "INNER JOIN persone p ON p.idPersona=u.persona " .
        "WHERE s.consegnaPacchi=$user) AS t " .
  "INNER JOIN utenti u ON u.idCliente=t.clienteDst ".
  "INNER JOIN persone p ON p.idPersona=u.persona;"
);

/* Disconnecting */
$connection->disconnect();

/* need to put in a JSON */
$waiting_list = 
  createArray(array("id", "username", "src", "dst"), $mysqli_waiting);
$considered_list =
  createArray(array("id", "username", "src", "dst"), $mysqli_considered);

echo createObject(
  array("waiting", "considered"),
  array($waiting_list, $considered_list)
);
?>
