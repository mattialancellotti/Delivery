<?php
/*
 * -- api/google_init.php
 *
 * This page asks google's servers for an authentication link that will be sent 
 * to the user once the communication with google'server is complete.
 */

/* Starting the session */
session_start();

header('Access-Control-Allow-Origin: *');

/* Checking if the user isn't already logged in */
if (isset($_SESSION['USER']))
  header('Location: ../user_homepage.php?user='.$_SESSION['USER']);

/* Move on with the rest */
include_once __DIR__."/include/Goblin.php"; # Necessary for google auth 2.0

$c_id = '<your ID>';
$c_secret = '<your secret>';
$uri = 'http://127.0.0.1/LancellottiDelivery2/api/google_configure.php';

/* Initiating connection */
$goblin = new Goblin($c_id, $c_secret, $uri, array('profile', 'email'));

/* Creating and sending the link so the user can click on it */
$json_link = json_encode($goblin->getAuthLink());
echo $json_link;
?>
