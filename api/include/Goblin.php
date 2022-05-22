<?php
require_once __DIR__."/../../vendor/autoload.php";

class Goblin {
  private $g_client, $g_service;

  public function __construct($id, $secret, $uri, $scopes) {
    $this->g_client = new Google_Client();
    $this->g_client->setClientId($id);
    $this->g_client->setClientSecret($secret);
    $this->g_client->setRedirectUri($uri);
    $this->g_client->setScopes($scopes);

    $this->g_service = new Google_Service_Oauth2($this->g_client);
  }

  public function getClient() {
    return $this->g_client;
  }

  public function getService() {
    return $this->g_service;
  }

  public function requestToken() {
    /* Checking if the code has been sent */
    (!isset($_SESSION['CODE']) && !$_SESSION['CODE'])
      and die('$_SESSION["CODE"] not set');

    /* Prcessing the code */
    $this->g_client->authenticate($_SESSION['CODE']);
    $_SESSION['TOKEN'] = $this->g_client->getAccessToken();
  }

  public function getAuthLink() {
    /* Checking if the user is already logged in */
    (isset($_SESSION['TOKEN']) && $_SESSION['TOKEN']) 
      and die("User already authenticated");

    /* Sending back the link */
    return array("Link" => $this->g_client->createAuthUrl());
  }

  public function configureUser() {
    $this->g_client->setAccessToken($_SESSION['TOKEN']);
    return $this->g_service->userinfo->get();
  }
}
?>
