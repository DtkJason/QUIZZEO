<?php

require "classes.php";

$idUser = $_GET["id"];

$member = new Admin();

$pseudo = $member->getUserPseudo($idUser);

$member->updateOwnerQuizz($idUser);
$member->deleteMember($idUser);

header("Location: adminPage.php?delete=1&pseudoDelete=$pseudo");
