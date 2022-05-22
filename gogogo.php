<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
  </head>
<script>
fetch(`http://127.0.0.1/LancellottiDelivery2/api/human_garbage.php`)
  .then(response => response.json())
  .then(response => {
    (document.getElementById("gogogo"))
      .setAttribute("src", response["data"]["image_original_url"]);
    });
</script>
  <body>
    <img id="gogogo" width="80%">
  </body>
</html>
