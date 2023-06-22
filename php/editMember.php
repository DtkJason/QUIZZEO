<<<<<<< HEAD
<?php
require "classes.php";

if ((isset($_POST["password"]) && isset($_POST["newpassword"]) && isset($_POST["password"]))) {
    $editPassword = new Admin();
    $editPassword->editPassword($_POST["password"], $_POST["newpassword"], $_POST["confirmnewpassword"], $_GET["id"]);
} elseif (isset($_POST["newpseudo"])) {
    $editPseudo = new Admin();
    $editPseudo->editPseudo($_POST["newpseudo"], $_GET["id"]);
} elseif (isset($_POST["newemail"])) {
    $editEmail = new Admin();
    $editEmail->editEmail($_POST["newemail"], $_GET["id"]);
}

if (!isset($_POST["newpseudo"])) {
    $pseudo = $_GET["pseudo"];
} else {
    $pseudo = $_POST["newpseudo"];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier utilisateur</title>
</head>

<body>
    <h1>Modifier utilisateur : <?php echo $pseudo; ?></h1>
    <br>
    <form method="POST"><b>Modifier mot de passe :</b>
        <br><br>
        <label>Mot de passe actuel : </label>
        <br>
        <input type="password" name="password">
        <br><br>
        <label>Nouveau mot de passe : </label>
        <br>
        <input type="password" name="newpassword">
        <br><br>
        <label>Confirmer nouveau mot de passe : </label>
        <br>
        <input type="password" name="confirmnewpassword">
        <br><br>
        <input type="submit" name="submitpassword">
    </form>
    <br><br>
    <form method="POST"><b>Modifier pseudo : </b>
        <br><br>
        <label>Nouveau pseudo : </label>
        <br>
        <input type="text" name="newpseudo">
        <br><br>
        <input type="submit" name="submitpseudo">
    </form>
    <br><br>
    <form method="POST"><b>Modifier email : </b>
        <br><br>
        <label>Nouvel email : </label>
        <br>
        <input type="text" name="newemail">
        <br><br>
        <input type="submit" name="submitemail">
    </form>
</body>

=======
<?php
require "classes.php";

if ((isset($_POST["password"]) && isset($_POST["newpassword"]) && isset($_POST["password"]))) {
    $editPassword = new Admin();
    $editPassword->editPassword($_POST["password"], $_POST["newpassword"], $_POST["confirmnewpassword"], $_GET["id"]);
} elseif (isset($_POST["newpseudo"])) {
    $editPseudo = new Admin();
    $editPseudo->editPseudo($_POST["newpseudo"], $_GET["id"]);
} elseif (isset($_POST["newemail"])) {
    $editEmail = new Admin();
    $editEmail->editEmail($_POST["newemail"], $_GET["id"]);
}

if (!isset($_POST["newpseudo"])) {
    $pseudo = $_GET["pseudo"];
} else {
    $pseudo = $_POST["newpseudo"];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier utilisateur</title>
</head>

<body>
    <h1>Modifier utilisateur : <?php echo $pseudo; ?></h1>
    <br>
    <form method="POST"><b>Modifier mot de passe :</b>
        <br><br>
        <label>Mot de passe actuel : </label>
        <br>
        <input type="password" name="password">
        <br><br>
        <label>Nouveau mot de passe : </label>
        <br>
        <input type="password" name="newpassword">
        <br><br>
        <label>Confirmer nouveau mot de passe : </label>
        <br>
        <input type="password" name="confirmnewpassword">
        <br><br>
        <input type="submit" name="submitpassword">
    </form>
    <br><br>
    <form method="POST"><b>Modifier pseudo : </b>
        <br><br>
        <label>Nouveau pseudo : </label>
        <br>
        <input type="text" name="newpseudo">
        <br><br>
        <input type="submit" name="submitpseudo">
    </form>
    <br><br>
    <form method="POST"><b>Modifier email : </b>
        <br><br>
        <label>Nouvel email : </label>
        <br>
        <input type="text" name="newemail">
        <br><br>
        <input type="submit" name="submitemail">
    </form>
</body>

>>>>>>> 4972b6d96e98a2c84997d99455e343c43cdcf1f0
</html>