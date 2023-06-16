<?php
session_start();
require "connectDB.php";
if (isset($_POST["submit"])) {
    if (!empty($_POST["pseudo"]) && !empty($_POST["password"])) {
        $pseudo = htmlspecialchars($_POST["pseudo"]);
        $password = sha1($_POST["password"]);

        $recupUser = $bdd->prepare("SELECT * FROM user WHERE pseudo = ? AND mdp = ?");
        $recupUser->execute(array($pseudo, $password));

        if ($recupUser->rowCount() > 0) {
            $_SESSION["pseudo"] = $pseudo;
            $_SESSION["mdp"] = $password;
            $_SESSION["id"] = $recupUser->fetch()["id"];
            header("Location: index.php");
        } else {
            echo "Erreur connexion";
        }
    } else {
        echo "Erreur";
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
    <form method="POST" action="">
        <label for="pseudo">Pseudo : </label>
        <br>
        <input type="text" name="pseudo">
        <br><br>
        <label for="password">Mot de passe : </label>
        <br>
        <input type="password" name="password">
        <br><br>
        <input type="submit" name="submit">
    </form>
</body>

</html>