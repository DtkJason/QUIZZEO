<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}

if ($_SESSION["role"] != 2) {
    header("Location: accessDenied.php");
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
    <title>Utilisateur</title>
</head>


<body>
    <?php
    require "headerUser.php";
    ?>

    <h1>Utilisateur</h1>
    <p>Bienvenue sur Quizzeo, le site qui permet de créer des Quizz</p>

    <?php
    require "footer.php";
    ?>
</body>

</html>