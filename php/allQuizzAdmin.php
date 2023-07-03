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

$getPseudo = new Admin();
$pseudo = $getPseudo->getUserPseudo($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Liste Quizz - Administrateur</title>
</head>


<body>
    <?php
    require "headerAdmin.php";
    ?>

    <h2>Liste de tous les Quizz</h2>

    <?php
    $display = new Admin();
    $display->listQuizzAdmin();
    ?>

    <?php
    require "footer.php";
    ?>
</body>

</html>