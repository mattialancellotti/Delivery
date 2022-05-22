<?php
/* Starting the session */
session_start();

/* Checking if the user is logged and if it is a worker */
if (!isset($_SESSION['USER'])) {
  header("Location: ../login.php");
  exit;
}

/* Checks if there is a specified package */
if (!isset($_GET['package']))
  exit;

include_once __DIR__."/include/Connection.php";

$PACK_ID = $_GET['package'];
$USER_ID = $_SESSION['ID'];
$DATE = date("Y-m-d");
$TIME = date("H:i");

/* Establishing a connection */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* Adding the given package to the considered list */
$mysqli_add = $connection->exec(
  "UPDATE spedizioni " .
  "SET consegnaPacchi=$USER_ID, dataPartenza='$DATE', oraPartenza='$TIME' " .
  "WHERE idSpedizione=$PACK_ID;"
);

/* Disconnecting */
$connection->disconnect();
?>
