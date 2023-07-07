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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <?php
    require "css.php";
    ?>
    <title>Utilisateur</title>
</head>


<body>
    <?php
    require "headerUser.php";
    ?>
    <?php
    require "interro.php";
    ?>

    <div class="rolee">
        <h2>Utilisateur</h2>
    </div>
    <div class="message">
        <p>Bienvenue sur Quizzeo, le site qui permet de créer des Quizz</p>
    </div>
    
    <?php
                    $lastScore = new Quizz();
                    $score = $lastScore->recupLastScore($_SESSION["id"]);
                ?>
    
    <div class="card">
            <div class="container vertical-scrollable">
                <div class="row text-center">
                    <?php
                        $displayScores = new Admin();
                        $displayScores->displayScores($_SESSION["id"]);
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