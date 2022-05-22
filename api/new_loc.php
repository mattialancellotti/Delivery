<?php
/* Starting the session */
session_start();

/* Starting a session */
if (!isset($_SESSION['USER'])) {
  header("Location: ../login.php");
  exit;
}

/* Checking the required parameters */
(!isset($_GET['pack'])) and die("Ritenta e sarai piu' fortunato");

/* Including stuff */
include_once __DIR__."/include/Connection.php";

$DATE = date("Y-m-d");
$TIME = date("H:i");
$PACK = $_GET['pack'];
$STATE = $_GET['state'];

/* Connecting */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* Checks if it has been alredy received */
$mysqli_check = $connection->exec(
  "SELECT stato FROM tappe " .
  "WHERE spedizione=$PACK AND stato=2"
);
(mysqli_num_rows($mysqli_check) != 0) and exit;

/* Inserting the new location */
$mysqli_insert = $connection->exec(
  "INSERT INTO tappe(spedizione, dataArrivo, oraArrivo, latitude, longitude, stato) " .
  "values ($PACK, '$DATE', '$TIME', '0.0000', '0.0000', $STATE);"
);

/* Disconnecting */
$connection->disconnect();

exit;
?>
