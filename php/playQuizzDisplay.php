<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}

$idUser = $_SESSION["id"];

$getPseudo = new Admin();
$pseudo = $getPseudo->getUserPseudo($_SESSION["id"]);

$idQuizz = $_GET["idQuizz"];

$playQuizz = new Admin();
$nbrQuestion = $playQuizz->getNumberQuestion($idQuizz);

$verifChoix = new Choix();

if (isset($_POST["submit"])) {
    $compteur = 0;
    for ($i = 1; $i <= $nbrQuestion; $i++) {
        if (isset($_POST["reponse$i"])) {
            $reponse = $_POST["reponse$i"];
            $check = $verifChoix->getGoodAnswer($idQuizz, $i);
            if ($reponse == $check) {
                $compteur++;
            }
        }
    }

    $playQuizz->insertScore($idUser, $idQuizz, $compteur);
    if ($_SESSION["role"] == 0) {
        header("Location: admin.php?score=$compteur");
    }
    if ($_SESSION["role"] == 1) {
        header("Location: quizzer.php?score=$compteur");
    }
    if ($_SESSION["role"] == 2) {
        header("Location: user.php?score=$compteur");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require "css.php";
    ?>
    <title>Quizz en cours</title>
</head>

<body>
<audio id="myAudio" autoplay loop>
        <source src="Arthur Benson - She Is Whimsical.ogg" type="audio/ogg">
        <source src="Arthur Benson - She Is Whimsical.mp3" type="audio/mpeg">
    </audio>
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


    <?php
    require "interro.php";
    ?>
   
    <br><br><br>
    <div class="slideshow-content">
    <?php
    $play = new Quizz();
    $play->displayQuizzForm($idQuizz);
    ?>
        <a class="prev" onclick="plusSlides(-1)">Précédent</a> 
        <a class="next" onclick="plusSlides(1)">Suivant</a>
    </div>
    
    <?php
    require "logo.php";
    ?>
   
    <?php
    require "footer.php";
    ?>
<script src="../js/dynamicQuiz.js"></script>
</body>

</html>