<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}

if ($_SESSION["role"] != 0) {
    header("Location: accessDenied.php");
}

if (isset($_GET["score"])) {
    $score = $_GET["score"];
    echo '<script type="text/javascript">';
    echo 'alert("Score : ' . $score . '")';
    echo '</script>';
}

$getPseudo = new Admin();
$pseudo = $getPseudo->getUserPseudo($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylexxx.css">
    <title>Accueil - Administrateur</title>
</head>


<body>
    <?php
    require "headerAdmin.php";
    ?>

    <h2>Administrateur</h2>
    <p>Bienvenue sur Quizzeo, le site qui permet de créer des Quizz</p>

    <?php
    $lastScore = new Quizz();
    $score = $lastScore->recupLastScore($_SESSION["id"]);
    ?>

    <?php
    require "footer.php";
    ?>
</body>


</html>