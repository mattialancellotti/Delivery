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
  window.location.href = "./login.php";
}

function packSelected(pack) {
  document.cookie = "PACK=" + pack;

  window.location.href = "worker_pack.php";
}

function togglePicked() {
  document.getElementById('waiting-tbody').style.display = 'none';
  document.getElementById('yours-tbody').style.display = 'contents';
}

function toggleWait() {
  document.getElementById('yours-tbody').style.display = 'none';
  document.getElementById('waiting-tbody').style.display = 'contents';
}

function add(selected) {
  fetch(`http://192.168.1.190/LancellottiDelivery2/api/consider_exp.php?package=${selected}`)
    .then(response => {
      window.location.href = "./worker_homepage.php";
  });
}

fetch(`http://1192.168.1.190/LancellottiDelivery2/api/worker.php`)
  .then(response => response.json())
  .then(response => {
  /* Attributes to assign to every columns created */
  let attributes0 = [
    { class: 'body-row', onClick: 'add(${id})' },
    { class: 'body-column' }
  ];
  let attributes1 = [
    { class: 'body-row', onClick: 'packSelected(${id})' },
    { class: 'body-column' }
  ];

  unboxJSONArray('waiting-tbody', response['waiting'], attributes0);
  unboxJSONArray('yours-tbody', response['considered'], attributes1);
});

</script>
    <header id="page-header" class="page-header">
      <h2>CIAO SCHIAVO</h2>
      <hr>
    </header>

    <div id="qrcode-div" class="qrcode-div">
      <p id="info" class="info">Accedi al sito da mobile: </p>
      <img src="./immagini/qrcode.png" width="150px">
    </div>
    <div id="expeditions" class="expeditions">
      <div id="expeditions-header" class="expeditions-header">
        <button id="worker-button-wait" class="worker-footer-button"
                onClick="toggleWait();">In attesa</button>
        <button id="expeditions-header-button-arambe" class="worker-footer-button"
                onClick="togglePicked();">Considerati</button>
      </div>
      <table id="expeditions-table" class="expeditions-table">
        <thead>
          <tr id="expeditions-table-header" class="expeditions-table-header">
            <th class="header-column1">Spedizione</th>
            <th class="header-column1">Nome destinatario</th>
            <th class="header-column1">Indirizzo partenza</th>
            <th class="header-column1">Indirizzo consegna</th>
          </tr>
        </thead>
        <tbody id="waiting-tbody" class="expeditions-tbody">
        </tbody>
        <tbody id="yours-tbody" class="arambe-tbody">
        </tbody>
      </table>
      <div id="footer-div" class="footer-div">
        <input type="button" value="Logout" class="worker-footer-button"
               onClick="window.location.href = 'api/logout.php'"/>
      </div>
    </div>
  </body>
</html>
