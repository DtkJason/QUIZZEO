<?php
require "classes.php";

echo "ID Quizz : " . $_GET["idQuizz"];
$_SESSION["idQuizz"] = $_GET["idQuizz"];
$idQuizz = $_SESSION["idQuizz"];

$modif = new Admin();
$a = 1;
$exit = 0;

if (!empty($_POST["nomQuizz"])) {
    $modif->editQuizzName($_POST["nomQuizz"], $idQuizz);
}
// if (!empty($_POST["diffQuizz"])) {
//     //fonction update difficulté Quizz
// }

// do {
//     if (!empty($_POST["nomQuizz"]) || !empty($_POST["diffQuizz"]) || !empty($_POST["question$a"])) {
//         if (!empty($_POST["question$a"])) {
//             //fonction update intitulé Question
//         }
//         if (!empty($_POST["diffQuestion$a"])) {
//             //fonction update difficulté Quizz
//             if (!empty($_POST["bonnereponse$a"])) {
//                 //fonction
//             }
//             for ($i = 1; $i <= 3; $i++) {
//                 if (!empty($_POST["mauvaisereponse" . $a . "-" . $i])) {
//                     //fonction
//                 }
//             }
//         }
//     } else {
//         $exit = 1;
//     }
// } while ($exit == 0);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de Quizz</title>
</head>

<body>
    <?php
    $test = new Admin();
    $test->editQuizzForm($_GET["idQuizz"]);
    ?>
</body>

</html>