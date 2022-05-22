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
if (user == undefined) {
  /* Redirecting */
  alert("failed");
  window.location.href = "login.php";
}

function packSelected(pack) {
  document.cookie = "PACK=" + pack;

  window.location.href = "pack.php";
}

function toggleMine() {
  document.getElementById('arambe-tbody').style.display = 'none';
  document.getElementById('expeditions-tbody').style.display = 'contents';
}

function toggleArambe() {
  document.getElementById('expeditions-tbody').style.display = 'none';
  document.getElementById('arambe-tbody').style.display = 'contents';
}

/* Otherwise move on with the html */
fetch(`http://192.168.1.190/LancellottiDelivery2/api/packages.php?user=${user}`)
  .then(response => response.json())
  .then(response => {
  /* Attributes to assign to every columns created */
  let attributes = [
    { class: 'body-row', onClick: 'packSelected(${idSpedizione})' },
    { class: 'body-column' }
  ];

  /* Quite confusing but that's 'cauz I designed an autistic JSON response */
  unboxJSONArray('expeditions-tbody', response['Arambe'],  attributes);
  unboxJSONArray('arambe-tbody',      response['Mine'],    attributes);
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
      <div id="expeditions-header" class="expeditions-header">
        <button id="expeditions-header-button-mine" class="worker-footer-button"
                onClick="toggleMine();">Ricevuti</button>
        <button id="expeditions-header-button-arambe" class="worker-footer-button"
                onClick="toggleArambe();">Inviati</button>
      </div>
      <table id="expeditions-table" class="expeditions-table">
        <thead>
          <tr id="expeditions-table-header" class="expeditions-table-header">
            <th class="header-column1">Spedizione</th>
            <th class="header-column1">Data Partenza</th>
            <th class="header-column1">Ora Partenza</th>
            <th class="header-column1">Ammontare</th>
            <th class="header-column1">Username</th>
          </tr>
        </thead>
        <tbody id="expeditions-tbody" class="expeditions-tbody">
        </tbody>
        <tbody id="arambe-tbody" class="arambe-tbody">
        </tbody>
      </table>
      <div id="footer-div" class="footer-div">
        <input type="button" value="Logout" class="worker-footer-button"
               onClick="window.location.href = 'api/logout.php'"/>
        <input type="button" value="Invia" class="worker-footer-button"
               onClick="window.location.href = 'new_exp.php'">
      </div>
    </div>
  </body>
</html>
