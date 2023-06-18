<?php
require "classes.php";

$login = new Login();

if (isset($_POST["submit"])) {
    $result = $login->login($_POST["email"], $_POST["password"]);
    if ($result == 1) {
        $_SESSION["id"] = $login->idUser();
        $_SESSION["role"] = $login->roleUser();

        if ($_SESSION["role"] == 0) {
            header("Location: admin.php");
        } elseif ($_SESSION["role"] == 1) {
            header("Location: quizzer.php");
        } else {
            header("Location: user.php");
        }
    } elseif ($result == 2) {
        echo '<script type="text/javascript">';
        echo 'alert("Mot de passe incorrect")';
        echo '</script>';
    } elseif ($result == 3) {
        echo '<script type="text/javascript">';
        echo 'alert("Utilisateur inexistant")';
        echo '</script>';
    }
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
</body>

</html>