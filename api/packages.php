<?php
/*
 * -- api/packages.php
 *
 * This file is used to retrieve all the packages sent (might also add a
 * received section) by the user logged. This is done by asking the database
 * to select all the packages with `clientSrc` equal to the current user to
 * then econde the result in json and sending it javascript.
 */

/* Starting the session */
session_start();

header('Access-Control-Allow-Origin: *');

if (!isset($_SESSION['USER'])) {
  header("Location: ../login.php");
  exit;
}

/* Including the necessary stuff */
include_once __DIR__."/include/Connection.php";
include_once __DIR__."/include/JSONinator.php";


/* Creating and establishing the connection */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* Getting the necessary infos */
$id = $_GET['user'];

/* Downloading all the expeditions */
$my_packages = $connection->exec(
  "SELECT idSpedizione, username, dataPartenza, oraPartenza, ammontare ".
  "FROM spedizioni s " .
  "INNER JOIN pagamenti c ON c.idPagamento = s.pagamento " .
  "INNER JOIN utenti u ON u.idCliente = s.clienteDst " .
  "WHERE clienteSrc=".$id.";"
);

/* Downloading all received packages */
$arambe_packages = $connection->exec(
  "SELECT idSpedizione, username, dataPartenza, oraPartenza, ammontare ".
  "FROM spedizioni s " .
  "INNER JOIN pagamenti c ON c.idPagamento = s.pagamento " .
  "INNER JOIN utenti u ON u.idCliente = s.clienteSrc " .
  "WHERE clienteDst=".$id.";"
);

/* Close connection */
$connection->disconnect();

/* The packages I sent */
$mine = createArray(
  array(
    "idSpedizione", "username", "dataPartenza", "oraPartenza", "ammontare"
  ),
  $my_packages
);

/* The packages I was sent */
$arambe = createArray(
  array(
    "idSpedizione", "username", "dataPartenza", "oraPartenza", "ammontare"
  ),
  $arambe_packages
);

/* Givin' it all */
echo createObject(array("Mine", "Arambe"), array($mine, $arambe));
?>
