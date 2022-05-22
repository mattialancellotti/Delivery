<html>
  <head>
    <title>LancellottiDelivery</title>

    <script src="cookies.js"></script>
    <script src="functions.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
  </head>
  <body>
<script>
/* Grabbing the COOOKIESSS */
const cookie = new Cookie();
cookie.readCookie(document.cookie);

/* Searching for the right cookie */
const user = cookie.search('USER');
const pack = cookie.search('PACK');
if (user == undefined)
  /* Redirecting */
  window.location.href = "./login.php";

if (pack == undefined)
  console.log("undefined");

fetch(`http://192.168.1.190/LancellottiDelivery2/api/pack.php?package=${pack}`)
  .then(response => response.json())
  .then(response => {
  let attributes = [
    { class: 'body-row' }, { class: 'body-column' }
  ];

  unboxJSON('expeditions-tbody', response['pack'],    attributes);
  unboxJSON('payment-tbody',     response['payment'], attributes);
  unboxJSON('users-tbody',       response['user'],    attributes);

  unboxJSONArray('locations-tbody', response['locations'], attributes);
});
</script>
    <header id="page-header" class="page-header">
      <div id="header-homepage" class="header-homepage">
        <button id="header-button-mine" class="header-button expeditions-header-button"
                onClick="window.location.href = 'user_homepage.php';">Pacchi</button>
        <button id="header-button-arambe" class="header-button expeditions-header-button"
                onClick="window.location.href = 'account.php';">Account</button>
      </div>
      <hr>
    </header>

    <div id="qrcode-div" class="qrcode-div">
      <p id="info" class="info">Accedi al sito da mobile: </p>
      <img src="./immagini/qrcode.png" width="150px">
    </div>
    <div id="expeditions" class="expeditions">
    </div>
    <table id="expeditions-table" class="new-expeditions-table">
      <thead>
        <tr id="expeditions-table-header" class="new-expeditions-table-header">
          <th class="new-header-column1">Spedizione</th>
          <th class="new-header-column1">Data Partenza</th>
          <th class="new-header-column1">Ora Partenza</th>
          <th class="new-header-column1">Indirizzo Destinazione</th>
        </tr>
      </thead>
      <tbody id="expeditions-tbody" class="expeditions-tbody">
      </tbody>
    </table>
    <table id="payments-table" class="new-expeditions-table">
      <thead>
        <tr id="payments-table-header" class="new-expeditions-table-header">
          <th class="new-header-column1">Ammontare</th>
          <th class="new-header-column1">Descrizione</th>
        </tr>
      </thead>
      <tbody id="payment-tbody" class="expeditions-tbody">
      </tbody>
    </table>
    <table id="users-table" class="new-expeditions-table">
      <thead>
        <tr id="users-table-header" class="new-expeditions-table-header">
          <th class="new-header-column1">Username</th>
          <th class="new-header-column1">E-Mail</th>
        </tr>
      </thead>
      <tbody id="users-tbody" class="expeditions-tbody">
      </tbody>
    </table>
    <table id="users-table" class="new-expeditions-table">
      <thead>
        <tr id="users-table-header" class="new-expeditions-table-header">
          <th class="new-header-column1">Data Arrivo</th>
          <th class="new-header-column1">Ora Arrivo</th>
          <th class="new-header-column1">Latitudine</th>
          <th class="new-header-column1">Longitudine</th>
        </tr>
      </thead>
      <tbody id="locations-tbody" class="expeditions-tbody">
      </tbody>
    </table>
    <div id="footer-div" class="footer-div">
      <input type="button" value="Logout" class="worker-footer-button"
            onClick="window.location.href = 'api/logout.php'"/>
    </div>
  </body>
</html>
