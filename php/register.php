<<<<<<< HEAD
<?php
require "classes.php";

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
    <a href="login.php">Cliquer ici si vous êtes déjà inscrit(e)</a>

</body>

=======
<?php
require "classes.php";

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
    <a href="login.php">Cliquer ici si vous êtes déjà inscrit(e)</a>

</body>

>>>>>>> 4972b6d96e98a2c84997d99455e343c43cdcf1f0
</html>