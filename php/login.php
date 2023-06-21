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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>

<body>
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
    <a href="register.php">S'incrire</a>
</body>

</html>