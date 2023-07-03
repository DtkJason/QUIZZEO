<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}

$getPseudo = new Admin();
$pseudo = $getPseudo->getUserPseudo($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur</title>
</head>

<body>
    <?php
    if ($_SESSION["role"] == 0) {
        require "headerAdmin.php";
    }
    if ($_SESSION["role"] == 1) {
        require "headerQuizzer.php";
    }
    if ($_SESSION["role"] == 2) {
        require "headerUser.php";
    }
    ?>
    <p>Vous n'avez pas accès à cette page</p>
    <?php
    require "footer.php";
    ?>
</body>

</html>