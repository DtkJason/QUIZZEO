<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}
if ($_SESSION["role"] == 0) {
    header("Location: admin.php");
}
if ($_SESSION["role"] == 2) {
    header("Location: user.php");
}

$idQuizz = $_GET["idQuizz"];
$idUser = $_GET["idUser"];

$modif = new Admin();

$nbrQuestion = $modif->getNumberQuestion($idQuizz);

if (!empty($_POST["nomQuizz"])) {
    $modif->editQuizzName($idQuizz, $_POST["nomQuizz"]);
}
if (!empty($_POST["diffQuizz"])) {
    $modif->editQuizzDiff($idQuizz, $_POST["diffQuizz"]);
}

for ($i = 1; $i <= $nbrQuestion; $i++) {
    if (!empty($_POST["question$i"])) {
        $modif->editQuestionName($idQuizz, $_POST["question$i"], $i);
    }
    if (!empty($_POST["diffQuestion$i"])) {
        $modif->editQuestionDiff($idQuizz, $_POST["diffQuestion$i"], $i);
    }
    if (!empty($_POST["bonnereponse$i"])) {
        $modif->editGoodAnswer($idQuizz, $_POST["bonnereponse$i"], $i);
    }
    for ($j = 1; $j <= 3; $j++) {
        if (!empty($_POST["mauvaisereponse$i-$j"])) {
            $modif->editBadAnswer($idQuizz, $_POST["mauvaisereponse$i-$j"], $i);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de Quizz (Quizzer)</title>
</head>

<body>
    <?php
    $form = new Admin();
    $form->editQuizzForm($idQuizz);
    ?>
</body>

</html>