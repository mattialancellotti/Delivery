<?php
/*
 * -- api/login.php
 *
 * Normal login page to let a normal user login by using its 
 * username and its password. Might be interesting to implement
 * a log-in via email and not only username
 */

/* Starting session */
session_start();

/* Checking if the user isn't already logged in */
if (isset($_SESSION['USER']))
  header('Location: ../user_homepage.php?user='.$_SESSION['USER']);

include_once __DIR__."/include/Connection.php";

/* Establishing a connection */
$connection = new Connection("localhost", "root", "lancellottidelivery");
$connection->establish();

/* Grabbing infos */
$username = $_POST['username'];
$password = hash('sha256', $_POST['password']);

/* Checking the user */
$mysqli_result = $connection->exec(
  "SELECT idCliente, persona FROM utenti ".
  "WHERE username='$username' AND password='$password';"
);

/* Closing the connection */
$connection->disconnect();

(mysqli_num_rows($mysqli_result) == 0) and die("Not found");

/* Saves the necessary information about the user */			
$cliente = mysqli_fetch_array($mysqli_result, MYSQLI_ASSOC);

/* Storing necessary  information */
setcookie('USER', $cliente['idCliente'], time() + (86400 * 30), "/");
$_SESSION['USER'] = $username;
$_SESSION['ID'] = $cliente['idCliente'];
$_SESSION['P'] = $cliente['persona'];
			
/* Redirecting */
header('Location: ../user_homepage.php');
exit;
?>
