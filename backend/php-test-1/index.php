<?php
session_start();
echo "Vous êtes connecté(e) en tant que : " . $_SESSION["pseudo"];

if (empty($_SESSION["pseudo"]) || empty($_SESSION["mdp"]) || empty($_SESSION["id"])) {
    header("Location: login.php");
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
    <title>Quizzeo</title>
</head>

<body>
    <form method="POST">
        <button name="disconnect">Déconnexion</button>
    </form>
</body>

</html>