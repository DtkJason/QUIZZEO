<?php
require "classes.php";

if (isset($_GET["reg"])) {
    echo '<script type="text/javascript">';
    echo 'alert("Inscription réussie")';
    echo '</script>';
}

if (isset($_SESSION["id"])) {
    if ($_SESSION["role"] == 0) {
        header("Location: admin.php");
    } elseif ($_SESSION["role"] == 1) {
        header("Location: quizzer.php");
    } else {
        header("Location: user.php");
    }
}


if (isset($_POST["submit"])) {
    $login = new Authentification();
    $login->login($_POST["email"], $_POST["password"]);
    $_SESSION["id"] = $login->getIdUser();
    $_SESSION["role"] = $login->getRoleUser();
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
    <?php
    require "headerOffline.php";
    ?>

    <form method="POST">
        <label for="mail">Email : </label>
        <br>
        <input type="mail" name="email">
        <br><br>
        <label for="password">Mot de passe : </label>
        <br>
        <input type="password" name="password">
        <br><br>
        <input type="submit" name="submit" value="Valider">
    </form>

    <?php
    require "footer.php";
    ?>
</body>

</html>