<?php
/* Starting the session */
session_start();

if (!isset($_SESSION['USER'])) {
  header("Location: ../login.php");
  exit;
}

/* Should check for requirements */

/* Including stuff */
include_once __DIR__."/include/Connection.php";

$source = $_SESSION['ID'];

$destination = $_POST['friends'];
$description = $_POST['descrizione'];
$object = $_POST['object'];
$cost = 3*$_POST['peso'];

/* Connecting to the db */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* Search for the destination client's ID */
$mysqli_search = $connection->exec(
  "SELECT idCliente FROM utenti WHERE username='$destination';"
);
$ID = (mysqli_fetch_array($mysqli_search, MYSQLI_ASSOC))['idCliente'];

/* Inserting new payment */
$mysqli_payment = $connection->exec(
  "INSERT INTO pagamenti(descrizione, ammontare) ".
  "values('$description', $cost);"
);
$mysqli_pid = $connection->exec("SELECT LAST_INSERT_ID() as ID");
$PID = (mysqli_fetch_array($mysqli_pid, MYSQLI_ASSOC))['ID'];

/* Adding new expedition */
$mysqli_exp = $connection->exec(
  "INSERT INTO spedizioni(clienteSrc, clienteDst, pagamento) ".
  "values ($source, $ID, $PID);"
);

/* Disconnect */
$connection->disconnect();

header("Location: ../user_homepage.php");
exit;
?>
