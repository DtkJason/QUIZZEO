<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}
if ($_SESSION["role"] != 0) {
    header("Location: accessDenied.php");
}

if (!empty($_GET["delete"])) {
    echo '<script type="text/javascript">';
    echo 'alert("Quizz supprimé")';
    echo '</script>';
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Quizz (Admin)</title>
</head>

<?php
require "headerAdmin.php";
?>

<body>
    <h2>Liste de tous les Quizz</h2>

    <?php
    $display = new Admin();
    $display->editQuizzAdmin();
    ?>

</body>

</html>