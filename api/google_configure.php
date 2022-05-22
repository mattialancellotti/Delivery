<?php
/*
 * -- api/google_configure.php
 *
 * This page configures all the parameters that the user needs to
 * log-in via his google account. Refer to google's documentation
 * I still dont' understand what it is doing.
 */

/* Starting the session */
session_start();

/* Checking state */
(!isset($_GET['code'])) && die("Something went wrong during verification");

/* Including the necessary libraries */
include_once __DIR__."/include/Goblin.php";
include_once __DIR__."/include/Connection.php";

$c_id = '<your ID>';
$c_secret = '<you secret>';
$uri = 'http://127.0.0.1/LancellottiDelivery2/api/google_configure.php';

/* Initiating connection to request the token */
$goblin = new Goblin($c_id, $c_secret, $uri, array('profile', 'email'));
$_SESSION['CODE'] = $_GET['code'];
$goblin->requestToken();

/* DATAAAAAAAAAAAAAA */
$user = $goblin->configureUser();

/* Establishing a connection to the database */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* Building and executing the query */
$account = "SELECT idCliente FROM utenti WHERE mail=\"".$user->email."\";";
$mysqli_result = $connection->exec($account);

/* Closing the connection */
$connection->disconnect();

$_SESSION['USER'] = $user->name;
$_SESSION['MAIL'] = $user->email;

/* This code checks whether the login was successfull or not */
if (mysqli_num_rows($mysqli_result) == 0) {
  /* Redirecting to the registration */
  header("Location: ./google_register.php");
  ob_end_flush();
  exit;
}

/* Saving the necessary information */
$idCliente = (mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC))['idCliente'];

/* Creating the cookie */
setcookie('USER', $idCliente, time() + (86400 * 30), "/");
$_SESSION['ID'] = $idCliente;

/* Redirecting */
header('Location: ../user_homepage.php');
?>
