<?php
/* Starting the session */
session_start();

/* Checking for weird stuff */
(!isset($_SESSION['CODE'])) && die("Couldn't register the user");
(!isset($_SESSION['USER']) || !isset($_SESSION['MAIL']))
  and die("Couldn't read user's information");

/* Including stuff */
include_once __DIR__."/include/Connection.php";

/* Creating a connection to the DB */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* Executing the query */
$mysqli_result = $connection->exec(
  "INSERT INTO utenti(username, mail) ".
  "values(\"".$_SESSION['USER']."\", \"".$_SESSION['MAIL']."\");"
);

/* Grabbing the ID of the last insert row */
$last_ID = $connection->exec("SELECT LAST_INSERT_ID() as ID");

/* Closing the connetion */
$connection->disconnect();

/* Checking the result */
($mysqli_result == FALSE) and die("Insert failed");

$id = (mysqli_fetch_array($last_ID, MYSQLI_ASSOC))['ID'];

/* Creating the cookie */
setcookie('USER', $id, time() + (86400 * 30), "/");
$_SESSION['ID'] = $id;

header("Location: ../user_homepage.php");
exit;
?>
