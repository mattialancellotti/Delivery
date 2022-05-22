<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>

    <script src="cookies.js"></script>
    <script src="settings.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
  </head>
<script>
/* Checks whether the user is already logged in or not */
const cookie = new Cookie();
cookie.readCookie(document.cookie);

/* Searching for the right cookie */
const user = cookie.search('USER');
if (user == undefined)
  window.location.href = "./login.php";

fetch(`${PROTOCOL}://192.168.1.190/LancellottiDelivery2/api/get_info.php?user=${user}`)
  .then(response => response.json())
  .then(response => {
    (document.getElementById('name'))
      .value = response['info'].Nome;
    (document.getElementById('surname'))
      .value = response['info'].Cognome;
    (document.getElementById('address'))
      .value = response['info'].Indirizzo;
    (document.getElementById('username'))
      .value = response['info'].username;
    (document.getElementById('email'))
      .value = response['info'].mail;
  });

function requestCode() {
  fetch(`${PROTOCOL}://192.168.1.190/LancellottiDelivery2/api/share.php`)
    .then(response => response.json())
    .then(response => {
      alert("Ecco il tuo codice: " + response.code);
  });
}

function redirectPacks() {
  window.location.href = "./user_homepage.php";
}

function redirectAccount() {
  window.location.href = "./account.php";
}
</script>
  <body>
    <header id="page-header" class="page-header">
      <div id="header-homepage" class="header-homepage">
        <button id="header-button-mine" class="header-button expeditions-header-button"
                onClick="redirectPacks();">Pacchi</button>
        <button id="header-button-arambe" class="header-button expeditions-header-button"
                onClick="redirectAccount();">Account</button>
      </div>
      <hr>
    </header>

    <div id="account-container" class="login-container normal-login">
      <h2>My Account</h2>
      <form method="GET" action="api/set_info.php">
        <div id="personal-info" class="personal-info">
          <input type="text" name="name" id="name" placeholder="nome" class="short-login-field"><br>
          <input type="text" name="surname" id="surname" placeholder="cognome" class="short-login-field"><br>
        </div>
        <input type="text" name="address" id="address" placeholder="indirizzo" class="login-field"><br>
        <input type="text" name="username" id="username" placeholder="username" class="login-field"><br>
        <input type="text" name="email" id="email" placeholder="e-mail" class="login-field"><br>
        <input type="submit" name="form-register" value="Update" class="login-input">
      </form>
      <hr id="login-bar" class="login-bar">
      <div id="assisted-login" class="assisted-login">
        <input type="submit" class="google-login login-input" value="Condividi" onClick="requestCode();">
      </div>
    </div>
  </body>
</html>
