<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}
if ($_SESSION["role"] == 0) {
    header("Location: accessDenied.php");
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
    <?php
    if ($_SESSION["role"] == 1) {
        require "headerQuizzer.php";
    }
    if ($_SESSION["role"] == 2) {
        require "headerUser.php";
    }
    ?>

    <h2>Liste de tous les Quizz</h2>

    <?php
    $display = new Quizz();
    $display->displayAllQuizz();
    ?>

    <?php
    require "footer.php";
    ?>
</body>

</html>