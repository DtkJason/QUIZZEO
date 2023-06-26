<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Quizz</title>
</head>

<body>
    <h1>Liste de tous les Quizz</h1>

    <?php
    $display = new Quizz();
    $display->displayAllQuizz();
    ?>

</body>

</html>