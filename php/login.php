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
<<<<<<< HEAD
</head>

=======
  </head>
>>>>>>> 8ea8d13ecf84702bda31b1ffd95abdcaf32c312d

<body>
    <?php
    require "headerOffline.php";
    ?>

    <form method="POST">
        <label for="mail">Email : </label>
        <br>
        <input type="mail" name="email">
        <br><br>
        <label for="password">Mot de passe : </label>
        <br>
        <input type="password" name="password">
        <br><br>
        <input type="submit" name="submit">
    </form>
<<<<<<< HEAD

    <?php
    require "footer.php";
    ?>
=======
    <a href="register.php">S'incrire</a>
>>>>>>> 8ea8d13ecf84702bda31b1ffd95abdcaf32c312d
</body>

</html>
