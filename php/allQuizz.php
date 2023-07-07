<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}
if ($_SESSION["role"] == 0) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <?php
    require "css.php";
    ?>
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
     <?php
    require "interro.php";
    ?>
     <div class="rolee">
        <h2>Liste de tous les Quizz</h2>
    </div>
    
    <div class="quizs">
    <?php
    $display = new Quizz();
    $display->displayAllQuizz();
    ?>
    </div>
    <?php
    require "logo.php";
    ?>
    <?php
    require "footer.php";
    ?>
</body>

</html>