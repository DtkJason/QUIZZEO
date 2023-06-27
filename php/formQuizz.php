<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}

if (isset($_POST["submit"])) {
    if (!empty($_POST["quizz-title"]) && !empty($_POST["quizz-difficulty"]) && !empty($_POST["question1"]) && !empty($_POST["quizz-difficulty-question1"]) && !empty($_POST["goodanswer"]) && !empty($_POST["badanswer1"]) && !empty($_POST["badanswer2"]) && !empty($_POST["badanswer3"])) {
        $quizz = new Quizz();
        $newQuizz = $quizz->addQuizz($_POST["quizz-title"], intval($_POST["quizz-difficulty"]), $_SESSION["id"]);
        $idQuizz = $quizz->getIdQuizz($_POST["quizz-title"], intval($_POST["quizz-difficulty"]), $_SESSION["id"]);

        $question1 = new Question();
        $newQuestion1 = $question1->addQuestion($_POST["question1"], $_POST["quizz-difficulty-question1"]);
        $idQuestion = $question1->getIdQuestion($_POST["question1"], $_POST["quizz-difficulty-question1"]);

        $question1->addQuizzQuestion($idQuizz, $idQuestion);

        $choix = new Choix();
        $newChoix1 = $choix->addChoice($_POST["goodanswer"], true, $idQuestion);
        $newChoix2 = $choix->addChoice($_POST["badanswer1"], false, $idQuestion);
        $newChoix3 = $choix->addChoice($_POST["badanswer2"], false, $idQuestion);
        $newChoix4 = $choix->addChoice($_POST["badanswer3"], false, $idQuestion);

        echo '<script type="text/javascript">';
        echo 'alert("Votre quizz a été créé avec succès !")';
        echo '</script>';
    } else {
        echo "Veuillez compléter tous les champs !";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Quizz</title>
</head>

<body>
    <?php
    require "headerAdmin.php";
    ?>

    <h1>Création de Quizz</h1>
    <form method="POST">
        <label>Titre du Quizz : </label>
        <br>
        <input type="text" name="quizz-title">
        <br><br>
        <label>Difficulté du Quizz : </label>
        <br>
        <select name="quizz-difficulty">
            <option value=""></option>
            <option value="1">Facile</option>
            <option value="2">Intermédiaire</option>
            <option value="3">Difficile</option>
        </select>
        <br><br>
        <label>Question 1 : </label>
        <br>
        <input type="text" name="question1">
        <br>
        <label>Difficulté de la question : </label>
        <br>
        <select name="quizz-difficulty-question1">
            <option value=""></option>
            <option value="1">Facile</option>
            <option value="2">Intermédiaire</option>
            <option value="3">Difficile</option>
        </select>
        <br><br>
        <label>Bonne Réponse : </label>
        <br>
        <input type="text" name="goodanswer">
        <br><br>
        <label>Mauvaise Réponse 1 : </label>
        <br>
        <input type="text" name="badanswer1">
        <br><br>
        <label>Mauvaise Réponse 2 : </label>
        <br>
        <input type="text" name="badanswer2">
        <br><br>
        <label>Mauvaise Réponse 3 : </label>
        <br>
        <input type="text" name="badanswer3">
        <br><br>
        <input type="submit" name="submit">
    </form>

    <?php
    require "footer.php";
    ?>
</body>

</html>