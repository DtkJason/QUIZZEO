<?php

require "classes.php";

if (isset($_GET["idQuizz"])) {
    $idQuizz = $_GET["idQuizz"];
}

$quizz = new Admin();

$quizz->deleteQuizz($idQuizz);

header("Location: allQuizzAdmin.php?delete=1");
