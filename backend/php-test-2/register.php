<?php
require "connectDB.php";

if (isset($_POST["submit"])) {
    if (!empty($_POST["pseudo"]) && !empty($_POST["email"]) && !empty($_POST["mdp"]) && !empty($_POST["role"])) {
        $pseudo = $_POST["pseudo"];
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];
        $role = $_POST["role"];
        $insertUser = $bdd->prepare("INSERT INTO utilisateur(pseudo_utilisateur, email_utilisateur, mdp_utilisateur, role_utilisateur) VALUES (?, ?, ?, ?)");
        $insertUser->execute([$pseudo, $email, $mdp, $role]);
        header("Location: login.php");
    } else {
        echo "Veuillez compléter tous les champs !";
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
        <label for="role">Choisissez votre rôle (Quizzer : créer des quizz, jouer ; Utilisateur : jouer) : </label>
        <br>
        <select name="role">
            <option value=""></option>
            <option value="1">Quizzer</option>
            <option value="2">Uitilsateur</option>
        </select>
        <br><br>
        <input type="submit" name="submit" value="Valider">
    </form>
    <a href="login.php">Cliquer ici si vous êtes déjà inscrit(e)</a>

</body>

</html>