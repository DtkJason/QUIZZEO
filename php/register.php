<!-- <?php
require "classes.php";

$register = new Authentification();

if (isset($_POST["submit"])) {
    $register->registration($_POST["pseudo"], $_POST["email"], $_POST["password"], $_POST["confirmpassword"], $_POST["role"]);
}
?> -->

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
    <link rel="stylesheet" href="test.css" />
    <title>Inscription</title>
  </head>

  <body>

  <?php
    require "headerOffline.php";
    ?>
    <?php
    require "interro.php";
    ?>
    <div class="login-box">
      <h2>INSCRIPTION</h2>
      <!-- <form method="POST">
          <div class="user-box">
            <input type="mail" name="email" />
            <br />
            <label>Email : </label>
            <br /><br />
          </div>
          <div >
            <input type="password" name="password" />
            <br />
            <label>Mot de passe : </label>
            <br /><br />
          </div>
          <input type="ubmit" name="submit" value="Se connecter" /><br />
          <a href="register.php">S'incrire</a>
        </form> -->

      <form method="POST">
        <div class="user-box">
          <input type="text" name="pseudo" required="" />
          <label>Entrez votre pseudo </label>
        </div>
        <div class="user-box">
          <input type="mail" name="email" required="" />
          <br />
          <label for="mail">Entrez votre email </label>
        </div>
        <div class="user-box">
          <input type="password" name="password" required="" />
          <br />
          <label for="password">Entrez votre mot de passe </label>
        </div>
        <div class="user-box">
          <input type="password" name="confirmpassword" required="" />
          <br />
          <label for="confirmpassword">Confirmez votre mot de passe </label>
        </div>
        <label class="labelselect" for="role"
          >Choisissez votre rôle (Quizzer : créer des quizz, jouer ; Utilisateur
          : jouer) :
        </label>
        <br />
        <div class="select">
          <select name="role">
            <option value=""></option>
            <option value="1">Quizzer</option>
            <option value="2">Uitilsateur</option>
          </select>
          <div class="select_arrow"></div>
        </div>

        <input type="submit" class="conet" name="submit" value="Valider" />
        <a href="login.php">Cliquer ici si vous êtes déjà inscrit(e)</a>
      </form>
    </div>
    <?php
    require "logo.php";
    ?>

    <?php
    require "footer.php";
    ?>
  </body>
</html>
