<?php
session_start();
require "connectDB.php";

if (isset($_POST["submit"])) {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $recupUser = $bdd->prepare("SELECT * FROM utilisateur WHERE email_utilisateur = :email AND mdp_utilisateur = :mdp");
        $recupUser->bindParam(":email", $email);
        $recupUser->bindParam(":mdp", $password);
        $recupUser->execute();

        if ($recupUser->rowCount() > 0) {
            $_SESSION["email"] = $email;
            $_SESSION["mdp"] = $password;
            $_SESSION["id"] = $recupUser->fetch()["id_utilisateur"];

            $recupRole = $bdd->prepare("SELECT role_utilisateur FROM utilisateur WHERE id_utilisateur = :id");
            $recupRole->bindParam(":id", $_SESSION["id"]);
            $recupRole->execute();
            $row = $recupRole->fetch(PDO::FETCH_ASSOC);

            if ($row["role_utilisateur"] == 1) {
                header("Location: quizzer.php");
            } elseif ($row["role_utilisateur"] == 2) {
                header("Location: user.php");
            } else {
                header("Location: admin.php");
            }
        }
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