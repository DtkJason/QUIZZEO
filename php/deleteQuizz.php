<?php

require "classes.php";
$idQuizz = $_GET["idQuizz"];

$quizz = new Admin();

$quizz->deleteQuizz($idQuizz);

header("Location: allQuizzAdmin.php?delete=1");
