<?php
session_start();

if (empty($_SESSION["email"]) || empty($_SESSION["mdp"]) || empty($_SESSION["id"])) {
    header("Location: login.php");
}

if (isset($_POST["disconnect"])) {
    header("Location: login.php");
}
echo "ID : " . $_SESSION["id"];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateur</title>
</head>

<body>
    <h1>Utilisateur</h1>
    <form method="POST">
        <button name="disconnect">
            Déconnexion
        </button>
    </form>
</body>

</html>