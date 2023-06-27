<?php
require "classes.php";

if (!empty($_SESSION["id"])) {
    if ($_SESSION["role"] == 0) {
        header("Location: admin.php");
    } elseif ($_SESSION["id"] == 1) {
        header("Location: quizzer.php");
    } else {
        header("Location: user.php");
    }
}

$register = new Authentification();

if (isset($_POST["submit"])) {
    $register->registration($_POST["pseudo"], $_POST["email"], $_POST["password"], $_POST["confirmpassword"], $_POST["role"]);
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
    <?php
    require "headerOffline.php";
    ?>

    <form method="POST">
        <label for="pseudo">Entrez votre pseudo : </label>
        <br>
        <input type="text" name="pseudo">
        <br><br>
        <label for="mail">Entrez votre email : </label>
        <br>
        <input type="mail" name="email">
        <br><br>
        <label for="password">Entrez votre mot de passe : </label>
        <br>
        <input type="password" name="password">
        <br><br>
        <label for="confirmpassword">Confirmez votre mot de passe : </label>
        <br>
        <input type="password" name="confirmpassword">
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

    <?php
    require "footer.php";
    ?>
</body>

</html>