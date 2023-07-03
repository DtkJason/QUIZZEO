<?php
require "classes.php";

if (empty($_SESSION["id"])) {
    header("Location: login.php");
}
if ($_SESSION["role"] != 0) {
    header("Location: accessDenied.php");
}

if (!empty($_GET["delete"]) && !empty($_GET["pseudoDelete"])) {
    $pseudoDelete = $_GET["pseudoDelete"];
    echo '<script type="text/javascript">';
    echo 'alert("Utilisateur supprimé : ' . $pseudoDelete . '")';
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
    <title>Gérer Membres - Administrateur</title>
</head>


<body>
    <?php
    require "headerAdmin.php";
    ?>
    <h2>Gérer les membres</h2>

    <?php
    $display = new Admin();
    $display->displayUsers();
    ?>

    <?php
    require "footer.php";
    ?>
</body>


</html>