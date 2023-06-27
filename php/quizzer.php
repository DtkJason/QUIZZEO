<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}

if ($_SESSION["role"] != 1) {
    header("Location: accessDenied.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizzer</title>
</head>

<?php
require "headerQuizzer.php";
?>

<body>
    <h1>Quizzer</h1>
    <p>Bienvenue sur Quizzeo, le site qui permet de créer des Quizz</p>
</body>

</html>