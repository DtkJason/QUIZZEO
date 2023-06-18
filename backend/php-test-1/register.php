<?php
session_start();
require "connectDB.php";

if (isset($_POST["submit"])) {
    if (!empty($_POST["pseudo"]) && !empty($_POST["email"]) && !empty($_POST["mdp"])) {
        $pseudo = htmlspecialchars($_POST["pseudo"]);
        $email = htmlspecialchars($_POST["email"]);
        $mdp = sha1($_POST["mdp"]);
        $insertUser = $bdd->prepare("INSERT INTO user(pseudo, email, mdp) VALUES (?, ?, ?)");
        $insertUser->execute(array($pseudo, $email, $mdp));

        $recupID = $bdd->prepare("SELECT * FROM user WHERE pseudo = ? AND email = ? AND mdp = ?");
        $recupID->execute(array($pseudo, $email, $mdp));
        if ($recupID->rowCount() > 0) {
            $_SESSION["id"] = $recupID->fetch()["id"];
            $_SESSION["pseudo"] = $pseudo;
            $_SESSION["email"] = $email;
            $_SESSION["mdp"] = $mdp;
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
    <title>Inscription</title>
</head>

<body>
    <form method="POST">
        <label for="pseudo">Entrez votre pseudo : </label>
        <br>
        <input type="text" name="pseudo">
        <br><br>
        <label for="email">Entrez votre email : </label>
        <br>
        <input type="email" name="email">
        <br><br>
        <label for="mdp">Entrez votre mot de passe : </label>
        <br>
        <input type="password" name="mdp">
        <br><br>
        <select name="role">
            <option value=""></option>
            <option value="1">Quizzer</option>
            <option value="2">Uitilsateur</option>
        </select>
        <br><br>
        <input type="submit" name="submit">
    </form>
    <a href="login.php">Se connecter</a>

</body>

</html>