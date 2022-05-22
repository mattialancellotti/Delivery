<?php
/* Starting the session */
session_start();

/* REMEMBER REMEMBER YOU NEED TO ADD A LOGIN CHECK HERE */

/* Including things */
include_once __DIR__."/include/Connection.php";
include_once __DIR__."/include/JSONinator.php"; # To handle jsons

/* Creating a connection */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* Gathering the package */
$package = $_GET['package'];
$user = $_SESSION['ID'];

/* Querying */
$mysqli_pack = mysqli_fetch_assoc($connection->exec(
  "SELECT idSpedizione, dataPartenza, oraPartenza, ammontare, ".
  "descrizione, username, mail, Indirizzo ".
  "FROM spedizioni s ".
  "INNER JOIN utenti u ON u.idCliente = s.clienteDst ".
  "INNER JOIN persone p ON p.idPersona = u.persona " .
  "INNER JOIN pagamenti t ON t.idPagamento = s.pagamento ".
  "WHERE idSpedizione=$package;"
));

/* Getting all locations */
$mysqli_locations = $connection->exec(
  "SELECT dataArrivo, oraArrivo, latitude, longitude " .
  "FROM tappe " .
  "WHERE spedizione=$package;"
);

/* Disconnecting */
$connection->disconnect();

/* Creating json object */
$jpack = assocToJSON(
  array("idSpedizione", "dataPartenza", "oraPartenza",  "Indirizzo"),
  $mysqli_pack
);
$jpay  = assocToJSON(array("ammontare", "descrizione"), $mysqli_pack);
$juser = assocToJSON(array("username", "mail"), $mysqli_pack);
$all_l = createArray(
  array("dataArrivo", "oraArrivo", "latitude", "longitude"),
  $mysqli_locations
);

/* Givin' it all again */
echo createNestedJSON(
  array("pack", "payment", "user", "locations"),
  array($jpack, $jpay, $juser, $all_l)
);
?>
