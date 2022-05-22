<html>
  <head>
    <title>LancellottiDelivery</title>

    <script src="./cookies.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
  </head>
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

function redirectPacks() {
  if (confirm("Vuoi davvero lasciare questa pagina?"))
    window.location.href = "./user_homepage.php";
}

function redirectAccount() {
  if (confirm("Vuoi davvero lasciare questa pagina?"))
    window.location.href = "./account.php";
}

fetch(`http://127.0.0.1/LancellottiDelivery2/api/get_friends.php`)
  .then(response => response.json())
  .then(response => {
    var el = document.getElementById('friends');
    var objects = [];

    for (var i=0; i<response.friends.length; i++) {
      (objects[i] = document.createElement('option'))
        .innerHTML = response.friends[i].username;

      /* username must be unique */
      el.appendChild(objects[i]);
    }
});
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

    <div id="new-exp" class="new-exp">
      <form method="POST" action="api/new_pack.php">
        <input type="text" name="object" id="object" placeholder="nome prodotto" required>
        <input type="text" name="peso" id="peso" placeholder="peso prodotto" required>
        <input type="text" name="descrizione" id="descrizione" placeholder="descrizione pagamento" required>
        <select name="friends" id="friends">
        </select>
        <input type="submit" name="subsub" value="Invia pacco">
      </form>
    </div>
  </body>
</html>
