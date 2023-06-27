<?php
require "classes.php";

if (isset($_GET["reg"])) {
    echo '<script type="text/javascript">';
    echo 'alert("Inscription réussie")';
    echo '</script>';
}


if (isset($_POST["submit"])) {
    $login = new Authentification();
    $login->login($_POST["email"], $_POST["password"]);
    $_SESSION["id"] = $login->getIdUser();
    $_SESSION["role"] = $login->getRoleUser();
}
?> 

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="testo.css" />
    <title>Connexion</title>
  </head>

  <body>
    <div class="login-box">
      <h2>CONNEXION</h2>
      <form method="POST">
        <div class="user-box">
          <input type="mail" name="email" />
          <br />
          <label>Email : </label>
          <br /><br />
        </div>
        <div class="user-box">
          <input type="password" name="password" />
          <br />
          <label>Mot de passe : </label>
          <br /><br />
        </div>
        <input type="ubmit" name="submit" value="Se connecter" /><br />
        <a href="register.php">S'incrire</a>
      </form>
    </div>
  </body>
</html>
