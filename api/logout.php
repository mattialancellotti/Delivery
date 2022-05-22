<?php
/*
 * -- api/logout.php
 *
 * This page deletes all cookies and sessions stored for the user.
 * Might want to elaborate this.
 */

/* Starting the session */
session_start();

/* Checking for cookies */
if (isset($_COOKIE['USER'])) {
  unset($_COOKIE['USER']);
  setcookie('USER', null, -1, '/');
}

/* Checking for sessions */
if (isset($_SESSION['USER'])) {
  session_unset();
  session_destroy();
} else
  die("How could you get here?!");

header('Location: ../login.php');
?>
