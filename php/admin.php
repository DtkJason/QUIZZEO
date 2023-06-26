<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}

if ($_SESSION["role"] != 0) {
    header("Location: accessDenied.php");
}

if (isset($_POST["disconnect"])) {
    session_destroy();
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateur</title>
</head>

<body>
    <h1>Administrateur</h1>

    <a href="adminPage.php">Gérer les membres</a>
    <a href="allQuizzAdmin.php">Liste des Quizz</a>

    <form method="POST">
        <button name="disconnect">
            Déconnexion
        </button>
    </form>
</body>

</html>