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

if (isset($_GET["idQuizz"])) {
    $idQuizz = $_GET["idQuizz"];
}

if (isset($_GET["idUser"])) {
    $idUser = $_GET["idUser"];
}

if (empty($_GET["idQuizz"]) || empty($_GET["idUser"])) {
    header("Location: allPersonnalQuizz.php");
}

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
$getPseudo = new Admin();
$pseudo = $getPseudo->getUserPseudo($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <?php
    require "css.php";
    ?>
    <title>Modification de Quizz (Quizzer)</title>
</head>

<body>
    <?php
    require "headerQuizzer.php";
    ?>
    <?php
    require "interro.php";
    ?>
     <div class="card carrr">
            <div class="container vertical-scrollable">
                <div class="row text-center">
    <?php
    $form = new Admin();
    $form->editQuizzForm($idQuizz);
    ?>
                    </div>

</div>
</div>
    <?php
    require "logo.php";
    ?>
    <?php
    require "footer.php";
    ?>
</body>

</html>