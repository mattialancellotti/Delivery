<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>

    <script src="./config.js"></script>
    <script src="./cookies.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
  </head>
<script>
/* Checks whether the user is already logged in or not */
const cookie = new Cookie();
cookie.readCookie(document.cookie);

/* Searching for the right cookie */
const user = cookie.search('USER');

if (user != undefined)
  /* Redirecting */
  window.location.href = "./user_homepage.php";
else {
  if (!confirm("Questo sito usa i cookie vuoi continuare?"))
    window.location.href = "./gogogo.php";
}

/* Otherwise move on with the html */
fetch(`${PROTOCOL}://${IP}/LancellottiDelivery2/api/google_init.php`)
  .then(response => response.json())
  .then(response => {
  (document.getElementById("google-form"))
    .setAttribute('href', response["Link"]);
  });


function displayLogin() {
  (document.getElementById('normal-regis'))
    .style.display = 'none';
  (document.getElementById('normal-login'))
    .style.display = 'block'
}

function displayRegis() {
  (document.getElementById('normal-regis'))
    .style.display = 'block';
  (document.getElementById('normal-login'))
    .style.display = 'none'
}
</script>
  <body>
    <div id="login-container" class="login-container">
      <div id="login-header" class="login-header">
        <button id="login-header-button" class="login-header-button" onClick="displayLogin();">Log in</button>
        <button id="login-header-button" class="login-header-button" onClick="displayRegis();">Sign up</button>
      </div>
      <div id="normal-regis" class="normal-regis" style="display: none">
        <form method="GET" action="api/register.php">
          <input type="text" name="username" placeholder="username" class="login-field" required><br>
          <input type="text" name="email" placeholder="e-mail" class="login-field" required><br>
          <input type="password" name="password" placeholder="password" class="login-field" required><br>
          <input type="submit" name="form-register" value="Sign Up" class="login-input">
        </form>
      </div>
      <div id="normal-login" class="normal-login" style="display: block">
        <form method="POST" action="api/login.php">
          <input type="text" name="username" placeholder="username" class="login-field" required><br>
          <input type="password" name="password" placeholder="password" class="login-field" required><br>
          <input type="submit" name="form-login" value="Login" class="login-input">
        </form>
      </div>
      <hr id="login-bar" class="login-bar">
      <div id="assisted-login" class="assisted-login">
        <a id="google-form" href="">
          <button class="google-login login-input">Google</button>
        </a>
        o
        <a href="./register.php">
          <button class="google-login login-input">Padding</button>
        </a>
      </div>
    </div>
  </body>
</html>
