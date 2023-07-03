<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}
if ($_SESSION["role"] != 1) {
    header("Location: accessDenied.php");
}

$getPseudo = new Admin();
$pseudo = $getPseudo->getUserPseudo($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de vos Quizz</title>
</head>

<body>
    <?php
    require "headerQuizzer.php";
    ?>
    <h2>Liste de vos Quizz</h2>

    <?php
    $display = new Quizz();
    $display->displayPersonnalQuizz($_SESSION["id"]);
    ?>

    <?php
    require "footer.php";
    ?>
</body>

</html>